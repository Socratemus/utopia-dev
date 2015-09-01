<?php

namespace Cli\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;

class ProcessManager implements  ServiceLocatorAwareInterface{
    
    protected $Url;
    protected $ServiceLocator = null;
    protected $System;
    protected $Cache = null;

    
    public function __construct(){
        $this->Url = getcwd();
        $this->Url .= '/public/index.php';
        if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
        {
            $this->System = 'WIN';
        }
        else
        {
            $this->System = 'UNIX';
        }
        return $this;
    }
    
    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $ServiceLocator)
    {
        $this->ServiceLocator = $ServiceLocator;
    }

    public function getServiceLocator()
    {
        return $this->ServiceLocator;
    }
    
    /**
    * DEPRICATED
    */
    public function execute($Command = false , $Options){
        
        try
        {
            $cmd = 'php ' . $this->Url . ' sync-process 2' ; //Append parameters.            
            $cmd = escapeshellcmd($cmd);
            //session_write_close();
            if($this->System == 'WIN')
            {
                pclose(popen("start /B " . $cmd, "r"));
            }
            else
            {
               
                $filename = date('Ymd') . 'cli-command';//.$Command->getClass() .".".$Command->getMethod();
                $filename = str_replace('\\', '_', $filename);
                $pid = exec("nohup $cmd >> " . getcwd() . "/data/clilog/". $filename .".log 2>&1 & echo $!");
               
            }
            
            exit('was done!');
        }
        catch (\Exception $e)
        {
            $this->getLogger()->crit($e);
            return false;
        }
        
    }

    public function __invoke(\Cli\Entity\CommandInterface $Command)
    {
        try
        {
            $cache = $this->getCache();
            $guid = substr(strtoupper(md5($Command->getClass() . $Command->getMethod())) , 0 , 10);
            $Command->setGUID($guid);
            $em = $this->getServiceLocator()->get('EntityManager');
            
            //Get existing command by guid!
            $ckcmds = $em->getRepository('\Cli\Entity\Command')->findBy(array('GUID' => $guid,
             'Status' => \Application\Response\Status::ACTIVE ));
            if(!empty($ckcmds)){
                $Command = $ckcmds[0];
                if($cache->hasItem($Command->getCacheKey()))
                {   
                    $params = $cache->getItem($Command->getCacheKey());
                    $Command->setParams($params);
                }
                return $Command;
            }

           
            if($cache->hasItem($Command->getCacheKey()))
            {   
                $cache->removeItem($Command->getCacheKey());
            }
            
            if( !empty($Command->getParams()))
            {
                $cache->setItem($Command->getCacheKey() , $Command->getParams());    
            }

            //CHECK IF COMAND EXISTS AND WITH STATUS 200 OR SOMETHING

            //Check command and prepare it!.
            $this->exec($Command);
            $em->persist($Command);
            $em->flush();
            return $Command;

        }
        catch (\Exception $e)
        {
            echo $e->getMessage();exit;
            //$this->getLogger()->crit($e);
            $Command->setStatus(false);
            //$Command->setMessage($e->getMessage());
            return $Command;
        }
    }

    public function exec(\Cli\Entity\CommandInterface $Command ){
        try
        {
            $cmd = 'php ' . $this->Url . ' run command '.$Command->getClass().' '.$Command->getMethod().' '.$Command->getCacheKey().' ' . $Command->getGUID() ; //Append parameters.            
            $cmd = escapeshellcmd($cmd);

            //session_write_close();
            if($this->System == 'WIN')
            {
                pclose(popen("start /B " . $cmd, "r") );
                $pid = substr(strtoupper(md5('WIN'. microtime() . uniqid())),3,8);
                $Command->setPID($pid);
            }
            else
            {
               
                $filename = date('Ymd') . 'cli-command';//.$Command->getClass() .".".$Command->getMethod();
                $filename = str_replace('\\', '_', $filename);
                $pid = exec("nohup $cmd >> " . getcwd() . "/data/clilog/". $filename .".log 2>&1 & echo $!");
               
            }
            
            return $Command;

        }
        catch (\Exception $e)
        {
            $Command->setStatus(-1);
            $this->getLogger()->crit($e);
            return false;
        }
    }

    private function getCache(){
        $cache = $this->getServiceLocator()->get('cache');
        return $cache;
    }
    
    
}
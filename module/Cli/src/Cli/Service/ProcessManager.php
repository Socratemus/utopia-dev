<?php

namespace Cli\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;

class ProcessManager implements  ServiceLocatorAwareInterface{
    
    protected $Url;
    
    protected $ServiceLocator = null;
    protected $System;
    protected $Cache = null;
    protected $Logger = null;

    
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

    /**
     * Register a command on invoke
     * and also valides it
     */
    public function __invoke(\Cli\Entity\CommandInterface $Command)
    {
        try
        {
            $cache = $this->getCache();
            $guid = substr(strtoupper(md5($Command->getClass() . $Command->getMethod())) , 0 , 10);
            $Command->setGUID($guid);
            $Command->setCacheKey(substr($guid , 5, 10));
            $em = $this->getServiceLocator()->get('EntityManager');
            
            //Get existing command by guid!
            $ckcmds = $em->getRepository('\Cli\Entity\Command')->findBy(array('GUID' => $guid,
             //'Status' => \Application\Response\Status::ACTIVE
             ));
            if(!empty($ckcmds)){
                $Command = $ckcmds[0];
                if($cache->hasItem($Command->getCacheKey()))
                {   
                    $params = $cache->getItem($Command->getCacheKey());
                    $Command->setParams($params);
                }
                return $Command;
            }
            
            //Verify if class exists and if has method
            
           
            if($Command->getCacheKey() && $cache->hasItem($Command->getCacheKey()))
            {   
                $cache->removeItem($Command->getCacheKey());
            }
            
            if( !empty($Command->getParams()))
            {
                $cache->setItem($Command->getCacheKey() , $Command->getParams());    
            }

            //CHECK IF COMAND EXISTS AND WITH STATUS 200 OR SOMETHING

            //Check command and prepare it!.
            //$this->exec($Command); //Command should be executed separately
            
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
 
    /**
     * Executes a command
     */
    public function exec(\Cli\Entity\CommandInterface $Command ){
        try
        {
            if($Command->getStatus() == \Application\Response\STATUS::PENDING){
                throw new \Exception('Command is running.');
            }
            $Command->setStatus(\Application\Response\STATUS::ACTIVE);
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
                $this->getLogger()->info('EXECUTING CLI REQUEST LINUX');
                $pid = exec("nohup $cmd >> " . getcwd() . "/data/clilog/". $filename .".log 2>&1 & echo $!");
                $Command->setPID($pid);                
            }
            
            $em = $this->getServiceLocator()->get('EntityManager');
            
            $em->persist($Command);
            $em->flush();
            
            return $Command;

        }
        catch (\Exception $e)
        {
            $Command->setStatus(-1);
            $this->getLogger()->crit($e);
            return false;
        }
    }

    /**
     * Returns a coomand by its GUID
     */
    public function getCommandByGUID($GUID){
        
        $em = $this->getServiceLocator()->get('EntityManager');
            
        //Get existing command by guid!
        $commands = $em->getRepository('\Cli\Entity\Command')->findBy(array('GUID' => $GUID,
         //'Status' => \Application\Response\Status::ACTIVE
        ));
        
        if(empty($commands)){
            throw new \Exception('Command with given GUID does not exists[' . $GUID . ']');
        }
        
        $command = $commands[0];
        
        return $command;
    }

    private function getCache(){
        $cache = $this->getServiceLocator()->get('cache');
        return $cache;
    }
    
    private function getLogger(){
        if( ! isset($this->Logger))
        {
            $this->Logger = $this->getServiceLocator()->get('Log\Factory\LogFactory')->getLogger();
        }
        return $this->Logger;
        
    }
    
    
}
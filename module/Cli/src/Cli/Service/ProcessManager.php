<?php

namespace Cli\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;

class ProcessManager {
    
    protected $Url;
    protected $ServiceLocator;
    protected $System;
    
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
    
    public function setServiceLocator(ServiceLocatorInterface $ServiceLocator)
    {
        $this->ServiceLocator = $ServiceLocator;
    }

    public function getServiceLocator()
    {
        return $this->ServiceLocator;
    }
    
    public function execute($Command = false , $Options){
        
        try
        {
            //$cmd = 'php ' . $this->Url . ' run command ' . $Command->getClass() . ' ' . $Command->getMethod() . ' ' . $Command->getCacheKey() . ' ' . $Command->getKey();
            
            $cmd = 'php ' . $this->Url . ' sync-process 2' ; //Append parameters.            
            //var_dump($cmd);exit();
            //$this->getLogger()->debug($cmd);
            $cmd = escapeshellcmd($cmd);
            //session_write_close();
            if($this->System == 'WIN')
            {
                pclose(popen("start /B " . $cmd, "r"));
                //$Command->setPID($Command->getKey());
                //$Command->setStatus(true);
            }
            else
            {
                //exit('e unix');
                $filename = date('Ymd') . 'cli-command';//.$Command->getClass() .".".$Command->getMethod();
                $filename = str_replace('\\', '_', $filename);
                $pid = exec("nohup $cmd >> " . getcwd() . "/data/clilog/". $filename .".log 2>&1 & echo $!");
                //$Command->setPID($pid);
                //$Command->setStatus(true);
            }
            //@session_start();
            //$this->save($Command);
            //sleep(1);
            //return $Command;
            
            exit('was done!');
        }
        catch (\Exception $e)
        {
            $this->getLogger()->crit($e);
            $Command->setPID(null);
            $Command->setStatus(false);
            $Command->setMessage($e->getMessage());
            return $Command;
        }
        
    }
    
    
}
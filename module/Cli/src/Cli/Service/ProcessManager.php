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
    
    
}
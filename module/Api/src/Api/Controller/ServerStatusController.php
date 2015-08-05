<?php


namespace Api\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class ServerStatusController extends AbstractActionController
{
    public function indexAction()
    {   
        try
        {
            $memory = $this->getMemory();
            $localIp = $this->getIp();
            $processes = $this->getProcesses();
            $uptime = $this->getUptime();
            $variables = array(
                'memory' => $memory,
                'listening_ip' => $localIp,
                'uptime' => $uptime,
                'processes' => $processes
            );
            
            $this->JsonResponse->setVariables($variables);
            $this->JsonResponse->setMessage('This is the server interface.');
            $this->JsonResponse->setSucceed(0);
            
            return $this->JsonResponse;
        }
        catch(\Exception $e){
            $this->JsonResponse->setMessage($e->getMessage());
            $this->JsonResponse->setFailed(1);
            return $this->JsonResponse;
        }
       
    }
    
    private function getMemory()
    {
        $data = explode("\n", file_get_contents("/proc/meminfo"));
        $meminfo = array();
        foreach ($data as $line) {
            list($key, $val) = explode(":", $line);
            $meminfo[$key] = trim($val);
        }
        //var_dump($meminfo);exit;
        $total = explode(' ' , $meminfo['MemTotal']) ;
        $total = $total[0];
        $free = explode(' ' , $meminfo['MemFree']);
        $free = $free[0];
        
        $used = $total - $free;
        
        //var_dump($used / 1024 / 1024);exit;
        
        return array('total' => $total , 'used' => $used , 'free' => $free , 'unit' => 'KiB');
    }
    
    private function getIp()
    {
        $command="/sbin/ifconfig eth0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'";
        $localIP = exec ($command);
        return $localIP;
    }
    
    private function getProcesses()
    {
       
        exec("ps -aux", $output);
        unset($output[0]);
        $ret = array();
        foreach($output as &$processLine):
            $processLine = preg_replace('!\s+!', '_', $processLine);
            $prsArr = explode('_' , $processLine);
            $tmpprs = array(
                'user' => $prsArr[0],
                'pid'  => $prsArr[1],
                'cpu' => $prsArr[2],
                'mem' => $prsArr[3],
                'status' => $prsArr[7]
            );
            
            array_push($ret,$tmpprs);
            unset($tmpprs);
          
            
        endforeach;
       return $ret;
    }
    
    private function getUptime(){
        exec("uptime", $system); // get the uptime stats 
       
        $string = $system[0]; // this might not be necessary 
        $uptime = explode(" ", $string); // break up the stats into an array 
        //var_dump($uptime);exit;
        $up_days = $uptime[3]; // grab the days from the array 
        
        $hours = explode(":", $uptime[5]); // split up the hour:min in the stats 
        
        $up_hours = $hours[0]; // grab the hours 
        $mins = $hours[1]; // get the mins 
        $up_mins = str_replace(",", "", $mins); // strip the comma from the mins 
        
        return array('days' => $up_days , 'hours' => $up_hours,'min' => $up_mins);
        
    }
   
}
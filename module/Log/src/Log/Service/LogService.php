<?php

namespace Log\Service;

class LogService {
    
    private $ServiceLocator;
    
    protected $Logger;
    
    protected $Configuration;
    
    public function __construct($ServiceLocator){
        $this->ServiceLocator = $ServiceLocator;
        $log = new \Zend\Log\Logger(); 
        $logfile = $this->getLogFile();
        $filewriter = new \Zend\Log\Writer\Stream($logfile);
        $log->addWriter($filewriter);
        $dbwriter = $this->getDbWritter();
        if($dbwriter){
            $log->addWriter($dbwriter);    
        }
        
        $this->setLogger($log);

    }
    
    public function getLogger(){
        return $this->Logger;   
    }
    
    public function setLogger($Logger){
        $this->Logger = $Logger;
    }
    
    
    /**
     * Return the log file path
     *
     */
    private function getLogFile(){
        
        $filePath = './data/logs/logfile-'.date('Y-m-d').'.log';
        
        if (!file_exists($filePath)) {
            if (!file_exists('./data/logs')) {
                mkdir('./data/logs', 0777, true);
            }
            fopen($filePath, "w");
        }
        return $filePath;
    }
    
    private function getDbWritter(){
        try {
            $sm = $this->ServiceLocator;
            $dbconfig = array(
                // Sqlite Configuration
                'driver' => 'Pdo',
                'dsn' => 'sqlite:' . __DIR__ . '/tmp/sqlite.db',
            );
            /* @var $em \Doctrine\ORM\EntityManager */
            $em = $sm->get('doctrine.entitymanager.orm_default');
            $dbconf = $em->getConnection()->getParams();
            $dbconf['driver'] = 'PDOMySql';
            $db = new \Zend\Db\Adapter\Adapter($dbconf);

            $mapping = array(
                'timestamp' => 'Timestamp',
                'priority' => 'PriorityId',
                'priorityName' => 'PriorityName',
                'message' => 'Message',
                'extra' => array(
                    'url' => 'Url',
                    'ipaddress' => 'IpAddress'
                )
            );
            $writer = new \Zend\Log\Writer\Db($db, 'app_log', $mapping);
            return $writer;
        } catch (\Exception $e) {
            return null;
        }
    }
    
}
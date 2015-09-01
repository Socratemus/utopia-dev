<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController as ZFAbstractActionController;
use Application\Exception;
use Application\Response\JsonResponse;

class AbstractActionController extends ZFAbstractActionController
{
    
    protected $Logger;
    protected $Cache;
    protected $ProcessManager;
    protected $EntityManager;
    
    public function __construct()
    {
        \Zend\Json\Json::$useBuiltinEncoderDecoder = true;
        $this->JsonResponse = new JsonResponse();
    }
    
    public function getProcessManager()
    {
        if( ! isset($this->ProcessManager))
        {
            $this->ProcessManager = $this->getServiceLocator()->get('ProcessManager');
        }
        return $this->ProcessManager;
    }
    
    public function getLogger()
    {
        if( ! isset($this->Logger))
        {
            $this->Logger = $this->getServiceLocator()->get('Log\Factory\LogFactory')->getLogger();
        }
        return $this->Logger;
    }

    public function getCache()
    {
        if( ! isset($this->Cache))
        {
            $this->Cache = $this->getServiceLocator()->get('cache');
        }
        return $this->Cache;
    }
    
    public function getPayload(){
        $raw = $this->getRequest()->getContent();
        $data = json_decode($raw , 1);
        foreach($data as $key => $value) {
            if($key[0] == '_') {
                unset($data[$key]);
            }
        }
        /**
         * @TODO
         * Iterate through array properties and remove the ones starting with underscore.
         */
        return $data;
    }
    
    protected function getBasePath(){
        $uri = $this->getRequest()->getUri();
        $scheme = $uri->getScheme();
        $host = $uri->getHost();
        $base = sprintf('%s://%s', $scheme, $host);
        return $base;
    }

    protected function getEntityManager(){
        if(!$this->EntityManager){
            $this->EntityManager = $this->getServiceLocator()->get('EntityManager');
        }
        return $this->EntityManager;
    }
}








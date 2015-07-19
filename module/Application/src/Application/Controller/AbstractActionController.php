<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController as ZFAbstractActionController;
use Application\Exception;
use Application\Response\JsonResponse;

class AbstractActionController extends ZFAbstractActionController
{
    
    protected $Logger;
    protected $ProcessManager;
    
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
}
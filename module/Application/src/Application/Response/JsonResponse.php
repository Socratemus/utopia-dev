<?php

namespace Application\Response;

use Zend\View\Model\JsonModel;
use Application\Response\ResponseInterface as AppResponseInterface;
use Application\Response\Response as AppResponse;
use Application\Utils\Object as AppObject;

class JsonResponse extends JsonModel
{
    protected $__container;

    public function __construct($variables = null, $options = null) {
        //$this->__container = array('data');
        parent::__construct($variables, $options);
        $this->setVariable('Object', array());
        $this->setVariable('Status', 1, true);
        $this->setVariable('Succeded', 0, true);
        $this->setVariable('Failed', 0, true);
        $this->setVariable('Message', 'Default message');
    }

    public function setVariable($Name, $Value, $Priority = false) {
        parent::setVariable($Name, $Value);
    }

    public function setVariables($Values) {
        parent::setVariable('Object',$Values);
    }
    
    public function setFailed(){
        $this->setVariable('Status', 2, true);
        $this->setVariable('Failed', 1,true);
        $this->setVariable('Succeded', 0,true);
    }
    
    public function setSucceed(){
        $this->setVariable('Succeded', 1,true);
    }
    
    public function setMessage($Message){
        $this->setVariable('Message', $Message);
    }
}
<?php

namespace Cron\Service;

class CronManager implements \Zend\ServiceManager\ServiceLocatorAwareInterface{
	protected $ServiceManager = null;

	public function __construct(){

	}

	public function _cr_task_Testing(){
		return __METHOD__;
	}

	public function _cr_task_Testing2(){
		return __METHOD__;	
	}

	public function test(){
		//$this->getServiceLocator()->get('Log\Factory\LogFactory')->getLogger()->crit('FTW');;
		return 'helloz';
	}

	public function __toString(){
		return __CLASS__;
	}
	/***********************************************************************/
	public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator){
		$this->ServiceManager = $serviceLocator;
	}
	public function getServiceLocator(){
		return $this->ServiceManager;
	}
	/***********************************************************************/
}

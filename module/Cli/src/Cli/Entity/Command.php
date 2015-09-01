<?php

namespace Cli\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="command")
 */
Class Command extends \Application\Entity\Entity implements CommandInterface {

	/**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
	protected $CommandId;
	
	/**
     * @ORM\Column(type="string" , length=10 , nullable = true)
     */
	protected $GUID;
	
	/**
     * @ORM\Column(type="string" , length=25 , nullable = true)
     */
	protected $PID;

	/**
     * @ORM\Column(type="string" , length=255 , nullable = false)
     */
	protected $Class;

	/**
     * @ORM\Column(type="string" , length=255 , nullable = false)
     */
	protected $Method;

	/**
     * @ORM\Column(type="string" , length=255 , nullable = false)
     */
	protected $CacheKey;

	protected $Params;

	/**
     * @ORM\Column(type="text" , nullable = true)
     */
	protected $Message = null;

	public function __construct($Class = null , $Method = null , $CacheKey = null, $Params = array()){
		parent::__construct();

		if($Class) {
			$this->setClass($Class);
		}

		if($Method) {
			$this->setMethod($Method);
		}

		if($CacheKey) {
			$this->setCacheKey($CacheKey);
		}

		if($Params) {
			$this->setParams($Params);
		}

	}
	/****************************************************/
	public function getCommandId(){
		return $this->CommandId;
	}
	public function getGUID(){
		return $this->GUID;	
	}
	public function getPID(){
		return $this->PID;
	}
	public function getClass(){
		return $this->Class;
	}
	public function getMethod(){
		return $this->Method;
	}
	public function getCacheKey(){
		return $this->CacheKey;
	}
	public function getParams(){
		return $this->Params;
	}
	public function getMessage()
	{
		return $this->Message;
	}
	public function addParam($Param){}

	public function setId($CommandId){
		$this->CommandId = $CommandId;
	}
	public function setGUID($Key){
		$this->GUID = $Key;
	}
	public function setPID($PID){
		$this->PID = $PID; 
	}
	public function setClass($Class){
		$this->Class = $Class;
	}
	public function setMethod($Method){
		$this->Method = $Method;
	}
	public function setCacheKey($CacheKey){
		$this->CacheKey = $CacheKey;
	}
	public function setParams(array $Params){
		$this->Params = $Params;
	}
	public function setMessage($Message)
	{
		$this->Message = $Message;
	}

	/****************************************************/
}

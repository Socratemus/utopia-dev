<?php

/**
 * @author Corneliu Iancu <corneliu.iancu27@gmail.com>
 * @Date Sept 22, 2015
 * @copyright (c) 2015, Corneliu Iancu
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * @ORM\Entity
 * @ORM\Table(name="account")
 */
class Account extends Entity {
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $AccountId;
    
    /** 
     * @ORM\Column(type="string") 
     */
    protected $Title;
    
    /** 
     * @ORM\Column(type="string") 
     */
    protected $Subtitle;
    
    /**
     * @ORM\Column(type="decimal",precision=10, scale=4 , nullable=true)
     */
    protected $Founds = null;
    
    /** 
     * @ORM\Column(type="string") 
     */
    protected $Currency;
    
    private $Records = null;
    
    public function __construct(){
        parent::__construct();
    }
    /******************************************************/
    public function getAccountId(){
        return $this->AccountId;
    }
    public function getTitle(){
        return $this->Title;
    }
    public function getSubtitle(){
        return $this->Subtitle;
    }
    public function getFounds(){
        return $this->Founds;
    }
    public function getCurrency(){
        return $this->Currency;
    }
    
    public function setAccountId($AccountId){
        $this->AccountId = $AccountId;
    }
    public function setTitle($Title){
        $this->Title = $Title;
    }
    public function setSubtitle($Subtitle){
        $this->Subtitle = $Subtitle;
    }
    public function setFounds($Founds){
        $this->Founds = $Founds;
    }
    public function setCurrency($Currency){
        $this->Currency = $Currency;
    }
    /******************************************************/
    
    
}
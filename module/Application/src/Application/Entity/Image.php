<?php

/**
 * @author Corneliu Iancu <corneliu.iancu27@gmail.com>
 * @Date Oct 25, 2014
 * @copyright (c) 2014, Corneliu Iancu
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * @ORM\Entity
 * @ORM\Table(name="image")
 */
class Image extends Entity implements AbstractEntity {
    
    public static $DIMENTIONS = array(
        'HUGE' => array('width' => '1600', 'height' => '1400'),
        'MEDIUM' => array('width' => '800', 'height' => '700'),
        'SMALL' => array('width' => 440 , 'height' => 360),
    );
    
     /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $ImageId;
    
    /** 
     * @ORM\Column(type="string") 
     */
    protected $GUID;
    
    /** 
     * @ORM\Column(type="string") 
     */
    protected $Folder;
    
    /** 
     * @ORM\Column(type="string") 
     */
    protected $Small;
    
    /** 
     * @ORM\Column(type="string") 
     */
    protected $Medium;
    
    /** 
     * @ORM\Column(type="string") 
     */
    protected $Huge;
    
    public function __construct(){
        parent::__construct();
    }
    
    /************************************************************************/
    public function getImageId(){
        return $this->ImageId;
    }
    public function getSmall(){
        return $this->Small;
    }
    public function getMedium(){
        return $this->Medium;
    }
    public function getHuge(){
        return $this->Huge;
    }
    public function getGUID(){
        return $this->GUID;
    }
    public function getFolder(){
        return $this->Folder;
    }
    
    public function setSmall($Small){
        $this->Small = $Small;
    }
    public function setMedium($Medium){
        $this->Medium = $Medium;   
    }
    public function setHuge($Huge){
        $this->Huge = $Huge;
    }
    public function setGUID($GUID){
        $this->GUID = $GUID;
    }
    public function setFolder($Folder){
       $this->Folder = $Folder;
    }
    /************************************************************************/
    
    /************************************************************************/
    public function toJSON(){
        
    }
    
    public function toArray(){
        $ret = array(
            'ImageId'        => $this->getImageId(),
            'Small'     => $this->getSmall(),
            'Medium'    => $this->getMedium(),
            'Huge'      => $this->getHuge(),
            'Folder'    => $this->getFolder()
        );
        
        
        return $ret;
        
    }
}
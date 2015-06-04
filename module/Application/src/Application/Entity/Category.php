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
 * @ORM\Table(name="category")
 */
class Category {
    
     /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $CategoryId;
    
    /** 
     * @ORM\Column(type="string") 
     */
    protected $Title;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $Created;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $Updated;
    
    public function __construct(){
        $this->Created = new \DateTime('now');
        $this->Updated = new \DateTime('now');
    }
    
    public function getTitle(){
        return $this->Title;
    }
    public function getCreated(){
        return $this->Created;
    }
    public function getUpdated(){
        return $this->Updated;
    }
    public function setTitle($Title){
        $this->Title = $Title;
    }
    public function setCreated($Created){
        $this->Created = $Created;
    }
    public function setUpdated($Updated){
        $this->Updated = $Updated;
    }
    
    
    
    
}
<?php

/**
 * @author Corneliu Iancu <corneliu.iancu27@gmail.com>
 * @Date Oct 25, 2014
 * @copyright (c) 2014, Corneliu Iancu
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Application\Entity\AbstractEntity as AbstractEntity;


/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category implements AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $CategoryId;

    /** 
     * @ORM\Column(type="string") 
     * 
     */
    protected $Name;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $Created;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $Updated;
    
    public function __construct() {
        $this->Created = new \DateTime('now');
        $this->Updated = new \DateTime('now');
    }

    public function getCategoryId() {
        return $this->CategoryId;
    }

    public function getName() {
        return $this->Name;
    }

       public function getCreatedAt() {
        return $this->CreatedAt;
    }

    public function getUpdatedAt() {
        return $this->UpdatedAt;
    }

    public function SetCategoryId($CategoryId) {
        $this->CategoryId = $Id;
    }

    public function setName($Name) {
        $this->Name = $Name;
    }

    public function setCreatedAt($CreatedAt) {
        $this->CreatedAt = $CreatedAt;
    }

    public function setUpdatedAt($UpdatedAt) {
        $this->UpdatedAt = $UpdatedAt;
    }
    
    public function toJSON(){
        return array();
    }

}
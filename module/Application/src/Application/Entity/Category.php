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
 * @Annotation\Name("category")
 */
class Category {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * 
     * @Annotation\Attributes({"type":"hidden"})
     */
    protected $Id;

    /** 
     * @ORM\Column(type="string") 
     * 
     * @Annotation\Name("Name")
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Options({"label":"Category name:"})
     * @Annotation\Validator({"name":"StringLength","options":{"min":2,"max":64}})
     * @Annotation\Required(true)
     */
    protected $Name;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Annotation\Exclude()
     */
    protected $CreatedAt;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Annotation\Exclude()
     */
    protected $UpdatedAt;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="Parent")
     * 
     * @Annotation\Exclude()
     */
    
    
    public function __construct() {
        $this->CreatedAt = new \DateTime('now');
        $this->UpdatedAt = new \DateTime('now');
    }

    public function getId() {
        return $this->Id;
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

    public function setId($Id) {
        $this->Id = $Id;
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

}
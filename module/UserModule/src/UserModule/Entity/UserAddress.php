<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace UserModule\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Engine\Entity\AbstractEntity;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="user_address")
 *
 */
class UserAddress extends AbstractEntity {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $Id;
    
    /**
     * @ORM\Column(type="string", length=150) 
     * 
     * @Annotation\Name("Name")
     * @Annotation\Attributes({"type":"text", "class":"form-control"})
     * @Annotation\Validator({"name":"StringLength","options":{"min":2,"max":150}})
     * @Annotation\Required(true)
     */
    protected $Name;
    
    /**
     * @ORM\Column(type="string", length=150) 
     * 
     * @Annotation\Name("Title")
     * @Annotation\Attributes({"type":"text", "class":"form-control"})
     * @Annotation\Validator({"name":"StringLength","options":{"min":2,"max":150}})
     * @Annotation\Required(true)
     */
    protected $Title;
    
    /**
     * @ORM\Column(type="string") 
     * 
     * @Annotation\Name("PrimaryAddress")
     * @Annotation\Attributes({"class":"form-control"})
     * @Annotation\Attributes({"type":"textarea"})
     * @Annotation\Validator({"name":"StringLength","options":{"min":1,"max":1500}})
     * @Annotation\Required(true)
     */
    protected $PrimaryAddress;
    
    /**
     * @ORM\Column(type="string") 
     * @Annotation\Name("SecondaryAddress")
     * @Annotation\Attributes({"class":"form-control"})
     * @Annotation\Attributes({"type":"textarea"})
     * @Annotation\Validator({"name":"StringLength","options":{"min":1,"max":1500}})
     * @Annotation\Required(false)
     */
    protected $SecondaryAddress;
    
    /**
     * @ORM\Column(type="string", length=16) 
     * @Annotation\Name("Phone")
     * @Annotation\Attributes({"type":"text", "class":"form-control"})
     * @Annotation\Validator({"name":"StringLength","options":{"min":8,"max":16}})
     * @Annotation\Required(true)
     */
    protected $Phone;
    
    /**
     * @ORM\Column(type="string", length=32) 
     * @Annotation\Name("Fax")
     * @Annotation\Attributes({"type":"text", "class":"form-control"})
     * @Annotation\Validator({"name":"StringLength","options":{"min":0,"max":32}})
     * @Annotation\Required(false)
     */
    protected $Fax;
    
    /**
     * @ORM\Column(type="string", length=90)
     * @Annotation\Name("Email")
     * @Annotation\Attributes({"type":"email", "class":"form-control"})
     * @Annotation\Validator({"name":"StringLength","options":{"min":0,"max":100}})
     * @Annotation\Required(true) 
     */
    protected $Email;
    
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Annotation\Exclude()
     */
    protected $CreatedAt;
    
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Annotation\Exclude()
     */
    protected $UpdatedAt;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="UserModule\Entity\User")
     * @ORM\JoinColumn(name="User", referencedColumnName="Id" , nullable = false)
     * @Annotation\Exclude()
     */
    private $User;
    
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

    public function getTitle() {
        return $this->Title;
    }

    public function getPrimaryAddress() {
        return $this->PrimaryAddress;
    }

    public function getSecondaryAddress() {
        return $this->SecondaryAddress;
    }

    public function getPhone() {
        return $this->Phone;
    }

    public function getFax() {
        return $this->Fax;
    }

    public function getEmail() {
        return $this->Email;
    }

    public function getCreatedAt() {
        return $this->CreatedAt;
    }

    public function getUpdatedAt() {
        return $this->UpdatedAt;
    }

    public function setId($Id) {
        $this->Id = $Id;
        return $this;
    }

    public function setName($Name) {
        $this->Name = $Name;
        return $this;
    }

    public function setTitle($Title) {
        $this->Title = $Title;
        return $this;
    }

    public function setPrimaryAddress($PrimaryAddress) {
        $this->PrimaryAddress = $PrimaryAddress;
        return $this;
    }

    public function setSecondaryAddress($SecondaryAddress) {
        $this->SecondaryAddress = $SecondaryAddress;
        return $this;
    }

    public function setPhone($Phone) {
        $this->Phone = $Phone;
        return $this;
    }

    public function setFax($Fax) {
        $this->Fax = $Fax;
        return $this;
    }

    public function setEmail($Email) {
        $this->Email = $Email;
        return $this;
    }

    public function setCreatedAt(\DateTime $CreatedAt) {
        $this->CreatedAt = $CreatedAt;
        return $this;
    }

    public function setUpdatedAt(\DateTime $UpdatedAt) {
        $this->UpdatedAt = $UpdatedAt;
        return $this;
    }
    
    public function getUser() {
        return $this->User;
    }

    public function setUser($User) {
        $this->User = $User;
        return $this;
    }


}
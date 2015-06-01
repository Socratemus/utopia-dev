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
 * @ORM\Table(name="billing_address")
 *
 */
class BillAddress extends AbstractEntity
{

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
     * @Annotation\Attributes({"type":"textarea", "class":"form-control"})
     * @Annotation\Validator({"name":"StringLength","options":{"min":2,"max":1500}})
     * @Annotation\Required(true)
     */
    protected $PrimaryAddress;

    /**
     * @ORM\Column(type="string") 
     *
     * @Annotation\Name("SecondaryAddress")
     * @Annotation\Attributes({"type":"textarea", "class":"form-control"})
     * @Annotation\Validator({"name":"StringLength","options":{"min":2,"max":1500}})
     * @Annotation\Required(false)
     */
    protected $SecondaryAddress;

    /**
     * @ORM\Column(type="string", length=16) 
     * 
     * @Annotation\Name("Phone")
     * @Annotation\Attributes({"type":"numeric", "class":"form-control"})
     * @Annotation\Validator({"name":"StringLength","options":{"min":2,"max":12}})
     * @Annotation\Required(true)
     */
    protected $Phone;

    /**
     * @ORM\Column(type="string", length=32) 
     * 
     * @Annotation\Name("Fax")
     * @Annotation\Attributes({"type":"numeric", "class":"form-control"})
     * @Annotation\Validator({"name":"StringLength","options":{"min":2,"max":20}})
     * @Annotation\Required(true)
     */
    protected $Fax;

    /**
     * @ORM\Column(type="string", length=90) 
     * 
     * @Annotation\Name("Email")
     * @Annotation\Attributes({"type":"email", "class":"form-control"})
     * @Annotation\Validator({"name":"EmailAddress","options":{"domain":"true","hostname":"true", "message" : "Invalid email address"}})
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
     * @ORM\OneToOne(targetEntity="\Item\Entity\Order",mappedBy="BillingAddress",cascade={"persist"})
     */
    private $Order;
    
    public function __construct()
    {
        $this->CreatedAt = new \DateTime('now');
        $this->UpdatedAt = new \DateTime('now');
    }

    public function getId()
    {
        return $this->Id;
    }

    public function getName()
    {
        return $this->Name;
    }

    public function getTitle()
    {
        return $this->Title;
    }

    public function getPrimaryAddress()
    {
        return $this->PrimaryAddress;
    }

    public function getSecondaryAddress()
    {
        return $this->SecondaryAddress;
    }

    public function getPhone()
    {
        return $this->Phone;
    }

    public function getFax()
    {
        return $this->Fax;
    }

    public function getEmail()
    {
        return $this->Email;
    }

    public function getCreatedAt()
    {
        return $this->CreatedAt;
    }

    public function getUpdatedAt()
    {
        return $this->UpdatedAt;
    }

    public function setId($Id)
    {
        $this->Id = $Id;
        return $this;
    }

    public function setName($Name)
    {
        $this->Name = $Name;
        return $this;
    }

    public function setTitle($Title)
    {
        $this->Title = $Title;
        return $this;
    }

    public function setPrimaryAddress($PrimaryAddress)
    {
        $this->PrimaryAddress = $PrimaryAddress;
        return $this;
    }

    public function setSecondaryAddress($SecondaryAddress)
    {
        $this->SecondaryAddress = $SecondaryAddress;
        return $this;
    }

    public function setPhone($Phone)
    {
        $this->Phone = $Phone;
        return $this;
    }

    public function setFax($Fax)
    {
        $this->Fax = $Fax;
        return $this;
    }

    public function setEmail($Email)
    {
        $this->Email = $Email;
        return $this;
    }

    public function setCreatedAt(\DateTime $CreatedAt)
    {
        $this->CreatedAt = $CreatedAt;
        return $this;
    }

    public function setUpdatedAt(\DateTime $UpdatedAt)
    {
        $this->UpdatedAt = $UpdatedAt;
        return $this;
    }
    
    public function getArrayCopy() {

        $data = get_object_vars($this);
        return $data;
    }
    
    public function exchangeArray($Data)
    {
        $this->Name = isset($Data['Name']) ? $Data['Name'] : NULL;
        $this->Title = isset($Data['Title']) ? $Data['Title'] : NULL;
        $this->PrimaryAddress = isset($Data['PrimaryAddress']) ? $Data['PrimaryAddress'] : NULL;
        $this->SecondaryAddress = isset($Data['SecondaryAddress']) ? $Data['SecondaryAddress'] : NULL;
        $this->Fax = isset($Data['Fax']) ? $Data['Fax'] : NULL;
        $this->Phone = isset($Data['Phone']) ? $Data['Phone'] : NULL;
        $this->Email = isset($Data['Email']) ? $Data['Email'] : NULL;
    }

}

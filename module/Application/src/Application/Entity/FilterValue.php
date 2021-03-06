<?php

/**
 * @author Corneliu Iancu <corneliu.iancu27@gmail.com>
 * @Date Oct 25, 2014
 * @copyright (c) 2014, Corneliu Iancu
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="filter_value")
 */
class FilterValue extends Entity implements AbstractEntity{
     
     /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $FilterValueId;
    
    /**
     * @ORM\Column(type="string" , length=255 , nullable = false)
     */
    protected $Slug;
    
    /**
     * @ORM\Column(type="string" , length=255 , nullable = false)
     */
    protected $Value;
    
    /**
     * @ORM\Column(type="integer" , nullable = false)
     */
    protected $FilterId;
    
    /**
     * @ORM\ManyToOne(targetEntity="Filter",inversedBy="FilterValues",cascade={"persist"})
     * @ORM\JoinColumn(name="FilterId", referencedColumnName="FilterId" ,onDelete="CASCADE" , nullable = false)
     */
    private $Filter;
    
    /**
     * @ORM\Column(type="integer" , nullable = false)
     */
    protected $ItemId;
    
    /**
     * @ORM\ManyToOne(targetEntity="Item",inversedBy="SpecificationsValues",cascade={"persist"})
     * @ORM\JoinColumn(name="Item", referencedColumnName="ItemId" ,onDelete="CASCADE" , nullable = false)
     */
    private $Item;
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**************************************************************************/
    public function getFilterValueId(){
        return $this->FilterValueId;
    }
    public function getSlug(){
        return $this->Slug;
    }
    public function getValue(){
        return $this->Value;
    }
    public function getFilterId(){
        return $this->FilterId;
    }
    public function getFilter(){
        return $this->Filter;
    }
    public function getItemId(){
        return $this->ItemId;
    }
    public function getItem(){
        return $this->Item;
    }
    
    public function setFilterValueId($FilterValueId){
        $this->FilterValueId = $FilterValueId;
    }
    public function setSlug($Slug){
        $this->Slug = $Slug;
    }
    public function setValue($Value){
        $this->Value = $Value;
    }
    public function setFilterId($FilterId){
        $this->FilterId = $FilterId;
    }
    public function setFilter($Filter){
        $this->Filter = $Filter;
    }
    public function setItemId($ItemId){
        $this->ItemId = $ItemId;
    }
    public function setItem($Item){
        $this->Item = $Item;
    }
    /**************************************************************************/
    public function toJson(){}
    
    
}
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
 * @ORM\Table(name="filter")
 */
class Filter extends Entity implements AbstractEntity{
    
     /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $FilterId;
    
    /**
     * @ORM\Column(type="string" , length=255 , nullable = false)
     */
    protected $Title;
    
    /**
     * @ORM\Column(type="string" , length=255 , nullable = false)
     */
    protected $Slug;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category",inversedBy="Filters")
     * @ORM\JoinColumn(name="Category", referencedColumnName="CategoryId" ,onDelete="CASCADE" , nullable = false)
     */
    private $Category;
    
    /** @ORM\OneToMany(targetEntity="FilterValue", mappedBy="Filter",cascade={"persist"}) */
    private $FilterValues;
    
    public function __construct()
    {
        parent::__construct();
        $this->FilterValues = new ArrayCollection();
    }
    /**************************************************************************/
    
    public function getFilterId(){
        return $this->FilterId;
    }
    public function getTitle(){
        return $this->Title;
    }
    public function getSlug(){
        return $this->Slug;
    }
    public function getCategoryId(){
        return $this->CategoryId;
    }
    public function getCategory(){
        return $this->Category;
    }
    public function getFilterValues(){
        return $this->FilterValues;
    }
    
    public function setFilterId($FilterId){
        $this->FilterId = $FilterId;
    }
    public function setTitle($Title){
        $this->Title = $Title;
    }
    public function setSlug($Slug){
        $this->Slug = $Slug;
    }
    public function setCategoryId($CategoryId){
        $this->CategoryId = $CategoryId;
    }
    public function setCategory($Category){
        $this->Category = $Category;
    }
    public function setFilterValues($FilterValues){
        $this->FilterValues = $FilterValues;
    }
    
    /**************************************************************************/
    public function toJson(){}
    
    public function toArray()
    {
        $tmp = array();
        foreach($this->getFilterValues() as $fv)
        {
            $tmp[$fv->getItem()->getItemId()] = $fv->toArray();
        }
        
        $data = array(
            'FilterValues' => $tmp    
        );
        $parent = parent::toArray();
        return array_merge($data, $parent);
    }
}
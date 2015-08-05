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
 * @ORM\Table(name="item")
 */
class Item extends Entity implements AbstractEntity{
    
     /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $ItemId;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $Title;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $Slug;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $Description;
    
    /**
     * @ORM\OneToOne(targetEntity="Product",mappedBy="Item",cascade={"persist"})
     */ 
    private $Product;
    
    /**
     * @ORM\OneToOne(targetEntity="Image", cascade = {"persist"})
     * @ORM\JoinColumn(name="Cover", referencedColumnName="ImageId")
     **/
    private $Cover;
    
    /********************************************************/
    public function __construct(){
         parent::__construct();
         $this->Product = new Product();
         $this->Product->setItem($this);
    }
    /********************************************************/
  
    public function getItemId(){
        return $this->ItemId;
    }
    public function getTitle(){
        return $this->Title;
    }
    public function getSlug(){
        return $this->Slug;
    }
    public function getDescription(){
        return $this->Description;
    }
    public function getProduct(){
        return $this->Product;
    }
    public function getCover(){
        return $this->Cover;
    }
    
    public function setItemId($ItemId){
        $this->ItemId = $ItemId;
    }
    public function setTitle($Title){
        $this->Title = $Title;
    }
    public function setSlug($Slug){
        $this->Slug = $Slug;
    }
    public function setDescription($Description){
        $this->Description = $Description;
    }
    public function setProduct($Product){
        $this->Product = $Product;
    }
    public function setCover($Cover){
        $this->Cover = $Cover;
    }
    
    /********************************************************/
    public function toJSON(){
         
        $data = array(
             
        );
         
        return json_encode($data);
    }
    
    public function toArray(){
        $parent = parent::toArray();
        $data = array(
            'ItemId' => $this->getItemId(),
            'Title' => $this->getTitle(),
            'Slug'  => $this->getSlug(),
            'Description' => $this->getDescription(),
            'Product' => $this->getProduct()->toArray(),
            //'Cover' => $this->getCover()->toArray()
        );
        return array_merge($data, $parent);
    }
}
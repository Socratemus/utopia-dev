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
 * @ORM\Table(name="product")
 */
class Product extends Entity implements AbstractEntity {
    
     /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $ProductId;
    
    /**
     * @ORM\Column(type="decimal",precision=10, scale=4 , nullable=true)
     */
    protected $Price;
    
    /**
     * @ORM\Column(type="integer", options={"unsigned"=true} , nullable=true)
     */
    protected $Stock;
    
    /**
     * @ORM\OneToOne(targetEntity="Item",inversedBy="Product")
     * @ORM\JoinColumn(name="ItemId", referencedColumnName="ItemId" ,onDelete="CASCADE", nullable = false)
     */
     private $Item;
     
     private $Galery;
     
     /*********************************************/
     
     public function __construct(){
          parent::__construct();
     }
     
     /*********************************************/
     
     public function getProductId(){
          return $this->ProductId;
     }
     public function getPrice(){
          return $this->Price;
     }
     public function getStock(){
          return $this->Stock;
     }
     public function getItem(){
          return $this->Item;
     }
     
     public function setProductId($ProductId){
          $this->ProductId = $ProductId;
     }
     public function setPrice($Price){
          $this->Price = $Price;
     }
     public function setStock($Stock){
          $this->Stock = $Stock;
     }
     public function setItem($Item){
          $this->Item = $Item;
     }
     
     /*********************************************/
     public function toJSON(){
          
          $data = array(
               
          );
          
          return json_encode($data);
          
     }
     
     public function toArray(){
          $parent = parent::toArray();
          $data = array(
               'ProductId' => $this->getProductId(),
               'Price'     => $this->getPrice(),
               'Stock'     => $this->getStock()
          );
          return array_merge($data, $parent);
     }
}
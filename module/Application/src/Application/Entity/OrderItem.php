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
 * @ORM\Table(name="order_item")
 */
class OrderItem extends Entity{
    
     /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $OrderItemId;
    
    /**
     * @ORM\Column(type="integer", options={"unsigned"=true} , nullable=false)
     */
    protected $Quantity;
    
    /**
     * @ORM\Column(type="decimal",precision=10, scale=4 , nullable=false)
     */
    protected $Total;
    
    /**
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="ItemId", referencedColumnName="ItemId" , onDelete="CASCADE")
     */
    private $Item;
    
    /**
     * @ORM\ManyToOne(targetEntity="Order")
     * @ORM\JoinColumn(name="OrderId", referencedColumnName="OrderId" , onDelete="CASCADE")
     */
    private $Order;
    
    public function __construct(){
          parent::__construct();     
    }
    
    public function getOrderItemId(){
         return $this->OrderItemId;
    }
    public function getQuantity(){
         return $this->Quantity;
    }
    public function getTotal(){
         return $this->Total;
    }
    public function getItem(){
         return $this->Item;
    }
    public function getOrder(){
         return $this->Order;
    }
    
    public function setOrderItemId($OrderItemId){
         $this->OrderItemId = $OrderItemId;
    }
    public function setQuantity($Quantity){
         $this->Quantity = $Quantity;
    }
    public function setTotal($Total){
         $this->Total = $Total;
    }
    public function setItem(Item $Item){
         $this->Item = $Item;
    }
    public function setOrder(Order $Order){
         $this->Order = $Order;
    }
    
    
}
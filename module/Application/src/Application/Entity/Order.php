<?php

/**
 * @author Corneliu Iancu <corneliu.iancu27@gmail.com>
 * @Date Oct 25, 2014
 * @copyright (c) 2014, Corneliu Iancu
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class Order extends Entity{
    
    public static $Approved      = array(100 => 'APPROVED');
    public static $Rejected      = array(101 => 'REJECTED');
    public static $Fail          = array(102 => 'FAIL');
    public static $Completed     = array(103 => 'COMPLETED');
    public static $Pending       = array(104 => 'PENDING');
    
     /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $OrderId;
    
     /**
     * @ORM\Column(type="string" , length=40 , nullable = false)
     */
    protected $GUID;
    
     /**
     * @ORM\Column(type="string" , length=100 , nullable = false)
     */
    protected $OrderNo;
    
    /**
     * @ORM\Column(type="integer" , nullable = false)
     */
    protected $State;
    
    /**
     * @ORM\Column(type="string" , length=255 , nullable = false)
     */
    protected $Reason;
    
    /**
     * @ORM\Column(type="decimal",precision=10, scale=4 , nullable=false)
     */
    protected $TotalItems;
    
    /**
     * @ORM\Column(type="decimal",precision=10, scale=4 , nullable=false)
     */
    protected $Total = 0;
    
    /**
     * @ORM\Column(type="decimal",precision=10, scale=4 , nullable=false)
     */
    protected $Transport;
    
    /**
     * An array collection for every item stored in the order.
     * 
     * @ORM\OneToMany(targetEntity="OrderItem",mappedBy="Order",cascade={"persist"})
     * @var Collection
     * @ORM\OrderBy({"OrderItemId" = "desc"})
     */
    private $OrderItems;
    
    public function __construct(){
        parent::__construct();
        $this->OrderItems = new ArrayCollection();
        //set GUID
        $guid = strtoupper('RO' . date('Ymd') . substr(md5(uniqid() . microtime() . 'APPLICATION-ORDER-KEY' . ''),2,8) . '') ;
        $this->GUID = $guid; 
        $this->OrderNo = uniqid()  . '/' . date('Ymd');
    }
    
    public function getOrderId(){
        return $this->OrderId;
    }
    public function getOrderItems(){
         return $this->OrderItems;
    }
    public function getGUID(){
        return $this->GUID;
    }
    public function getOrderNo(){
        return $this->OrderNo;
    }
    public function getState(){
        return $this->State;
    }
    public function getReason(){
        return $this->Reason;
    }
    public function getTotal(){
        return $this->Total;
    }
    public function getTotalItems(){
        return $this->TotalItems;
    }
    public function getTransport(){
        return $this->Transport;
    }
    
    public function setOrderId($OrderId){
        $this->OrderId = $OrderId;
    }
    public function setGUID($GUID){
        $this->GUID = $GUID;
    }
    public function setOrderNo($OrderNo){
        $this->OrderNo = $OrderNo;
    }
    public function setState($State){
        $this->State = $State;
    }
    public function setReason($Reason){
        $this->Reason = $Reason;
    }
    public function setTotalItems($TotalItems){
        $this->TotalItems = $TotalItems;
    }
    public function setTotal($Total){
        $this->Total = $Total;
    }
    public function setTransport($Transport){
        $this->Transport = $Transport;
    }
    
    public function setOrderItems($OrderItems){
        $this->OrderItems= $OrderItems;
    }
    
    public function addOrderItem(OrderItem $OrderItem){
         $OrderItem->setOrder($this);
         $this->OrderItems->add($OrderItem);
         $this->updateTotal();
    }
    
    private function updateTotal(){
        $total = 0;
        foreach($this->OrderItems as $orderItem){
            $total += $orderItem->getTotal();
        }
        $this->setTotalItems($total);
    }
    
}
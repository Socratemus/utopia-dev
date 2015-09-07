<?php

/**
 * @author Corneliu Iancu <corneliu.iancu27@gmail.com>
 * @Date Oct 25, 2014
 * @copyright (c) 2014, Corneliu Iancu
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cart_item")
 */
class CartItem extends Entity {
    
     /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $CartItemId;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $Quantity;
    
    /**
     * @ORM\Column(type="text" , nullable = true)
     */
    protected $Voucher;
    
    /**
     * @ORM\ManyToOne(targetEntity="Cart")
     * @ORM\JoinColumn(name="CartId", referencedColumnName="CartId" , onDelete="CASCADE")
     */
    private $Cart;
    
    /**
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumn(name="ItemId", referencedColumnName="ItemId" , onDelete="CASCADE")
     */
    private $Item;
    
    public function __construct()
    {
         parent::__construct();
    }
    /**************************************************************************/
    public function getCartItemId(){
         return $this->CartItemId;
    }
    public function getQuantity(){
         return $this->Quantity;
    }
    public function getVoucher(){
         return $this->Voucher;
    }
    public function getCart(){
         return $this->Cart;
    }
    public function getItem(){
         return $this->Item;
    }
    
    public function setCartItemId($CartItemId){
         $this->CartItemId = $CartItemId;
    }
    public function setQuantity($Quantity){
         $this->Quantity = $Quantity;
    }
    public function setVoucher($Voucher){
         $this->Voucher = $Voucher;
    }
    public function setCart($Cart){
         $this->Cart = $Cart;
    }
    public function setItem($Item){
         $this->Item = $Item;
    }
}
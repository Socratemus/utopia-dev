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
 * @ORM\Table(name="cart")
 */
class Cart extends Entity {
    
     /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $CartId;
    
    /**
     * Cookie guid stored in the browser.
     * @ORM\Column(type="string" , length=35) 
     *
     */
    protected $GUID;
    
    /**
     * @ORM\Column(type="integer" , length=35) 
     * Cart's time to live
     * 
     */
    protected $Ttl;
    
    /**
     * Date of expiration for the cart.
     * @ORM\Column(type="datetime" , length=35) 
     */
    protected $Expire;
    
    /**
     * If the user is logged we will assign the cart to him.
     */
    private $User;
    
    /**
     * An array collection for every item stored in the cart.
     * 
     * @ORM\OneToMany(targetEntity="CartItem",mappedBy="Cart",cascade={"persist"})
     * @var Collection
     * @ORM\OrderBy({"CartItemId" = "desc"})
     *
     */
    private $CartItems;
    
    protected $TOTAL = 0;
    protected $TOTAL_ITEMS = 0;
    protected $TRANSPORT = 0;
    
    public function __construct(){
        parent::__construct();
        $this->CartItems = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**************************************************************************/
    public function getCartId(){
         return $this->CartId;
    }
    public function getGUID(){
         return $this->GUID;
    }
    public function getTtl(){
         return $this->Ttl;
    }
    public function getExpire()
    {
         return $this->Expire;
    }
    public function getUser(){
         return $this->User;
    }
    public function getCartItems(){
         return $this->CartItems;
    }
    
    public function setCartId($CartId){
         $this->CartId = $CartId;
    }
    public function setGUID($GUID){
         $this->GUID = $GUID;
    }
    public function setTtl($Ttl){
         $this->Ttl = $Ttl;
    }
    public function setExpire($Exipire){
         $this->Expire = $Exipire;
    }
    public function setUser($User){
         $this->User = $User;
    }
    public function setCartItems($CartItems){
         $this->CartItems = $CartItems;
    }
    /**************************************************************************/
    public function setTotalItems($TotalItems){
        $this->TOTAL_ITEMS = $TotalItems;
    }
    public function setTransport($Transport){
        $this->TRANSPORT = $Transport;
    }
    public function setTotal($Total){
        $this->TOTAL = $Total;
    }
    
    
    public function getTotalItems(){
        return $this->TOTAL_ITEMS;
    }
    
    public function getTransport(){
        return $this->TRANSPORT;
    }
    
    public function getTotal(){
        return $this->TOTAL;
    }
    
    
    /**************************************************************************/
    public function process(){
        $totalItems = 0;
        foreach($this->getCartItems() as $cartItem){
            $totalItems += $cartItem->getTotal();
        }
        $this->setTotalItems($totalItems);
        
        if($this->getTotalItems() > \Application\Service\OrderService::FREE_TRANSPORT){
            $this->setTransport(0);
        } else {
            $this->setTransport(\Application\Service\OrderService::COST_TRANSPORT);
        }
        
        $cartTotal = $this->getTotalItems() + $this->getTransport();
        $this->setTotal($cartTotal);
        
    }
}
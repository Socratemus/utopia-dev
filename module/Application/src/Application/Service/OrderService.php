<?php

namespace Application\Service;

use Application\Entity\Cart;
use Application\Entity\Order;
use Application\Entity\OrderItem;

class OrderService extends ModelService {
    
    const COST_TRANSPORT = 15.00;
    const FREE_TRANSPORT = 3200.00;
    
    public function __construct(){
        //echo 'constructed!';
    }
    
    /**************************************************************************/
    //All business methods for order will be stored in here.
    
    /**
     * Returns paged orders
     */
    public function getPaged(){
        
    }
    
    /**
     * Adds a new order
     */
    public function createOrder(Cart $Cart){
        $order = new Order();
        
        if($Cart->getCartItems()->count() == 0)
        {
            throw new \Exception('You do not have any items in your cart.');
        }
        foreach($Cart->getCartItems() as $cartItem){
            $orderItem = new OrderItem();
            $orderItem->setQuantity($cartItem->getQuantity());
            $orderItem->setItem($cartItem->getItem());
            $total = $cartItem->getQuantity() * $cartItem->getItem()->getProduct()->getPrice();
            $orderItem->setTotal($total);
            $orderItem->setOrder($order);
            $order->addOrderItem($orderItem);
            $this->getEntityManager()->persist($orderItem);
        }
        $this->getEntityManager()->persist($order);
        $order->setState(key(Order::$Pending));
        $order->setReason(current(Order::$Pending));
        
        $last = $this->getLastOrder();
        if(!$last)
        {
            $orNo = $this->generateOrderNo(1);
        }
        else
        {
            $orNo = $this->generateOrderNo($last->getOrderId());
        }
        
        $order->setOrderNo($orNo);
        
        if($order->getTotalItems() > self::FREE_TRANSPORT)
        {
            $order->setTransport(0);
            $order->setTotal($order->getTotalItems());
        }
        else
        {
            $order->setTransport(number_format(self::COST_TRANSPORT,2,'.','0'));    
            $order->setTotal($order->getTotalItems() + self::COST_TRANSPORT);
        }
        
        foreach($Cart->getCartItems() as $cartItem){
            $this->getEntityManager()->remove($cartItem);
        }
        
        $this->getEntityManager()->flush();
        
        return $order;
        
    }
    
    /**
     * 
     * 
     */
    public function cancelOrder(){
        
    }
    
    /**
     * Returns last order.
     */
    private function getLastOrder(){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('o')
            ->from('Application\Entity\Order', 'o')
            //->where('u.id = ?1')
            ->orderBy('o.OrderId', 'Desc')
            ->setMaxResults( 1 );
        ;
           $query = $qb->getQuery();
       $query = $qb->getQuery();
       $result = $query->getResult();
       if(!empty($result)){
           return $result[0];
       }
       return false;
    }
    
    
    private function generateOrderNo( $OrderId ){
        return str_pad($OrderId, 5, '0', STR_PAD_LEFT) . '/' . date('ymd');
    }
    
    /**************************************************************************/
    
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository('Application\Entity\Order');
    }
}
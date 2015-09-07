<?php

namespace Application\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Order;
use Application\Entity\OrderItem;


class OrderController extends AbstractActionController
{
    /**
     *  The page where you will see the details of an order 
     */
    public function IndexAction(){
        
        return $this->redirect('home');
        /* @TODO */
    }
    
    /**
     *  The page where an order is created! 
     */
    public function createAction(){
        try 
        {
            $cartsrv = $this->getServiceLocator()->get('CartService');
            $orderserv = $this->getServiceLocator()->get('OrderService');    
            $cart = $cartsrv->getCart();

            $order = $orderserv->createOrder($cart);

            $this->getLogger()->info('New order was created.[' . $order->getGUID() . ']');
            $redirect = $this->redirect()->toRoute('cart',array('lang' => 'en'));
            return $redirect; 
            
        }
        catch(\Exception $e)
        {
            $this->getLogger()->crit($e);
            $redirect = $this->redirect()->toRoute('home',array('lang' => 'en'));
            return $redirect;
        }
        
        
        
       
        
       
    }
    
    /**
     * Confirmation page
     */
    public function confirmAction(){
        
        $guid = $this->params()->fromRoute('slug');
        
        
    }
    
    /**
     * Successfully created an order
     */
    public function congratsAction(){
        /* @TODO */
    }
    
}

?>
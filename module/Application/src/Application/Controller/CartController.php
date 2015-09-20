<?php

namespace Application\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CartController extends AbstractActionController
{
    
    public function IndexAction(){
        /* @TODO */
        $cartsrv = $this->getServiceLocator()->get('CartService');
        $cart = $cartsrv->getCart();
        // echo "<pre>";
        // echo 'Items in cart : ' . $cart->getCartItems()->count();
        // var_dump($cart->getGUID());
        
        // $url = $this->url()->fromRoute('order', array('lang' => 'en' , 'action' => 'create'),array('force_canonical' => true));
        
        // echo '<a href="' . $url .'">Create order</a>';
        // exit('');
        return array(
            'cart' => $cart    
        );
    }
    
    public function removeAction(){
        /* @TODO */
    }
    
    public function addAction(){
        /* @TODO */
        try
        {
            $redirectUrl = $this->getReferer();
            
            $cartsrv = $this->getServiceLocator()->get('CartService');
            $itemsrv = $this->getServiceLocator()->get('ItemService');
            $item = $this->params()->fromQuery('id');
            
            $quantity = $this->params()->fromQuery('q');
            if(!$item){
                throw new \Exception('Add to cart not propperly called.[missing query id]');    
            }
            
            if(!$quantity){
                $quantity = 1;
            }
            
            $cart = $cartsrv->getCart();
            $item = $itemsrv->getById($item);
            if(!$item || empty($item))
            {
                throw new \Exception('Item is not available.');
            }
            $cartsrv->addItem($item , array('quantity' => $quantity));
            if($redirectUrl){
                return $this->redirect()->toUrl($redirectUrl);  
            } else {
                //$lang = $_SESSION['lang']; //Fetch language from session.
                return $this->redirect()->toRoute('cart',array('lang' => 'en'));  
            }
            
        }
        catch(\Exception $e)
        {
            $this->getLogger()->crit($e);
            return $this->redirect()->toRoute('home');
        }
        
    }
    
    public function removeAllAction(){
        /* @TODO */
    }
}

?>
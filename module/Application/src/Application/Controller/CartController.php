<?php

namespace Application\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CartController extends AbstractActionController
{
    private $_step_algo       = 'md5' ;
    private $_step_key_prefix = 'KHYSTEP' ;
    
    public function indexAction(){
        
        $cartsrv = $this->getServiceLocator()->get('CartService');
        $cart = $cartsrv->getCart();
        
       
        $cart->process();
        if($this->getRequest()->isPost()){
           
            
        } 
        
        return array(
            'cart' => $cart
        );
    }
    
    public function removeAction(){
        /* @TODO */
    }
    
    public function addAction(){
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
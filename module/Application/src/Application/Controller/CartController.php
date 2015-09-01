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
        echo "<pre>"; var_dump($cart->getCartItems()->toArray());
        exit('get cart...');
    }
    
    public function removeAction(){
        /* @TODO */
    }
    
    public function addAction(){
        /* @TODO */
        try
        {
            $cartsrv = $this->getServiceLocator()->get('CartService');
            $itemsrv = $this->getServiceLocator()->get('ItemService');
            $item = $this->params()->fromQuery('id');
            //var_dump($item);exit;
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
            
            exit('must redirect!');
        }
        catch(\Exception $e)
        {
            //var_dump($e);exit;
            $this->getLogger()->crit($e);
            return $this->redirect()->toRoute('home');
        }
        
    }
    
    public function removeAllAction(){
        /* @TODO */
    }
}

?>
<?php

namespace Application\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CartController extends AbstractActionController
{
    
    public function IndexAction(){
        /* @TODO */
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
            $quantity = $this->params()->fromQuery('q');
            if(!$item){
                throw new \Exception('Add to cart not propperly called.[missing query id]');    
            }
            
            if(!$quantity){
                $quantity = 1;
            }
            
            $cart = $cartsrv->getCart();
            $item = $itemsrv->getById($item);
            //var_dump($item);
            
            $cartsrv->addItem($item , array('quantity' => $quantity));
            
            // $redirectUrl = $this->getRequest();
            exit('must redirect!');
        }
        catch(\Exception $e)
        {
            var_dump($e);exit;
            $this->getLogger()->crit($e);
        }
        
    }
    
    public function removeAllAction(){
        /* @TODO */
    }
}

?>
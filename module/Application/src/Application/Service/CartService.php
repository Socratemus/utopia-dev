<?php

namespace Application\Service;

class CartService extends ModelService {
    
    private $_cartKey = '_usr_cart';
    private $_ttl = array(
       'sec' => 0,
       'min' => 5,
       'hours' => 0,
       'days' => 0
    ); 
    
    
    public function __construct(){
        //echo 'constructed!';
    }
    
    /**************************************************************************/
    //All business methods for category will be stored in here.
    
    public function verify()
    {
        //Fetching a cart instance.
        $cart = $this->getCart();
        
        //Updating all carts to disable if expired
        $query = $this->getEntityManager()->createQuery(
                        'SELECT c FROM \Application\Entity\Cart c 
                        WHERE c.Expire < :today AND c.Status <> :disabled')
                    ->setParameter('today', new \DateTime())
                    ->setParameter('disabled', \Application\Response\Status::DISABLED)
                    ;
                    
        $result = $query->getResult();   
        foreach($result as $exp)
        {
            $exp->setStatus(\Application\Response\Status::DISABLED);
            $this->getEntityManager()->persist($exp);
        }
        $this->getEntityManager()->flush();
        
    }
    
    /**
     * Returns the cart.
     */
    public function getCart()
    {
        $cookiesrv = \Utils\Misc\Cookie::getInstance();
        $guid = $cookiesrv->get($this->_cartKey);
        
        $cart = $this->getRepository()->findBy(array('GUID' => $guid , 'Status' => \Application\Response\Status::ACTIVE));
        
        if(isset($cart[0])){
            $cart = $cart[0];
            return $cart;
        }
        //Generate new cart;
        return $this->generateCart();
    }
    
    public function addItem($Item , $Options = array())
    {
        $quantity = isset($Options['quantity']) ? $Options['quantity'] : 1;
        $cart = $this->getCart();
       
        foreach($cart->getCartItems() as $cartItem){
            

            if($cartItem->getItem()->getItemId() == $Item->getItemId()){
                //exit('duplicate');
                $cartItem->setQuantity($cartItem->getQuantity() + 1);
                $this->getEntityManager()->persist($cartItem);
                $this->getEntityManager()->flush();
                return true;
            }
        }
        
        $cartItem = new \Application\Entity\CartItem();
        $cartItem->setCart($cart);
        $cartItem->setItem($Item);
        $cartItem->setQuantity($quantity);
        $cartItem->setVoucher('EMPTY');
        
        $this->getEntityManager()->persist($cartItem);
        $this->getEntityManager()->flush();
        return true;
    }
    
    /**
     * Returns the GUID stored in the browser.
     */
    private function getBrowserGUID()
    {
            
    }
    
    /**
     * Returns a brand new cart
     */
    private function generateCart()
    {
        $cookiesrv = \Utils\Misc\Cookie::getInstance();
        $guid = $this->generateToken();
        //Setting the desired time to live from configs
        $addTime = 0;
        $addTime += $this->_ttl['sec'] ; //add seconds 
        $addTime += 60 * $this->_ttl['min'] ; //add minutes
        $addTime += 60 * 60 * $this->_ttl['hours'] ; //add hours
        $addTime += 60 * 60 * 24 * $this->_ttl['days'] ; //add days
        $ttl = time() + $addTime;
       
        $expire = new \DateTime(date('Y-m-d H:i:s' , $ttl));
        $cart = new \Application\Entity\Cart();
        $cart->setGUID($guid);
        $cart->setTtl($ttl);
        $cart->setExpire($expire);
        $this->getEntityManager()->persist($cart);
        $this->getEntityManager()->flush();
        
        $cookiesrv->set($this->_cartKey , $guid , $ttl);
        return $cart;
    }
    
    private function generateToken()
    {
        $chars = array(
            0,1,2,3,4,5,6,7,8,9,
            'A','B','C','D','E','F','G','H','I','J','K','L','M','N',
            'O','P','Q','R','S','T','U','V','W','X','Y','Z',
            // 'a','b','c','d','e','f','g','h','i','j','k','l','m','n',
            // 'o','p','q','r','s','t','u','v','w','x','y','z'
            );
        $serial = '';
        $max = count($chars)-1;
        for($i=0;$i<30;$i++){
            $serial .= (!($i % 5) && $i ? '-' : '').$chars[rand(0, $max)];
        }
       
        return $serial;
    }
    
    
    /**************************************************************************/
    
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository('Application\Entity\Cart');
    }
}
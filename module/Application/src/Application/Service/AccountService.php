<?php

namespace Application\Service;

use Application\Entity\Cart;
use Application\Entity\Order;
use Application\Entity\OrderItem;

class AccountService extends ModelService {
    
    /**
     * Returns all accounts with active status.
     */
    public function getAll(){
        
        $em = $this->getEntityManager();
        
        $statuses = array(
            \Application\Response\Status::ACTIVE
        );
        
        
        $query = $em->createQuery('SELECT a FROM Application\Entity\Account a WHERE a.Status IN (:statuses)');
        
        $query->setParameter('statuses', $statuses);
        
        $accounts = $query->getResult();
        
        return $accounts;
        
    }
    
    /**
     * Returns an account by its id
     */
    public function getById($Id){
        return $this->getRepository()->find($Id);
    }
    
    /*************************************************************************/
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository('Application\Entity\Account');
    }
    
}
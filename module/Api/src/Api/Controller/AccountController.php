<?php


namespace Api\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity as Entity;

class AccountController extends AbstractActionController
{
    
    /**
     * Lists all accounts.
     */
    public function indexAction(){
        try
        {
            $accserv = $this->getServiceLocator()->get('AccountService');
            $accounts = $accserv->getAll();
            foreach($accounts as &$account){
                $account = $account->toArray();
            }
            $this->JsonResponse->setMessage(__METHOD__);
            $this->JsonResponse->setVariables($accounts);
            
            return $this->JsonResponse;
        }
        catch(\Exception $e)
        {
            $this->getLogger()->crit($e);
            $this->JsonResponse->setMessage($e->getMessage());
            $this->JsonResponse->setFailed();
            return $this->JsonResponse;
        }

    }
    
    /**
     * Creates a new Account
     */
    public function createAction(){
        try
        {
            $accserv = $this->getServiceLocator()->get('AccountService');
            
            $data = $this->getPayload();
            $this->getLogger()->info('Creates a new account.');
            $this->getLogger()->info(json_encode($data));
            
            $account = new \Application\Entity\Account();
            $account->exchange($data);
            $this->getEntityManager()->persist($account);
            $this->getEntityManager()->flush();
            
            $this->JsonResponse->setMessage(__METHOD__);
            $this->JsonResponse->setSucceed();
            $this->JsonResponse->setVariables($account->toArray());
            
            return $this->JsonResponse;
        }
        catch(\Exception $e)
        {
            $this->getLogger()->crit($e);
            $this->JsonResponse->setMessage($e->getMessage());
            $this->JsonResponse->setFailed();
            return $this->JsonResponse;
        }
    }
    
    /**
     * Updates an existing account
     */
    public function updateAction(){
        try
        {
            $accserv = $this->getServiceLocator()->get('AccountService');
            
            $data = $this->getPayload();
            $this->getLogger()->info('Update an existing account.');
            $this->getLogger()->info(json_encode($data));
            
            $account = $accserv->getById($data['AccountId']);
            if(!$account){
                throw new \Exception("That account is invalid or corrupted.");
            }
            
            $account->exchange($data);
            $this->getEntityManager()->persist($account);
            $this->getEntityManager()->flush();
            
            $this->JsonResponse->setMessage(__METHOD__);
            $this->JsonResponse->setSucceed();
            $this->JsonResponse->setVariables($account->toArray());
            return $this->JsonResponse;
        }
        catch(\Exception $e)
        {
            $this->getLogger()->crit($e);
            $this->JsonResponse->setMessage($e->getMessage());
            $this->JsonResponse->setFailed();
            return $this->JsonResponse;
        }
    }
    
    /**
     * Removes an existing account
     */
    public function deleteAction(){
        try
        {
            $accserv = $this->getServiceLocator()->get('AccountService');
            
            
            return $this->JsonResponse;
        }
        catch(\Exception $e)
        {
            $this->getLogger()->crit($e);
            $this->JsonResponse->setMessage($e->getMessage());
            $this->JsonResponse->setFailed();
            return $this->JsonResponse;
        }
    }
    
    
}
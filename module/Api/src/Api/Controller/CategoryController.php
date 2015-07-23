<?php


namespace Api\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class CategoryController extends AbstractActionController
{
    public function indexAction()
    {   
        try
        {
            //throw new \Exception('My Custom error');
            
            $actions = array(
                array(
                    'path'   => 'get-all',
                    'action' => 'get-all',
                    'params' => array(),
                    'description' => ''
                ),    
                array(
                    'path'   => 'get',
                    'action' => 'get',
                    'params' => array('id'),
                    'description' => ''
                ),    
            );
            
            $this->JsonResponse->setVariables($actions);
            
            $this->JsonResponse->setMessage('This is the category interface.');
            $this->JsonResponse->setSucceed(0);
            
            return $this->JsonResponse;
        }
        catch(\Exception $e){
            $this->JsonResponse->setMessage($e->getMessage());
            $this->JsonResponse->setFailed(1);
            return $this->JsonResponse;
        }
       
    }
    
    public function getAction()
    {
        try
        {
            $csrv = $this->getServiceLocator()->get('CategoryService');
            $id = $this->params()->fromQuery('id');
            //$this->params()->fromQuery('paramname');
            $category = $csrv->getById($id);
            $tmp = $category->toArray();
            if($category->getParent()){
                
                $tmp['ParentId'] = $category->getParent()->getCategoryId();
            }
            $this->JsonResponse->setVariables(
                $tmp
            );
            $this->JsonResponse->setSucceed(1);
            return $this->JsonResponse;
        }
        catch(\Exception $e){
            $this->JsonResponse->setMessage($e->getMessage());
            $this->JsonResponse->setFailed(1);
            return $this->JsonResponse;
        }
    }
    public function getAllAction()
    {
        try
        {
            $csrv = $this->getServiceLocator()->get('CategoryService');
            $rootCats = $csrv->getRootCategories();
            foreach($rootCats as &$rc){
                $rc = $rc->toArray();
            }
            $this->JsonResponse->setVariables($rootCats);
            $this->JsonResponse->setMessage('Get all categories.');
            $this->JsonResponse->setSucceed(1);
            
            return $this->JsonResponse;
        }
        catch(\Exception $e){
            $this->JsonResponse->setMessage($e->getMessage());
            $this->JsonResponse->setFailed(1);
            return $this->JsonResponse;
        }    
    }
    public function createAction()
    {
        try
        {
            $csrv = $this->getServiceLocator()->get('CategoryService');
            $body = $this->getPayload();
            $this->getLogger()->info('Create category request');
            $this->getLogger()->info(json_encode($body));
            
            $form = new \Api\Form\CategoryForm();
            
            $form->setData($body);
            $this->JsonResponse->setSucceed(1);
            if($form->isValid()){
                $data = $form->getData();
                //Save category from data.
                $category = new \Application\Entity\Category();
                $category->exchange($data);
                if(isset($data['ParentId']) && !empty($data['ParentId']))
                {
                    $parent = $csrv->getById($data['ParentId']);   
                    $category->setParent($parent);
                }
                
                $em = $this->getServiceLocator()->get('EntityManager');
                $em->persist($category); $em->flush();
                
            } else {
                
                $this->JsonResponse->setFailed(1);
                $messages = $form->getMessages();
                $this->JsonResponse->setVariable('Errors' , $messages);
            }
            
            $this->JsonResponse->setVariables($category->toArray());
            $this->JsonResponse->setMessage('Created a new category.');
            
            
            return $this->JsonResponse;
        }
        catch(\Exception $e){
            $this->JsonResponse->setMessage($e->getMessage());
            $this->JsonResponse->setFailed(1);
            return $this->JsonResponse;
        }  
    }
    public function updateAction()
    {
        try
        {
            $csrv = $this->getServiceLocator()->get('CategoryService');
            $this->JsonResponse->setSucceed(1);
            $body = $this->getPayload();
            $this->getLogger()->info('Create category request');
            $this->getLogger()->info(json_encode($body));
            
            $form = new \Api\Form\CategoryForm();
            $form->setData($body);
            $this->JsonResponse->setSucceed(1);
            if($form->isValid()){
                $data = $form->getData();
                if(!isset($data['CategoryId']) || empty($data['CategoryId'])){
                    throw new \Exception('Missing category id.');
                }
                $category = $csrv->getById($data['CategoryId']);
                $category->exchange($data);
                if(isset($data['ParentId']) && !empty($data['ParentId']))
                {
                    $parent = $csrv->getById($data['ParentId']);   
                    $category->setParent($parent);
                }
                $em = $this->getServiceLocator()->get('EntityManager');
                $em->persist($category); $em->flush();
                
            } else {
                $this->JsonResponse->setFailed(1);
                $messages = $form->getMessages();
                $this->JsonResponse->setVariable('Errors' , $messages);
                return $this->JsonResponse;
            }
            $this->JsonResponse->setVariables(array(
                'request_payload' => $data   
            ));
            $this->JsonResponse->setMessage('category updated.');
            return $this->JsonResponse;
        }
        catch(\Exception $e)
        {
            $this->JsonResponse->setMessage($e->getMessage());
            $this->JsonResponse->setFailed(1);
            return $this->JsonResponse;
        }
        
    }
}
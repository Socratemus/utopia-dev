<?php


namespace Api\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Api\Form\ItemForm;
use Application\Entity\Item;

class ItemController extends AbstractActionController
{
    public function indexAction()
    {   
        try
        {
            
            $actions = array(
                array(
                    'path'   => 'get-all',
                    'action' => 'get-all',
                    'params' => array(),
                    'description' => 'Returns all paged products'
                ),    
                array(
                    'path'   => 'get',
                    'action' => 'get',
                    'params' => array('id'),
                    'description' => 'Returns a product by id'
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
    
    public function createAction(){
        try
        {
            $imgsrv = $this->getServiceLocator()->get('ImageService');
            $data = $this->getPayload();
            $Cover = isset($data['Cover']) && !empty($data['Cover']) ? $data['Cover'] : null;
            $this->getLogger()->info('Creating new product');
            // $this->getLogger()->debug(json_encode($data));
            // echo $Cover;exit();
            $itemForm = new ItemForm();
            $itemForm->setData($data);
            
            if($itemForm->isValid()){
                if(!$Cover) 
                { 
                    throw new \Exception('Cover file not set.');  
                }
                $data = $itemForm->getData();
                $this->getLogger()->debug(json_encode($data));
                $item = new Item();
                $item->exchange($data);
                $cover = $imgsrv->processFolder($Cover , $data['Slug'] );
                $item->setCover($cover);
                $em = $this->getServiceLocator()->get('EntityManager');
                $em->persist($item);
                $em->flush();
                $this->JsonResponse->setVariables($item->toArray());
            }
            else
            {
                $this->JsonResponse->setFailed(1);
                $messages = $itemForm->getMessages();
                $this->JsonResponse->setVariable('Errors' , $messages);
            }
            $this->JsonResponse->setMessage('Created a new product.');
            
            
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
            throw new \Exception('Method not ready yet');
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
            $itmsrv = $this->getServiceLocator()->get('ItemService');
            $items = $itmsrv->getAll();
            foreach($items as &$item){
                $item = $item->toArray();
            }
            //throw new \Exception('Method not ready yet');
            
            $this->JsonResponse->setVariables($items);
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
            throw new \Exception('Method not ready yet');
        }
        catch(\Exception $e){
            $this->JsonResponse->setMessage($e->getMessage());
            $this->JsonResponse->setFailed(1);
            return $this->JsonResponse;
        }
    }
}
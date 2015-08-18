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
    
    public function createAction()
    {
        try
        {
            $imgsrv = $this->getServiceLocator()->get('ImageService');
            $ctsrv  = $this->getServiceLocator()->get('CategoryService');
            $data   = $this->getPayload();
            $Cover  = isset($data['Cover']) && !empty($data['Cover']) ? $data['Cover'] : null;
            
            $Categories = isset($data['Categories']) && !empty($data['Categories']) ? $data['Categories'] : null;
            $this->getLogger()->info('Creating new product');
            
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
                if($Categories){
                    foreach($Categories as $catId){
                        $cat = $ctsrv->getRepository()->find($catId);
                        $item->getCategories()->add($cat);
                    }
                }
                
                $em = $this->getServiceLocator()->get('EntityManager');
                $em->persist($item);
                $em->flush();
                
                $cover = $imgsrv->processFolder($Cover , $item->getGUID() );
                $item->setCover($cover);
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
            $id = $this->params()->fromQuery('id');
            
            $itemService = $this->getServiceLocator()->get('ItemService');
            if(!$id){
                throw new \Exception('Id was not provided.');
            }
            
            $item = $itemService->getById($id);
            
            $this->JsonResponse->setSucceed(1);
            $this->JsonResponse->setMessage('Successfully fetched the requested item.');
            $this->JsonResponse->setVariables(
                $item->toArray()
            );
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
            $imgsrv = $this->getServiceLocator()->get('ImageService');
            $itemService = $this->getServiceLocator()->get('ItemService');
            $ctsrv  = $this->getServiceLocator()->get('CategoryService');
            $data = $this->getPayload();
           
            /* If it is array it is unchanged */
            $Cover  = isset($data['Cover']) && !empty($data['Cover']) && !is_array($data['Cover']) ? $data['Cover'] : null;
            
            $Galery = isset($data['Product']['Galery']) && !empty($data['Product']['Galery']) ? $data['Product']['Galery'] : null;
            $Categories = isset($data['Categories']) && !empty($data['Categories']) ? $data['Categories'] : null;
            $itemId = $data['ItemId'];
            if(!$itemId) {
                throw new \Exception('Item id was not provided');
            }
            $item = $itemService->getById($itemId);
            
            $itemForm = new ItemForm();
            $itemForm->setData($data);
            
            if($itemForm->isValid()){
                $data = $itemForm->getData();
                $this->getLogger()->debug(json_encode($data));
                
                $item->exchange($data);
                //unset previus cover.
               
                if($Cover){
                    
                    $cover = $imgsrv->processFolder($Cover , $item->getGUID() );
                    
                    $prevCover = $item->getCover();
                    @unlink($prevCover->getFolder() . $prevCover->getGUID() . 'XS.png' );
                    @unlink($prevCover->getFolder() . $prevCover->getGUID() . 'SM.png' );
                    @unlink($prevCover->getFolder() . $prevCover->getGUID() . 'MD.png' );
                    $this->getServiceLocator()->get('EntityManager')->remove($prevCover);
                    $item->setCover($cover);
                }
                
                if($Categories){
                    $item->getCategories()->clear();
                    foreach($Categories as $catId){
                        $cat = $ctsrv->getRepository()->find($catId);
                        $item->getCategories()->add($cat);
                    }
                }
                
                //Handle galery images
                if($Galery){
                    foreach($Galery as $image){
                        if(!isset($image['id'])) continue;
                        $id = $image['id'];
                        $destination = $item->getGUID();
                        $galeryItem = $imgsrv->processGaleryFolder($id , $destination);
                        $item->getProduct()->getGalery()->add($galeryItem);
                    }
                }
                
                $em = $this->getServiceLocator()->get('EntityManager');
                $em->persist($item);
                $em->flush();
                $this->JsonResponse->setVariables($item->toArray());
               
            } else {
                $this->JsonResponse->setFailed(1);
                $messages = $itemForm->getMessages();
                $this->JsonResponse->setVariable('Errors' , $messages);
            }
            
            //$item->exchage();
            
            return $this->JsonResponse;
        }
        catch(\Exception $e){
            $this->JsonResponse->setMessage($e->getMessage());
            $this->JsonResponse->setFailed(1);
            return $this->JsonResponse;
        }
    }
    
    public function removeAction()
    {
        
    }
    
    public function removeGaleryImageAction(){
        try
        {
            //$data = $this->getPayload();
            $productId = $this->params()->fromQuery('ProductId');
            $imageId = $this->params()->fromQuery('ImageId');
            
            $imgsrv = $this->getServiceLocator()->get('ImageService');
            
            $em = $this->getServiceLocator()->get('EntityManager');
            
            $product = $em->getRepository('\Application\Entity\Product')->find($productId);
            
            foreach($product->getGalery() as $image){
                if($image->getImageId() == $imageId)
                {
                    
                    @unlink($image->getFolder() . $image->getGUID() . 'XS.png' );
                    @unlink($image->getFolder() . $image->getGUID() . 'SM.png' );
                    @unlink($image->getFolder() . $image->getGUID() . 'MD.png' );
                    
                    $em->remove($image);$em->flush();
                    break;
                }
                
            }
            
            //$image = 
            
            $this->JsonResponse->setVariables(
                array(
                    'ProductId' => $productId,
                    'ImageId' => $imageId
                )    
            );
            return $this->JsonResponse;
        }
        catch(\Exception $e){
            $this->JsonResponse->setMessage($e->getMessage());
            $this->JsonResponse->setFailed(1);
            return $this->JsonResponse;
        }
        
    }
    
    
}
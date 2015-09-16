<?php


namespace Api\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity as Entity;

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
            if(empty($category)){
                throw new \Exception('Category was not found.');
            }
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
            
            $ret = $this->getRecursiveCategories($rootCats);
            // echo "<pre>";
            // print_r($ret);
            // exit();
            $this->JsonResponse->setVariables($ret);
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
    
    /**
     * Creates a new category
     * Params : 
     *  {} @TODO
     */
    public function createAction()
    {
        try
        {
            $csrv = $this->getServiceLocator()->get('CategoryService');
            $imfac = $this->getServiceLocator()->get('ImageFactory');
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
                
                if(isset($data['Cover']) && !empty($data['Cover']))
                {
                    $cover = $imfac->getByGUID($data['Cover']);
                    $cover = $cover[0];
                    $imfac->move($cover , 'categories');
                    $category->setCover($cover);
                }
                
                $em = $this->getServiceLocator()->get('EntityManager');
                $em->persist($category);
                $em->flush();
                
            } else {
                //throw new \Exception('Form is not valid');
                $this->JsonResponse->setFailed(1);
                $messages = $form->getMessages();
                $this->JsonResponse->setVariable('Errors' , $messages);
                return $this->JsonResponse;
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
            $imfac = $this->getServiceLocator()->get('ImageFactory');
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
                $catImGuid = $category->getCover() ? $category->getCover()->getGUID() : null;
                if(isset($data['Cover']) && $data['Cover'] != $catImGuid){
                    //exit('fa update');
                    $cover= $data['Cover'];
                    unset($data['Cover']);
                    $cover = $imfac->getByGUID($cover);
                    $cover = $cover[0];
                    $imfac->move($cover , 'categories');
                    $olcov = $category->getCover();
                    $category->setCover($cover);
                    if($olcov) {
                        $imfac->remove($olcov);
                    }
                } else {
                    unset($data['Cover']);
                }
                if(isset($data['Banner']) && $data['Banner'] != $catImGuid){
                    //exit('fa update banner');
                    $cover= $data['Banner'];
                    unset($data['Banner']);
                    $cover = $imfac->getByGUID($cover);
                    $cover = $cover[0];
                    //var_dump($cover);exit;
                    $imfac->move($cover , 'categories');
                    $olcov = $category->getBanner();
                    $category->setBanner($cover);
                    if($olcov) {
                        $imfac->remove($olcov);
                    }
                    
                } else {
                    unset($data['Banner']);
                }
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
    
    /**********************************************************************/
    
    /**
     * Returns all filters of a given category id.
     */
    public function getFiltersAction(){
        try
        {
            $csrv = $this->getServiceLocator()->get('CategoryService');
            $id = $this->params()->fromQuery('c');
            $category = $csrv->getById($id);
            
            $filters = $category->getFilters();
            $tmp = array();
            foreach($filters as &$filter){
                array_push($tmp , $filter->toArray());
            }
            
            $this->JsonResponse->setVariables(
                $tmp
            );
            
            $this->JsonResponse->setMessage('Get filters action.');
            $this->JsonResponse->setSucceed();
            return $this->JsonResponse;
        }
        catch(\Exception $e)
        {
            $this->getLogger()->crit($e);
            $this->JsonResponse->setMessage($e->getMessage());
            $this->JsonResponse->setFailed(1);
            return $this->JsonResponse;
        }
    }
    
    /**
     * Creates a new filter.
     */
    public function createFilterAction()
    {
        try
        {
            $data   = $this->getPayload();
            $csrv   = $this->getServiceLocator()->get('CategoryService');
            $itmsrv = $this->getServiceLocator()->get('ItemService');
            $em     = $this->getServiceLocator()->get('EntityManager');
            if(!isset($data['Category']))
            {
                throw new \Exception('Category not provided');
            }
            $category = $csrv->getById($data['Category']);
            $filter = new Entity\Filter();
            $filter->exchange($data);
            $filter->setCategory($category);
            $em->persist($filter);
            
            if(isset($data['FilterValues']) && is_array($data['FilterValues'])){
                foreach($data['FilterValues'] as $filterValue){
                    if(!empty($filterValue) && isset($filterValue['ItemId']))
                    {
                        $item = $itmsrv->getById($filterValue['ItemId']);
                        $fv = new Entity\FilterValue();
                        $fv->exchange($filterValue);
                        $fv->setItem($item);
                        $fv->setFilter($filter);
                        $filter->getFilterValues()->add($fv);
                        $em->persist($fv);
                    }
                    
                }
            }
            $em->flush();
            $this->JsonResponse->setMessage(__METHOD__);
            $this->JsonResponse->setVariables($filter->toArray());
            return $this->JsonResponse;
        }
        catch(\Exception $e)
        {
            $this->getLogger()->crit($e);
            $this->JsonResponse->setMessage($e->getMessage());
            $this->JsonResponse->setFailed(1);
            return $this->JsonResponse;
        }
        
    }
    
    /**
     * Updates a new filter
     * If filter values are sent, they are also updated
     * or created.
     */
    public function updateFilterAction()
    {   
        try
        {
            //sleep(3);
            $data = $this->getPayload();
            $itmsrv = $this->getServiceLocator()->get('ItemService');
            $em = $this->getServiceLocator()->get('EntityManager');
            //unset($data['FilterValues']);
            $this->getLogger()->info('update filter');
            $this->getLogger()->debug(json_encode($data));
            
            $filterId = $data['FilterId'];
            $filter   = $em->getRepository('Application\Entity\Filter')->find($filterId);
            $filter->exchange($data);
            $em->persist($filter);
            
            if(isset($data['FilterValues']) && is_array($data['FilterValues'])){
                foreach($data['FilterValues'] as $filterValue){
                    if(!empty($filterValue) && isset($filterValue['ItemId']) && !isset($filterValue['FilterValueId']))
                    {
                        $item = $itmsrv->getById($filterValue['ItemId']);
                        $fv = new Entity\FilterValue();
                        $fv->exchange($filterValue);
                        $fv->setItem($item);
                        $fv->setFilter($filter);
                        $filter->getFilterValues()->add($fv);
                        $em->persist($fv);
                    }
                    if(!empty($filterValue) && isset($filterValue['ItemId']) && isset($filterValue['FilterValueId']))
                    {
                        $fv   = $em->getRepository('Application\Entity\FilterValue')->find($filterValue['FilterValueId']);
                        $fv->exchange($filterValue);
                        $em->persist($fv);
                    }
                    
                }
            }

            $em->flush();
            $this->JsonResponse->setMessage(__METHOD__);
            $this->JsonResponse->setVariables($filter->toArray());
            return $this->JsonResponse;
        }
        catch(\Exception $e)
        {
            $this->getLogger()->crit($e);
            $this->JsonResponse->setMessage($e->getMessage());
            $this->JsonResponse->setFailed(1);
            return $this->JsonResponse;
        }
    }
    
    /**
     * Removes a filter by its ID
     * 
     */
    public function deleteFilterAction()
    {
        try
        {
            $id = $this->params()->fromQuery('id');
            if(!$id){
                throw new \Exception('Filter id was not provided.');
            }
            
            $em = $this->getServiceLocator()->get('EntityManager');
            
            $filter = $em->getRepository('\Application\Entity\Filter')->find($id);
            if(!$filter) {
                throw new \Exception('This filter does not exists');
            }
            $em->remove($filter);$em->flush();
            $this->JsonResponse->setMessage(__METHOD__);
            //$this->JsonResponse->setVariables($filter->toArray());
            $this->JsonResponse->setSucceed();
            return $this->JsonResponse;
        }
        catch(\Exception $e)
        {
            $this->getLogger()->crit($e);
            $this->JsonResponse->setMessage($e->getMessage());
            $this->JsonResponse->setFailed(1);
            return $this->JsonResponse;
        }
    }
    
    /**********************************************************************/
    
    private function getRecursiveCategories($categories = array() , &$step = -1 , &$menu = array()){
        $step++;
        foreach($categories as $category){
            // var_dump($step);
            // var_dump($category->getTitle());
            
            $whiteSpace = ''; for($i = 0 ; $i < $step ; $i++) $whiteSpace .= '_';
            
            $category->setTitle($whiteSpace.$category->getTitle());
            
            array_push($menu, $category->toArray());
            if( $chd = $category->getChildren()->toArray()){

                $sub = $this->getRecursiveCategories($chd , $step , $menu);
                $step--;
            } else {
               
            }
        }
        
        return $menu;
    }
    
}
<?php


namespace Test\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{
    public function indexAction()
    {   
        $data = array(
            'Title' => 'Test category',
            'Slug' => 'test',
            'Status' => 200,
            'ParentId' => 5
        );
        
        $category = new \Application\Entity\Category();
        $category->exchange($data);
        $em = $this->getServiceLocator()->get('EntityManager');
        $em->persist($category); $em->flush();
        //var_dump($em);
        
        exit('okey');;
        //$this->JsonResponse->setVariables(array('Message' => 'This is the application api interface.'));
        $this->JsonResponse->setMessage('This is the application api interface.');
        $this->JsonResponse->setSucceed(0);
        
        return $this->JsonResponse;
    }
    
    public function testAction()
    {
        exit('admin test page.');       
    }
}
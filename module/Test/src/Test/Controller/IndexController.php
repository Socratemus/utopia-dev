<?php


namespace Test\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity as Entity;


class IndexController extends AbstractActionController
{
    protected $ImagesDestionations = 'data/Filemanager/Temp/';
    
    public function indexAction()
    {   
        try {
            $filter = new Entity\Filter;
            $data = array(
                'Title' => 'Producer',
                'Slug'  => 'producer',
                'Category' => '1'
            );
            $category = $this->getServiceLocator()->get('CategoryService')->getById(1);
            $filter->exchange($data);
            $filter->setCategory($category);
            $this->getServiceLocator()->get('EntityManager')->persist($filter);
            $this->getServiceLocator()->get('EntityManager')->flush();
            var_dump($filter);
            exit;
            
            return $this->JsonResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();
        }
        
    }
    
    
    public function generateAction()
    {
        echo 'test'; 
        exit();
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', "image/png");
 
        $id = $this->params('id', false);//var_dump($id);exit;
        //var_dump($id);exit;
        if ($id) {
 
            $image = './data/captcha/' . $id;
 
            if (file_exists($image) !== false) {
                $imagegetcontent = @file_get_contents($image);
 
                $response->setStatusCode(200);
                $response->setContent($imagegetcontent);
 
                if (file_exists($image) == true) {
                    unlink($image);
                }
            }
 
        }
 
        return $response;
    }
    
    public function testAction()
    {
        exit('admin test page.');       
    }
    
    public function imageServiceTest()
    {
        $imgSrv = $this->getServiceLocator()->get('ImageService');
        $imgSrv->test();
        exit;
    }
    
    public function productServiceTest()
    {
        $imsrv = $this->getServiceLocator()->get('ImageService');
        $item = new \Application\Entity\Item();
        $input= array(
            'Title' => 'Test item',
            'Slug'  =>  'test-item',
            'Description' => 'test description',
            '_Cover' => '18a90a70fc6c7035f2490adfd585ab43',
            'Product' => array(
                'Price' => 990.99,
                'Stock' => 12
            )
        );
        $cover = $imsrv->processFolder($input['_Cover'] , $input['Slug'] );
        $item->setCover($cover);
        $item->exchange($input);
        $this->getServiceLocator()->get('EntityManager')->persist($item);
        $this->getServiceLocator()->get('EntityManager')->flush();
        var_dump($item);exit;
        
        exit('doing...');
    }
}
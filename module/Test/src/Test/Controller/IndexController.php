<?php


namespace Test\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{
    protected $ImagesDestionations = 'data/Filemanager/Temp/';
    
    public function indexAction()
    {   
        try {

            echo '<pre>'; 
            $client = new \Google_Client();

            $client->setApplicationName("test");
            $client->setClientId('683627405636-h43565hrrqk9f6469vcklpf0fnm8jdj5.apps.googleusercontent.com');
            $client->setClientSecret('lS0LM6Lb_F0230LIUZMOZC9Q');
            $client->setRedirectUri('http://localhost/google-api-php-client-master/examples/fileupload.php');
            $client->setScopes(array('https://www.googleapis.com/auth/drive','https://www.googleapis.com/auth/drive.readonly','https://www.googleapis.com/auth/drive.file','https://www.googleapis.com/auth/drive.metadata.readonly','https://www.googleapis.com/auth/drive.appdata','https://www.googleapis.com/auth/drive.apps.readonly'));


            var_dump($client);
            exit();
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
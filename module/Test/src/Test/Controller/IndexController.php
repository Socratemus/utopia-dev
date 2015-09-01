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
        try 
        {
            return $this->JsonResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();
            exit;
        }
         
    }

    public function indexBakAction()
    {   
        try {
                
            $className = '\Application\Entity\Category';
            $em = $this->getEntityManager();

            $cmd = $em->getClassMetadata($className);
            $connection = $em->getConnection();
            $dbPlatform = $connection->getDatabasePlatform();
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
            $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
            var_dump($q);
            $connection->executeUpdate($q);
            $connection->query('SET FOREIGN_KEY_CHECKS=1');


            exit();
            // $cron = $this->getServiceLocator()->get('CronManager');
            // $cron->test();exit;
            $this->getLogger()->info('START CLI REQUEST!!');

            $commandKey = strtoupper(md5('Maximus' . uniqid()));
            $commandParams = array('foo' => 'bar' , 'baz' => 'bat');
            // $cache = $this->getServiceLocator()->get('cache');
            // $exists = $cache->hasItem($commandKey);

            // $cache->setItem($commandKey , 'something');
            // exit;
            $command = new \Cli\Entity\Command("\Cli\Service\TaskManager" , "task_resetDatabase" , $commandKey , $commandParams);
            
            $processManager = $this->getServiceLocator()->get('processManager');
            $command = $processManager($command);
            //$processManager->execute(false ,false);exit;
            echo "<pre>";
            var_dump($command->toArray());
            
            exit();
            
            return $this->JsonResponse;
        }
        catch(\Exception $e){
            echo $e->getMessage();
            exit;
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
<?php


namespace Test\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{
    public function indexAction()
    {   
       
        $data = explode("\n", file_get_contents("/proc/meminfo"));
        $meminfo = array();
        foreach ($data as $line) {
            list($key, $val) = explode(":", $line);
            $meminfo[$key] = trim($val);
        }
        var_dump($meminfo)
       
       
       
       
       
       
       
       
       
       
       
       
       exit;
          $fh = fopen('/proc/meminfo','r');
          $mem = 0;
          while ($line = fgets($fh)) {
            $pieces = array();
            if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
              $mem = $pieces[1];
              break;
            }
          }
          fclose($fh);
            $mbRamUsed = $mem / 1024;
            $GibRamUsed = $mbRamUsed / 1024;
            echo "$GibRamUsed GiB RAM found";
          
          exit;
        //$this->productServiceTest();
        $this->JsonResponse->setMessage('This is the application api interface.');
        $this->JsonResponse->setSucceed(0);
        return $this->JsonResponse;
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
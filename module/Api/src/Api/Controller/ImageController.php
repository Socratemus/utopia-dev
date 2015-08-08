<?php


namespace Api\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class ImageController extends AbstractActionController
{
    
    protected $ImageDestionation = 'data/Filemanager/Temp';
    
    public function __construct(){
        
        parent::__construct();
        if(!file_exists('data/Filemanager')){
            mkdir('data/Filemanager' , 0777);
        }
        if(!file_exists($this->ImageDestionation)){
            mkdir($this->ImageDestionation , 0777);
        }
        
    }
    
    public function indexAction()
    {   
        try
        {
            $request = $this->getRequest();
            $imgSrv = $this->getServiceLocator()->get('ImageService');
            $files =  $request->getFiles()->toArray();
            $httpadapter = new \Zend\File\Transfer\Adapter\Http(); 
            $filesize  = new \Zend\Validator\File\Size(array('min' => 1000 )); //1KB  
            $extension = new \Zend\Validator\File\Extension(array('extension' => array('txt', 'jpg' , 'png')));
            $httpadapter->setValidators(array($filesize, $extension), $files['file']['name']);
            
            $hash = md5(rand(1,1999) . uniqid() . microtime());
            
            $filenewname = strtoupper('img' . date('YmdHis') . substr($hash , 0, 6));
            
            if($httpadapter->isValid()) {
                
                $httpadapter->setDestination($this->ImageDestionation);
                $httpadapter->addFilter('File\Rename', array('target' => $httpadapter->getDestination() .
                    DIRECTORY_SEPARATOR . $filenewname . '.png',
                'overwrite' => true));
                
                if($httpadapter->receive($files['file']['name'])) {
                    $this->JsonResponse->setMessage('File succesfully uploaded.');
                    $newfile = $httpadapter->getFileName(); 
                } else {
                    $this->JsonResponse->setMessage('File failed on receive');
                }
            } else {
                $this->JsonResponse->setMessage('File did not pass the adaptor config.');
            }
            
            $imgSrv->fromTempStorage($filenewname);
            
            $this->JsonResponse->setVariables(
                array('image' => $filenewname)     
            );
            
            $this->JsonResponse->setSucceed(0);
            
            return $this->JsonResponse;
        }
        catch(\Exception $e){
            $this->JsonResponse->setMessage($e->getMessage());
            $this->JsonResponse->setFailed(1);
            return $this->JsonResponse;
        }
   }
   
    public function bulkAction()
    {
        try
        {
            $response = array();
            $this->JsonResponse->setSucceed(1);
            
            $request = $this->getRequest();
            $imgSrv = $this->getServiceLocator()->get('ImageService');
            $files =  $request->getFiles()->toArray();
            //var_dump($files);exit;
            foreach($files['file'] as $file){
                
                /* @TODO */
                /* Add validation in here */
                $hash = md5( uniqid() . microtime() . rand(1,999));
                //var_dump($hash);
                $imageId= strtoupper('glr' . date('YmdHis') . substr($hash , 0, 6)) ;
                $destinaton =  $this->ImageDestionation . DIRECTORY_SEPARATOR . $imageId. '.png';
                move_uploaded_file($file['tmp_name'] ,$destinaton);
                
                $imgSrv->fromTempStorage($imageId);
                
                usleep(50000); //usleep 50ms
                unset($hash);
                array_push($response , $imageId);
            }
            
            $this->JsonResponse->setVariables($response);
            return $this->JsonResponse;
        }
        catch(\Exception $e){
            $this->JsonResponse->setMessage($e->getMessage());
            $this->JsonResponse->setFailed(1);
            return $this->JsonResponse;
        }
   }
   
}
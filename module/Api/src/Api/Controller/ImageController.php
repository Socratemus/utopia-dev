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
            
            $filenewname = md5(rand(1,1999) . microtime());
            
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
}
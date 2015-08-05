<?php


namespace Api\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class FileManagerController extends AbstractActionController
{
    private $_folder = "data/Filemanager";
    
    public function indexAction()
    {   
        try
        {
            //echo dirname(__FILE__).  "/../Service/Elfinder"  . DIRECTORY_SEPARATOR.'elFinderConnector.class.php';exit;
            $vendorPath = "/../Service/ElFinder";
            require_once dirname(__FILE__) . $vendorPath . DIRECTORY_SEPARATOR.'elFinderConnector.class.php';
            require_once dirname(__FILE__) . $vendorPath . DIRECTORY_SEPARATOR.'elFinder.class.php';
            require_once dirname(__FILE__) . $vendorPath . DIRECTORY_SEPARATOR.'elFinderVolumeDriver.class.php';
            require_once dirname(__FILE__) . $vendorPath . DIRECTORY_SEPARATOR.'elFinderVolumeLocalFileSystem.class.php';
            
            $opts = array(
            	// 'debug' => true,
            	'roots' => array(
            		array(
            			'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
            			'path'          => $this->_folder,         // path to files (REQUIRED)
            			'URL'           => dirname($_SERVER['PHP_SELF']) . '/../' . $this->_folder, // URL to files (REQUIRED)
            			'accessControl' => 'access'             // disable and hide dot starting files (OPTIONAL)
            		)
            	)
            );
            
            // run elFinder
            $connector = new \elFinderConnector(new \elFinder($opts));
            $connector->run();

        }
        catch(\Exception $e){
            $this->JsonResponse->setMessage($e->getMessage());
            $this->JsonResponse->setFailed(1);
            return $this->JsonResponse;
        }
       
    }
    
    /*******************************************************************************************/
    
    private function listAction( $Request ){
        $path = $this->_folder . $Request['path'];
        
        $scanned_directory = array_diff(scandir($path), array('..', '.'));
        $result = array();
        foreach($scanned_directory as $item){
            //$tmp = array('name' , 'rights' , 'size' , 'date' , 'type');
            $tmp['name'] = $item;
            $tmp['rights'] = '-rw-r--r--';
            $tmp['size'] = filesize($path . '/' . $item);
            $tmp['date'] = date('Y-m-d H:i:s' , filemtime($path . '/' . $item));
            $tmp['type'] = is_dir($path . '/' . $item) ? 'dir' : 'file';
            array_push($result , $tmp);
            unset($tmp);
        }
        
        return $result;
    }
    
}
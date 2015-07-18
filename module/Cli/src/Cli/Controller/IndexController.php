<?php

namespace Cli\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Cli\Exception\RuntimeException;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        $filepath = 'data/cache/cli_test' . md5(time());
        $contents = sha1('test' . microtime());
        
        $i = 100;
        
        while($i > 0){
            $filepath = 'data/cache/cli_test' . md5(time());
            $contents = sha1('test' . microtime());
            file_put_contents($filepath , $contents);
            $i--;
        }
        
       
        
        
        
        echo 'done';
    }
    
    public function requestAction(){
        
        
        try
        {
            
            $request = $this->getRequest();

            if( ! $request instanceof ConsoleRequest)
            {
                throw new RuntimeException('You can only use this action from a console!');
            }
            
            
            $processManager = $this->getServiceLocator()->get('ProcessManager');
            $processManager->execute('Param1' , 'Param2');
            
        }
        catch(\Exception $e)
        {
           
            $this->getLogger()->crit($e);
            
           
            $this->JsonResponse->setFailed(1);
            return $this->JsonResponse;
        }
        
    }
    
}
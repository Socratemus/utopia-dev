<?php


namespace Api\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity as Entity;

class CliController extends AbstractActionController
{
    
    
    
    public function indexAction()
    {
        try
        {
            $object = array();
            $tasks = $this->getServiceLocator()->get('TaskManager');
            $processManager = $this->getServiceLocator()->get('ProcessManager');
            $class_methods = get_class_methods($tasks);
            
            foreach($class_methods as $method){
                
                if(strpos($method , 'Tsk' ) > -1) {
                    $data= array(
                        'Class' => '\Cli\Service\TaskManager',
                        'Method' => $method,
                    );
                    $command = new \Cli\Entity\Command();
                    $command->exchange($data);
                    $command = $processManager($command);
                    array_push($object , $command->toArray());
                    //var_dump($command);exit;
                   
                }
            }
            
            
            
           
            
            
            $this->JsonResponse->setVariables($object);
            return $this->JsonResponse;
        }
        catch(\Exception $e)
        {
            $this->JsonResponse->setFailed();
            $this->JsonResponse->setMessage($e->getMessage());
            return $this->JsonResponse;
        }
        
    }
    
    /**
     * Runs a cli command
     */
    public function runAction(){
        try
        {
            $request = $this->getRequest();
            if(! $request->isPost()){
                throw new \Exception('Not a valid request');
            }
            $data = $this->getPayload();
            $this->getLogger()->info('Registering a new CLI request');
            $this->getLogger()->info(json_encode($data));
            
            $processManager = $this->getServiceLocator()->get('ProcessManager');
            //$data = array('GUID' => 'CCCE2B31C5');
            $command = $processManager->getCommandByGUID($data['GUID']);
            
            $command = $processManager->exec($command);
            
            $this->JsonResponse->setMessage( __METHOD__);
            
            $this->JsonResponse->setVariables($command->toArray());
            
            $this->JsonResponse->setSucceed();
            return $this->JsonResponse;
        }
        catch(\Exception $e)
        {
            $this->getLogger()->crit($e);
            $this->JsonResponse->setMessage($e->getMessage());
            return $this->JsonResponse;
        }
    }
    
}
    
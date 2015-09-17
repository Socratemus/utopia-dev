<?php

namespace Cli\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Cli\Exception\RuntimeException;
use Zend\Console\Request as ConsoleRequest;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        $this->getLogger()->info('CLI REQUEST WAS RECEIVED!!');exit;

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

    /**
     * Runs an [active] CLI Command
     */
    public function runAction()
    {
        try
        {
            $this->getLogger()->info(' __ Starting to process cli request __ ');
            //sleep(5);
            $request = $this->getRequest();

            $request = $this->getRequest();

            if( ! $request instanceof ConsoleRequest)
            {
                throw new RuntimeException('You can only use this action from a console!');
            }

            $class = $request->getParam('class');
            if(( ! isset($class)) || (empty($class)))
            {
                throw new \Exception('Class not specified');
            }

            $method = $request->getParam('method');
            if(( ! isset($method)) || (empty($method)))
            {
                throw new Exception('Method not specified');
            }
            $cacheKey = $request->getParam('cacheKey');
            if(( ! isset($cacheKey)) || (empty($cacheKey)))
            {
                throw new Exception('Cache key not specified');
            }
            $key = $request->getParam('key');
            if(( ! isset($key)) || (empty($key)))
            {
                throw new Exception('Key not specified');
            }
            $filepath = 'data/cache/CLI_REQUEST_' . date('Y-m-d(H_i_s)');
            $contents = $class. '::' . $method . '::' . $cacheKey . '::' . $key;
            $this->getLogger()->info(' __ Parameters received correctly __ ');
            //sleep(5);
            $commandRepo = $this->getEntityManager()->getRepository('\Cli\Entity\Command');
            $command = $commandRepo->findBy(array('GUID' => $key , 'Status' => \Application\Response\Status::ACTIVE));
            if(empty($command)){
                throw new \Exception('Command was not found.');
            }
            $command = $command[0];
            $this->updateCommand($command , \Application\Response\Status::PENDING);
            if( ! class_exists($class))
            {
                if($this->getServiceLocator()->has($class))
                {

                    $object = $this->getServiceLocator()->get($class);
                    $this->getLogger()->info(' __ Object was fetched through service locator __ ');
                }
                else
                {
                    throw new \Exception("__ $class does not exists __");
                }
            } 

            if(!isset($object))
            {
                $objRefCls = new \ReflectionClass($class);
                if($objRefCls->implementsInterface('Zend\ServiceManager\ServiceLocatorAwareInterface'))
                {
                    $object = new $class($this->getServiceLocator());
                    $object->setServiceLocator($this->getServiceLocator());
                }
                else
                {
                    $object = new $class();
                }
                unset($objRefCls);
                $this->getLogger()->info(' __ Object was instantiated __ ');
            }

            if(method_exists($object, $method))
            {
                /* Check params */
                if($this->getCache()->hasItem($cacheKey)){
                    $params = $this->getCache()->getItem($cacheKey);    
                } else {
                    $params = false;    
                }
                
                
                if($params) 
                {
                    $this->getLogger()->debug(' __ Called '.$class.'::'.$method. '::'.serialize($params).' __ ' );
                    $result = $object->$method($params);
                    $this->getLogger()->info(' __ Successfully Called '.$class.'::'.$method.' __ ');
                } 
                else 
                {
                    $this->getLogger()->debug(' __ Called '.$class.'::'.$method.' __ ');
                    $result = $object->$method();
                    $this->getLogger()->info(' __ Successfully Called '.$class.'::'.$method.' __ ');
                }

            } 
            else 
            {
                throw new \Exception("$class does not implement that $method.");
            }

            //sleep(5);
            $contents .= "\n";
            $contents .= $result;
            file_put_contents($filepath , $contents);

            $command->setStatus(\Application\Response\Status::SUCCESS);
            $this->getEntityManager()->persist($command);
            $this->getEntityManager()->flush(); //Set command as finished.
        }
        catch(\Exception $e)
        {
            if(isset($command) && !empty($command))
            {
                $command->setStatus(\Application\Response\Status::FAILED);
                $command->setMessage($e->getMessage());
                $this->getEntityManager()->persist($command);
                $this->getEntityManager()->flush(); //Set command as finished.
            }
            $this->getLogger()->crit($e);
        }
    }   
    
    /**
     * Updates the status of a command.
     */
    private function updateCommand(\Cli\Entity\CommandInterface $Command , $Status){
        $Command->setStatus($Status);
        $this->getEntityManager()->persist($Command);
        $this->getEntityManager()->flush(); //Flush the command
    }

}
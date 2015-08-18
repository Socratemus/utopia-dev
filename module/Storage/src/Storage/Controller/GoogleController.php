<?php

namespace Storage\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class GoogleController extends AbstractActionController {

	private $_client_secret = 'data/files/client_secret.json';
	private $_drivate_api_credidentials = 'data/cache/drive-api-quickstart.json';
	private $_app_name = 'Drive API Quickstart';

	public function __construct(){
		parent::__construct();
		//define('STDIN',fopen("php://stdin","r"));
		// define('APPLICATION_NAME', $this->_app_name);
		// define('CREDENTIALS_PATH', $this->_drivate_api_credidentials);
		// define('CLIENT_SECRET_PATH', $this->_client_secret);
		// define('SCOPES', implode(' ', array(
		//   \Google_Service_Drive::DRIVE_METADATA_READONLY)
		// ));

	}

	public function indexAction(){
		try
		{
			
			$gdrive = $this->getServiceLocator()->get('GoogleDrive');
			
			$gdrive->test();
			
			// $files = $gdrive->getFiles();
			// var_dump($files);	
			
			// $client = $gdrive->getClient();
			// $service = new \Google_Service_Drive($client);
			
			// // Print the names and IDs for up to 10 files.
			// $optParams = array(
			//   'maxResults' => 50,
			//   //'q' =>"'0B4J6tqBAradyfl9HVmdJNEpFY0ZkbFM0MXktUkJEaFRCQWJWdDdtQlU4M2hKQnZnaEN0SEk' in parents"
			// );
			// $results = $service->files->listFiles($optParams);
			
			// if (count($results->getItems()) == 0) {
			//   print "No files found.\n";
			// } else {
			//   //print "Files:\n";
			//   foreach ($results->getItems() as $file) {
			//     //printf("%s (%s)\n", $file->getTitle(), $file->getId());
			//     var_dump($file->getTitle()); 
	
			//   }
			// }
			
			exit('oky');
		}
		catch(\Exception $e)
		{
			echo $e->getMessage();
			exit('err');
		}
		
	}
	
	public function loginAction(){
		try
		{
			
			$gdrive = $this->getServiceLocator()->get('GoogleDrive');
			
			echo $gdrive->createAuthUrl();
			exit;
		}
		catch(\Exception $e)
		{
			echo $e->getMessage();
			exit('');
		}
	}

	/**************************************************************************/
	/* The authentification request return path. */
	/**************************************************************************/
	public function googleReturnAction()
	{
		try
		{
			$gdrive = $this->getServiceLocator()->get('GoogleDrive');
			$authCode = $this->params()->fromQuery('code');
			$gdrive->authenticate($authCode);
			
			exit('succesfully logged!');	
		}
		catch(\Exception $e)
		{
			var_dump($e->getMessage());
			$this->getLogger()->crit($e);
			exit('authenticate failed!');	
		}
	}

}
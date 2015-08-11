<?php

namespace Storage\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class GoogleController extends AbstractActionController {

	private $_client_secret = 'data/client_secret.json';
	private $_drivate_api_credidentials = '.data/drive-api-quickstart.json';
	private $_app_name = 'Drive API Quickstart';

	public function __construct(){
		parent::__construct();
		define('STDIN',fopen("php://stdin","r"));
		define('APPLICATION_NAME', $this->_app_name);
		define('CREDENTIALS_PATH', $this->_drivate_api_credidentials);
		define('CLIENT_SECRET_PATH', $this->_client_secret);
		define('SCOPES', implode(' ', array(
		  \Google_Service_Drive::DRIVE_METADATA_READONLY)
		));

	}

	public function indexAction()
    {  
    	session_start();
    	// @session_destroy();exit;
    	//var_dump($_SESSION);exit;

    	try{
    		echo '<pre>';

		// Get the API client and construct the service object.
		$client = $this->getClient();
		var_dump($client->getAccessToken());exit;
		//var_dump($client->logout());exit;
		$service = new \Google_Service_Drive($client);
		//exit('wow');
		// Print the names and IDs for up to 10 files.
		$optParams = array(
		  'maxResults' => 50,
		  'q' =>"'0B4J6tqBAradyfl9HVmdJNEpFY0ZkbFM0MXktUkJEaFRCQWJWdDdtQlU4M2hKQnZnaEN0SEk' in parents"
		);
		$results = $service->files->listFiles($optParams);

		if (count($results->getItems()) == 0) {
		  print "No files found.\n";
		} else {
		  //print "Files:\n";
		  foreach ($results->getItems() as $file) {
		    //printf("%s (%s)\n", $file->getTitle(), $file->getId());
		    var_dump($file->getTitle()); 

		  }
		}


    	exit('');

    	}
    	catch(\Exception $e)
    	{
    		echo $e->getMessage();

    		exit;
    	}
    	

	}

	/**
	 * Returns an authorized API client.
	 * @return Google_Client the authorized client object
	 */
	public function getClient() {
	  $client = new \Google_Client();
	  $client->setApplicationName(APPLICATION_NAME);
	  $client->setScopes(SCOPES);
	  $client->setAuthConfigFile(CLIENT_SECRET_PATH);
	  $client->setAccessType('offline');
	  //$client->revokeToken(); exit;
	  //$client->setAccessToken(null);
	  //var_dump($client->isAccessTokenExpired());
	  // Load previously authorized credentials from a file.
	  $credentialsPath = $this->expandHomeDirectory(CREDENTIALS_PATH);
	  if (file_exists($credentialsPath)) {
	  	//var_dump($credentialsPath);exit;
	  	//unlink($credentialsPath);exit;
	    $accessToken = file_get_contents($credentialsPath);
	    //var_dump($accessToken);exit;
	  } else {
	    // Request authorization from the user.
	    $authUrl = $client->createAuthUrl();
	    printf("Open the following link in your browser: <br/>\n%s\n", $authUrl);
	    print '<br/><br/>Enter verification code: ';
	    $authCode = trim(fgets(STDIN));
	    $authCode = $_GET['code'];
	    //var_dump($authCode);exit;
	    // Exchange authorization code for an access token.
	    $accessToken = $client->authenticate($authCode);

	    // Store the credentials to disk.
	    if(!file_exists(dirname($credentialsPath))) {
	      mkdir(dirname($credentialsPath), 0700, true);
	    }
	    file_put_contents($credentialsPath, $accessToken);
	    printf("Credentials saved to %s\n", $credentialsPath);
	  }
	  $client->setAccessToken($accessToken);
	  $refreshToken = $client->getAccessToken();
	  $_SESSION['refresh_token'] = $refreshToken;
  	  // var_dump($client->getRefreshToken());
  	  // var_dump($refreshToken);exit;
	  // Refresh the token if it's expired.
	  // if ($client->isAccessTokenExpired()) {

	  //   $client->refreshToken($client->getRefreshToken());

	  //   exit('wow');
	  //   file_put_contents($credentialsPath, $client->getAccessToken());
	  // }
	  return $client;
	}

	/**
	 * Expands the home directory alias '~' to the full path.
	 * @param string $path the path to expand.
	 * @return string the expanded path.
	 */
	public function expandHomeDirectory($path) {
	  $homeDirectory = getenv('HOME');
	  if (empty($homeDirectory)) {
	    $homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
	  }
	  return str_replace('~', realpath($homeDirectory), $path);
	}

}
<?php

namespace Storage\Service;
use Application\Service\ModelService as Service;

class GoogleDrive extends Service {
	protected $Settings = array();
	protected $Client  = null;
	protected $Service = null;
	private $_appName = 'GoogleDriveTest';
	private $_scope = null;
	private $_clientSecretPath = 'null';
	private $defaultFolderId = '0B4J6tqBAradyfl9HVmdJNEpFY0ZkbFM0MXktUkJEaFRCQWJWdDdtQlU4M2hKQnZnaEN0SEk';

	public function __construct()
	{
		//echo 'on service construct.';
	}

	public function init()
	{
		$config = $this->getServiceLocator()->get('Config');
		if(!isset($config['google_settings']))
		{
			throw new \Exception('Google drive api settings not set in config file.');
		}
		
		$this->Settings = $config['google_settings'];
		
		$this->_scope = implode(' ', array(
			\Google_Service_Drive::DRIVE_METADATA_READONLY,
			\Google_Service_Drive::DRIVE_FILE
			)
		);
		
		$this->setClient();
	}

	
	/**
	 * Returns the logged google client.
	 */
	public function getClient()
	{
		$client = $this->Client;
		$credentialsPath = getcwd() . '/' . $this->Settings['CREDENTIALS_PATH'];
		if (file_exists($credentialsPath)) {
		    $accessToken = file_get_contents($credentialsPath);
		} else {
    		throw new \Exception('You must log an account first.');
		}
		
		$client->setAccessToken($accessToken);
		$refreshToken = $client->getAccessToken();
		$_SESSION['refresh_token'] = $refreshToken;
	    $client->setAccessToken($accessToken);
	    $this->Client = $client;
		return $this->Client;
		
	}
	
	/**
	 * 
	 */
	public function getService()
	{
		if(!$this->Service)
		{
			$this->Service = new \Google_Service_Drive($this->getClient());
		}
		
	 	return $this->Service;
	}
	
	/**
	 * 
	 */
	public function getFiles($Id = '0B4J6tqBAradyfl9HVmdJNEpFY0ZkbFM0MXktUkJEaFRCQWJWdDdtQlU4M2hKQnZnaEN0SEk')
	{
		$service = $this->getService();
		$optParams = array(
			  'maxResults' => 50,
			  'q' =>"'".$Id."' in parents"
		);
		$results = $service->files->listFiles($optParams);
		
		return $results->getItems();
	}
	
	/**
	 * $Options = array(
     * 			'mimeType' => $mimeType
	 * 			)
	 */
	public function uploadFile($Source , $Options = array())
	{
		$mimeType 		= isset($Options['MimeType']) ? $Options['mimeType'] :  mime_content_type($Source);
		$title 	  	 	= isset($Options['Title']) ? $Options['Title'] : 'NoTitle';	
		$description 	= isset($Options['Description']) ? $Options['Description'] : '';
		
		$service = $this->getService();
		$file = new \Google_Service_Drive_DriveFile();
		$file->setTitle('test');
		$file->setDescription('custom description');
		$file->setMimeType($mimeType);
		$parentId = $parentId ? $parentId : $this->defaultFolderId;
		// Set the parent folder.
		if ($parentId != null) {
			$parent = new \Google_Service_Drive_ParentReference();
			$parent->setId($parentId);
			$file->setParents(array($parent));
		}
		
		try {
			
			if(!file_exists($filename)){
				throw new \Exception('The file provided does not exists.');
			}
			
			$data = file_get_contents($filename);
			
			$createdFile = $service->files->insert($file, array(
			  'data' => $data,
			  'mimeType' => $mimeType,
			  'uploadType' => 'media'
			));
			
			return $createdFile;
		} 
		catch (Exception $e) 
		{
			print "An error occurred: " . $e->getMessage();
		}
	}
	
	public function test(){
		$file = getcwd() . '/data/Filemanager/Products/RO150807104549F27655DF6/IMG201508071045451F42EFMD.png';
		
		$this->uploadFile($file , mime_content_type($file));
		
		
	}
	
	public function authenticate($AuthCode)
	{
		$credentialsPath = getcwd() . '/' . $this->Settings['CREDENTIALS_PATH'];
		$accessToken = $this->Client->authenticate($AuthCode);
	
	    //Store the credentials to disk.
	    if(!file_exists(dirname($credentialsPath))) {
	      mkdir(dirname($credentialsPath), 0700, true);
	    }
	    file_put_contents($credentialsPath, $accessToken);
	    //printf("Credentials saved to %s\n", $credentialsPath);
	    $refreshToken = $this->Client->getAccessToken();
	    //var_dump($refreshToken);exit;
	    /* Maybe i should savethe access token also */
	    /* Will decide after i see if it expires and needs refresh. */
	    
	}
	
	public function createAuthUrl()
	{
		$authUrl = $this->Client->createAuthUrl();
		return $authUrl;
	}
	
	public function isAvailable()
	{
		return $this->Client->getAccessToken() == null ? false : true;
		return $this->Client->getAccessToken()->authenticated;
	}
	
	/**************************************************************************/
	private function setClient(){
		$client = new \Google_Client();
	    $client->setApplicationName($this->_appName);
		$client->setScopes($this->_scope);
		$client->setAuthConfigFile( getcwd() .'/'. $this->Settings['CLIENT_SECRET_PATH']);
		$client->setAccessType('offline');
		$this->Client = $client;
	}
}
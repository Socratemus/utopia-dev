<?php

namespace Geoname\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Service\ModelService;

class GeonameManager extends ModelService {
    
    const API_URL       = 'http://api.geonames.org/searchJSON';
    
    const API_CHD_URL   = 'http://api.geonames.org/children?username=socratemus&type=JSON';
    
    protected $Parameters = array (
        'username'  => 'socratemus',
        'country'   => 'RO',
        'featureCode' => 'ADM1'
    );
    
    protected $DefaultTableName = 'geonames';
    
    protected $DefaultHierTableName = 'geoname_hierarchy';
    
    protected $SourceFile = '/data/geonames/geonames.sql';
    
    protected $HierarchyFile = '/data/geonames/geoname_hierarchy.sql';
    
    protected $OutputPath       = '/public/data/';
    
    public function __construct(){
        //parent::__construct();
        
    }
    
    
    public function import(){
        try {
            //Truncate tables
            $sql = "TRUNCATE TABLE $this->DefaultTableName; TRUNCATE TABLE $this->DefaultHierTableName;";
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->execute();
            
            $content = file_get_contents(getcwd() . $this->SourceFile)  ;
            $sql = $content;
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->execute();
            
            $content = file_get_contents(getcwd() . $this->HierarchyFile)  ;
            $sql = $content;
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->execute();
            
            // $sql = "select * FROM $this->DefaultTableName" ;
            // $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            // $stmt->execute();
            
            // while (($result = $stmt->fetch(\PDO::FETCH_ASSOC))) {
            //     // stuff with $result
            //     $geoname = new \Geoname\Entity\Geoname();
            //     $geoname->setGeonameId($result['Id']);
            //     $geoname->setName($result['Name']);
            //     $geoname->setPopulation($result['Population']);
            //     $geoname->setLatitude($result['Latitude']);
            //     $geoname->setLongitude($result['Longitude']);
            // }
            //$this->getEntityManager()->flush($geoname);
            
        } catch(\Exception $e){
            $this->getLogger()->crit($e);
            return false;
        }
        
    }
    
    /**************************************************************************/
    
    public function getDistricts(){
        try
        {
            //$em = $this->ServiceManager->get('EntityManager');
            
            $url = self::API_URL;
            
            $params = $this->Parameters;
            $query = http_build_query($params);
            $url .= '?' . $query;
            $ch = curl_init(); 
            //var_dump($url);exit;
            // set url 
            curl_setopt($ch, CURLOPT_URL, $url); 
    
            //return the transfer as a string 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    
            // $output contains the output string 
            $output = curl_exec($ch); 
    
            // close curl resource to free up system resources 
            curl_close($ch);  
            
            $data=  json_decode($output,1);
            
            $counties = $this->parseGeonames($data['geonames']);
            
            // foreach($counties as $county){
             
            //     $this->generateFile($county);    
            // }
            
            return $counties;
            
        }
        catch (\Exception $e)
        {
            
            $this->getLogger()->crit($e);
            return false;
        }
    }
    
    public function getCounties( $Districts ){
        
        try {
            
            foreach($Districts as $district) {
                
                $chd = $this->getChildren($district['GeonameId']);
                //var_dump($chd);exit;
                $this->generateFile($district , $chd);
            }
            
                
        } catch(\Exception $e){
            
            return false;
        }
        
        
    }
    
    public function getChildren( $GeonameId ) {
        try {
            
            $url = self::API_CHD_URL;
            $params = array('geonameId' => $GeonameId);
            $query = http_build_query($params);
            $url .= '&' . $query;
            //var_dump($url);exit;
            $ch = curl_init(); 
            // set url 
            curl_setopt($ch, CURLOPT_URL, $url); 
            //return the transfer as a string 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            // $output contains the output string 
            $output = curl_exec($ch); 
            // close curl resource to free up system resources 
            curl_close($ch);  
            
            $data =  json_decode($output,1);
            
            if(!isset($data['geonames']) || empty($data['geonames'])){
                return array();
            }
            
            $geonames = $this->parseGeonames($data['geonames']);
            
            return $geonames;
        }
        catch(\Exception $e){
            $this->getLogger()->crit($e);
            return array();
        }
    }
    
    public function generateFiles(){
        $sql = "select * FROM $this->DefaultTableName WHERE FeatureCode = 'ADM1'" ;
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute();
        $i = 1;
        while (($result = $stmt->fetch(\PDO::FETCH_OBJ))) {
            
            //var_dump($i . ' ' .$result->Name);
            
            $sql = "SELECT * FROM geonames as Geoname
                    JOIN geoname_hierarchy AS Hier ON Geoname.Id = Hier.ChildId
                    WHERE Hier.ParentId = $result->Id" ;
            
            /* TEST PRAHOVA */
            // $sql = "SELECT * FROM geonames as Geoname 
            //     JOIN geoname_hierarchy AS Hier ON Geoname.Id = Hier.ChildId
            //     WHERE Hier.ParentId = 669737";
            /*
                SELECT * FROM geonames as Geoname 
                JOIN geoname_hierarchy AS Hier ON Geoname.Id = Hier.ChildId
                WHERE Hier.ParentId = 669737
            */
                    
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(); // District counties
            
            //Write them to JSON FILE
            
            //var_dump($results);
            $i++;
        }
    }
    
    public function generateFile($Geoname , $Contents){
        $sf = getcwd() . $this->OutputPath;
        
        if(!file_exists($sf)){
            mkdir($sf , 0777);
            //echo 'nu exista';
        }
        
        $output = $sf . $Geoname['GeonameId'] . ' - ' . $Geoname['Name'] . '.json';
        file_put_contents($output , json_encode($Contents));
        
    }
    
    private function parseGeonames($Geonames){
        
        if(!isset($Geonames) || empty($Geonames)){
            return array();
        }
        
        $em = $this->getEntityManager();
        
        $locations = array();
        
        foreach($Geonames as $geoname){
            
            $geonameEntity = new \Geoname\Entity\Geoname();
            $geonameEntity->setGeonameId($geoname['geonameId']);
            $geonameEntity->setName($geoname['name']);
            $geonameEntity->setLatitude($geoname['lat']);
            $geonameEntity->setLongitude($geoname['lng']);
            $geonameEntity->setPopulation($geoname['population']);
            $geonameEntity->setCountryCode($geoname['countryCode']);
            array_push($locations , $geonameEntity->toArray());
            
            $em->persist($geonameEntity);
            
        }
        
        //$em->flush();
        
        return $locations;
    }
    
}
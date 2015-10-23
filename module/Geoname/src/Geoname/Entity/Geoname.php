<?php

namespace Geoname\Entity;

use Application\Entity\AbstractEntity as AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="geoname")
 */
class Geoname extends  \Application\Entity\Entity {
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $GeonameId;
    
    /**
     * @ORM\Column(type="string" , length=255 , nullable = false)
     */
    protected $Name;
     
    //protected $AsciiName;
    
    //protected $AlternateNames;
    
    /**
     * @ORM\Column(type="string" , length=255 , nullable = false)
     */
    protected $Latitude;
    
    /**
     * @ORM\Column(type="string" , length=255 , nullable = false)
     */
    protected $Longitude;
    
    //protected $FeatureClass;
    
    //protected $FeatureCode;
    
    /**
     * @ORM\Column(type="string" , length=255 , nullable = false)
     */
    protected $CountryCode;
    
    //protected $Cc2;
    
    //protected $Admin1Code;
    
    //protected $Admin2Code;
    
    //protected $Admin3Code;
    
    //protected $Admin4Code;
    
    /**
     * @ORM\Column(type="string" , length=255 , nullable = false)
     */
    protected $Population;
    
    //protected $Elevation;
    
    //protected $Dem;
    
    //protected $Timezone;
    
    //protected $ModificationDate;
    
    
    public function __construct(){
        parent::__construct();
    }
    
    public function setGeonameId($GeonameId){
        $this->GeonameId = $GeonameId;
    }
    public function setName($Name){
        $this->Name = $Name;
    }
    
    public function setCountryCode($CountryCode){
        $this->CountryCode = $CountryCode;
    }
    
    public function setPopulation($Population){
        $this->Population = $Population;
    }
    
    public function setLatitude($Latitude){
        $this->Latitude = $Latitude;
    }
    
    public function setLongitude($Longitude){
        $this->Longitude = $Longitude;
    }
    
    
}
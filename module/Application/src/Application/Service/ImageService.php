<?php

namespace Application\Service;
use Application\Entity\Image as Image;
class ImageService extends ModelService {
    
    protected $DataFolder;
    protected $FileManagerFolder;
    protected $ProductImagesFolder;
    protected $TemporaryFileFolder;
    
    public function __construct(){
        $this->DataFolder = '/data/';
        $this->FileManagerFolder = 'Filemanager/';
        $this->ProductImagesFolder = 'ProductImages/';
        $this->TemporaryFileFolder = 'Temp/';
    }
    
    public function test(){
        // $id = '204534dd72367c3c86044594fda9674c';
        // $this->fromTempStorage($id);
        $id = '18a90a70fc6c7035f2490adfd585ab43';
        $folder = $this->fromTempStorage($id);
        echo $folder;
    }
    
    public function fromTempStorage($Id)
    {
        $file = $this->getTemporaryFolder() .  $Id . '.png';
        if(!file_exists($file)){
            throw new \Exception('File ' . $file . ' doest not exits on server.');
        }
        
        $outputFolder = $this->getTemporaryFolder() .  $Id . '/';
        if(file_exists($outputFolder)){
            $this->clearDir($outputFolder);
        }
        mkdir($outputFolder);    
        $outputSmall  = $outputFolder . 'small_' . $Id . '.png';
        $outputMedium = $outputFolder . 'medium_' . $Id . '.png';
        $outputHuge   = $outputFolder . 'huge_' . $Id . '.png';
        
        $data = array(
            'GUID' => $Id,
            'Small' => $outputSmall,
            'Medium' => $outputMedium,
            'Huge' => $outputHuge
        );
        
        $this->process($file , $outputSmall , Image::$DIMENTIONS['SMALL']);
        $this->process($file , $outputMedium , Image::$DIMENTIONS['MEDIUM']);
        $this->process($file , $outputHuge , Image::$DIMENTIONS['HUGE']);
        unlink($file);
        $this->getEntityManager()->flush();
        
        return $Id;
    }
    
    public function fromServer($Path)
    {
        
    }
    
    public function fromLink($Url)
    {
        $id = md5($Url . uniqid() . rand(1,1999));
        $outputFolder = $this->getTemporaryFolder() .  $id . '/';
        if(file_exists($outputFolder)){
            $this->clearDir($outputFolder);
        }
        mkdir($outputFolder , 0777);
        
        $outputSmall  = $outputFolder . '/small_' . md5(rand(1,999) . microtime()) . '.png';
        $outputMedium = $outputFolder . '/medium_' . md5(rand(1,999) . microtime()) . '.png';
        $outputHuge   = $outputFolder . '/huge_' . md5(rand(1,999) . microtime()) . '.png';
        $this->process($Url , $outputSmall , Image::$DIMENTIONS['SMALL']);
        $this->process($Url , $outputMedium , Image::$DIMENTIONS['MEDIUM']);
        $this->process($Url , $outputHuge , Image::$DIMENTIONS['HUGE']);
        return $id;
    }
    
    public function processFolder( $GUID , $NewFolderPath )
    {
        
        $image = new \Application\Entity\Image();
        /* DO PROCESSING */
        $uri = $this->getBaseUri();
        
        $data = array(
            'GUID' => $GUID    
        );
        
        $newPath = $this->getProductImagesFolder() . $NewFolderPath . '_' .  $GUID . '/';
        $currFolder = $this->getTemporaryFolder() . $GUID . '/';
        if(! file_exists($currFolder)){
            throw new \Exception('Folder was not found.');
        }
        
        if(file_exists($newPath)){
            $this->clearDir($newPath);
        }
        mkdir($newPath , 0777);
       
        $files = scandir($currFolder);
        $source = $currFolder;
        $destination = $newPath;
        foreach ($files as $file) {
          if (in_array($file, array(".",".."))) continue;
          // If we copied this successfully, mark it for deletion
          if (copy($source.$file, $destination.$file)) {
            $delete[] = $source.$file;
          }
        }
        $this->clearDir($currFolder);
        
        $absPath = $this->getBaseUri() . $this->getProductImagesFolder(false) . $NewFolderPath . '_' .  $GUID . '/';
        
        $data = array(
            'GUID' => $GUID,
            'Folder' => $newPath,
            'Small' => $absPath . 'small_' . $GUID . '.png',
            'Medium' => $absPath . 'medium_' . $GUID . '.png',
            'Huge' => $absPath . 'huge_' . $GUID . '.png'
        );
        $image->exchange($data);
        // var_dump($image);
        // exit;
        return $image;
        
    }
    
    protected function process($In , $Out , $Options = array())
    {
        $im = new \Imagick($In);
        $nw = isset($Options['width']) ? $Options['width'] : 300;
        $nh = isset($Options['height']) ? $Options['height'] : 300;
        $imageprops = $im->getImageGeometry();
        $width = $imageprops['width'];
        $height = $imageprops['height'];
        if($width > $height){
            $newHeight = $nh;
            $newWidth = ($nw / $height) * $width;
        }else{
            $newWidth = $nw;
            $newHeight = ($nh / $width) * $height;
        }
        $im->resizeImage($newWidth,$newHeight, \Imagick::FILTER_LANCZOS, 0.9, true);
        $im->cropImage ($nw,$nh,0,0);
        $im->writeImage( $Out );
    }
    
    private function clearDir($dir){
       
        if (is_dir($dir)) { 
            $objects = scandir($dir); 
            foreach ($objects as $object) { 
                if ($object != "." && $object != "..") { 
                    if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
                } 
            } 
        reset($objects); 
        rmdir($dir); 
        } 
 
    }
    
    /**********************************************************************/
    public function getDataFolder($Absoulte = true){
        return $Absoulte ? getcwd() . $this->DataFolder : $this->DataFolder;
    }
    public function getFileManagerFolder( $Absoulte = true){
        return $this->getDataFolder($Absoulte) . $this->FileManagerFolder;
    }
    
    public function getProductImagesFolder( $Absoulte = true ){
        return $this->getFileManagerFolder( $Absoulte ) . $this->ProductImagesFolder;
    }
    
    public function getTemporaryFolder(){
        return $this->getFileManagerFolder() . $this->TemporaryFileFolder;
    }
    
    public function getRepository(){
        return $this->getEntityManager()->getRepository('\Application\Entity\Image');
    }
       
}
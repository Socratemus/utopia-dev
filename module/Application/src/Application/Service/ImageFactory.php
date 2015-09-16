<?php

namespace Application\Service;
use Application\Entity\Image as Image;

/**
 * Image service that will process every folder
 * The paths should be set from the configuration
 * Resize adaptor will be GD PHP Image library by default 
 * or IMAGICK if the class exists.
 * The image sizes will use some default values, or if given from the option parameter.
 */
class ImageFactory extends ModelService {
    
    protected $DataFolder       = 'data/';
    protected $Uploads          = 'data/uploads';
    protected $ProductFolder    = 'data/uploads/products';
    protected $TempFolder       = 'data/uploads/temp';
    
    
    public function __construct(  ){
        
    }
    
    /**
     * Uploads an image to temporary folder
     * Creates a new image.
     */
    public function receive($file , $options = array()){
        $httpadapter = new \Zend\File\Transfer\Adapter\Http(); 
        $filesize  = new \Zend\Validator\File\Size(array('min' => 1000 )); //1KB  
        $extension = new \Zend\Validator\File\Extension(array('extension' => array('txt', 'jpg' , 'png')));
        $httpadapter->setValidators(array($filesize, $extension), $file['name']);
        
        $hash = md5(rand(1,1999) . uniqid() . microtime());
        /* $fid represents fileid */
        $fid = strtoupper('img' . date('YmdHis') . substr($hash , 0, 6));
        
        if($httpadapter->isValid($file['name'])) {
            $httpadapter->addFilter('File\Rename',
                array(
                    'target' => $this->TempFolder . DIRECTORY_SEPARATOR . $fid . '.png',
                    'overwrite' => true
                )
            );
            
            if($httpadapter->receive($file['name'])) {
                //$this->JsonResponse->setMessage('File succesfully uploaded.');
                $newfile = $httpadapter->getFileName(); 
            } else {
                throw new \Exception('Upload failed on receive method');
            }
        } else {
            throw new \Exception('Upload failed on receive method[File is not valid]');
        }
        
        $filepath = $this->TempFolder . DIRECTORY_SEPARATOR . $fid . '.png';
        $fdid = $this->TempFolder . DIRECTORY_SEPARATOR . $fid;
        mkdir($fdid , 0777);
        
        $data = array(
            'Small'     => $fdid . DIRECTORY_SEPARATOR .  $fid . 'XS.png',    
            'Medium'    => $fdid . DIRECTORY_SEPARATOR .  $fid . 'SM.png',
            'Huge'      => $fdid . DIRECTORY_SEPARATOR .  $fid . 'MD.png',
            'Orig'      => $fdid . DIRECTORY_SEPARATOR .  $fid . 'OG.png',
        );
        
        $xsopt = isset($options['xs']) ? $options['xs'] : Image::$DIMENTIONS['SMALL'];
        $this->process($filepath , $data['Small'] , $xsopt);
        $smopt = isset($options['sm']) ? $options['sm'] : Image::$DIMENTIONS['MEDIUM'];
        $this->process($filepath , $data['Medium'] , $smopt);
        $mdopt = isset($options['md']) ? $options['md'] : Image::$DIMENTIONS['HUGE'];
        //var_dump($mdopt);exit;
        $this->process($filepath , $data['Huge'] , $mdopt);
        $image = new Image();
        $data = array(
            'Small' => $this->getBaseUri() . DIRECTORY_SEPARATOR . $this->TempFolder . DIRECTORY_SEPARATOR . $fid . DIRECTORY_SEPARATOR . $fid . 'XS.png',
            'Medium' => $this->getBaseUri() . DIRECTORY_SEPARATOR . $this->TempFolder . DIRECTORY_SEPARATOR . $fid . DIRECTORY_SEPARATOR . $fid . 'SM.png',
            'Huge' => $this->getBaseUri() . DIRECTORY_SEPARATOR . $this->TempFolder . DIRECTORY_SEPARATOR . $fid . DIRECTORY_SEPARATOR . $fid . 'MD.png',
            'Folder' =>  $this->TempFolder,
            'GUID' => $fid
        );
        $image->exchange($data);
        $this->getEntityManager()->persist($image);
        $this->getEntityManager()->flush();
        unlink($filepath);
        return $image;
    }
    
    /**
     * Moves a given image to a given folder
     */
    public function move( $Image , $Folder ){
        //var_dump($Image);exit;
        $destpath = $this->Uploads . DIRECTORY_SEPARATOR . $Folder;
        //
        if(!file_exists($destpath)){
            mkdir($destpath , 0777);
        }
        $destpath .= DIRECTORY_SEPARATOR . $Image->getGUID() . DIRECTORY_SEPARATOR;
        if(!file_exists($destpath)){
            mkdir($destpath , 0777);
        } else {
            //Clear folder contents
        }
        
        $currpath = $Image->getFolder() . DIRECTORY_SEPARATOR . $Image->getGUID() . DIRECTORY_SEPARATOR;
        if(!file_exists($currpath)){
            throw new \Exception('Image is corupted[File path is not valid]');
        }
       
        $files = scandir($currpath);
        
        foreach ($files as $file) {
          if (in_array($file, array(".",".."))) continue;
          // If we copied this successfully, mark it for deletion
          if (copy($currpath.$file, $destpath.$file)) {
            $delete[] = $currpath.$file;
          }
        }
        $Image->setFolder($this->Uploads . DIRECTORY_SEPARATOR . $Folder);
        $Image->setSmall(str_replace($this->TempFolder , $Image->getFolder() , $Image->getSmall() ));
        $Image->setMedium(str_replace($this->TempFolder , $Image->getFolder() , $Image->getMedium() ));
        $Image->setHuge(str_replace($this->TempFolder , $Image->getFolder() , $Image->getHuge() ));
        $this->getEntityManager()->persist($Image);
        $this->getEntityManager()->flush();
        $this->clear($currpath);
        return $Image;
        
       
    }
    
    /**
     * Removes a given image.
     */
    public function remove( $Image ){
        $folder = $Image->getFolder();
        $imfolder = $folder . DIRECTORY_SEPARATOR . $Image->getGUID();
        $this->clear($imfolder);
        $this->getEntityManager()->remove($Image);
    }
    
    public function getByGUID( $GUID ){
        return $this->getRepository()->findBy(array('GUID' => $GUID));
    }
    
    private function process($In , $Out , $Options = array())
    {   
        usleep(100000); //100 ms
        $im = new \Imagick($In);
       
        $nw = isset($Options['width']) ? $Options['width'] : 300;
        $nh = isset($Options['height']) ? $Options['height'] : 300;
        //var_dump($nh); exit;
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
        $im->resizeImage($nw,$nh, \Imagick::FILTER_LANCZOS, 0.9, true);
        $im->cropImage ($nw,$nh,0,0);
        $im->writeImage( $Out );
        //echo ('CROPED AT : ' . $nw . ' - ' .$nh );
    }
    
    private function clear( $Directory ){
       
        if (is_dir($Directory)) { 
            $objects = scandir($Directory); 
            foreach ($objects as $object) { 
                if ($object != "." && $object != "..") { 
                    if (filetype($Directory."/".$object) == "dir") rrmdir($Directory."/".$object); else unlink($Directory."/".$object); 
                } 
            } 
        reset($objects); 
        rmdir($Directory); 
        } 
 
    }
    
    /**********************************************************************/
    // public function getDataFolder($Absoulte = true){
    //     return $Absoulte ? getcwd() . $this->DataFolder : $this->DataFolder;
    // }
    // public function getFileManagerFolder( $Absoulte = true){
    //     return $this->getDataFolder($Absoulte) . $this->FileManagerFolder;
    // }
    
    // public function getProductImagesFolder( $Absoulte = true ){
    //     return $this->getFileManagerFolder( $Absoulte ) . $this->ProductImagesFolder;
    // }
    
    // public function getTemporaryFolder(){
    //     return $this->getFileManagerFolder() . $this->TemporaryFileFolder;
    // }
    
    public function getRepository(){
        return $this->getEntityManager()->getRepository('\Application\Entity\Image');
    }
    /**********************************************************************/
}
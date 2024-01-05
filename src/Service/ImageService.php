<?php

namespace App\Service;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;

class ImageService extends AbstractEntityService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }

    public static $entityFqn = Image::class;

    public function uploadImage()
    {
        $target_dir = "assets/uploads/";
        
        // var_dump($_FILES);
        
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

        if($check !== false) {
            var_dump("File is an image - " . $check["mime"] . ".");
            $uploadOk = 1;
        } else {
            var_dump("File is not an image.");
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            var_dump("Sorry, file already exists.");
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            var_dump("Sorry, your file is too large.");
            $uploadOk = 0;
        }

        // Allow certain file formats
        // if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        // && $imageFileType != "gif" ) {
        // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        // $uploadOk = 0;
        // }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            var_dump("Sorry, your file was not uploaded.");
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                var_dump("The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.");
            } else {
                var_dump("Sorry, there was an error uploading your file.");
            }
        }

    }

}
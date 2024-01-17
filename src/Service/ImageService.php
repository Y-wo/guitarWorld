<?php

namespace App\Service;

use App\Constants\SystemWording;
use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;

class ImageService extends AbstractEntityService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }

    public static $entityFqn = Image::class;

    public function uploadImage() : array
    {
        $target_dir = "assets/uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $isUploaded = false;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        $message = "";
        $fileExists = false;

        if($check !== false) {
            $uploadOk = 1;
        } else {
            $message = SystemWording::UPLOAD_WRONG_TYPE;
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $message = SystemWording::UPLOAD_EXISTS;
            $uploadOk = 1;
            $fileExists = true;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $message = SystemWording::UPLOAD_TOO_BIG;
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $message = SystemWording::UPLOAD_WRONG_TYPE;
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
        // var_dump("Sorry, your file was not uploaded.");
        // if everything is ok, try to upload file
        } else {
            if ($fileExists) {
                $message = "Die File hat bereits existiert. Verknüpfung wurde erstellt.";
                $isUploaded = true;
            }
            else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $message = "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                    $isUploaded = true;
                    $this->createNewImage($target_file);
                } 
                else {
                    $message = "Sorry, there was an error uploading your file.";
                }
            }
        }

        return [
            'isUploaded' => $isUploaded,
            'message' => $message,
            'targetFile' => $target_file,
            'fileExists' => $fileExists
        ];
    }

    
    /*
    * creates new image
    */
    public function createNewImage($source) : ?int 
    {
        $image = new Image();
        $image->setName($source);
        return $this->store($image) ? $image->getId() : null;
    }

    /*
    * Get Image by name
    */
    public function getImageByName(string $name) : ?Image
    {
        $query = $this
            ->entityManager
            ->getRepository(self::$entityFqn)
            ->createQueryBuilder('r')
            ->select('r')
            ->where('r.name = :name')
            ->setParameter('name', $name)
        ;

        return $query->getQuery()->execute()[0] ?? null;
    }

}
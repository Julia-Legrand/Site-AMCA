<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class PictureService
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function add(UploadedFile $tripPicture, ?string $folder = '', ?int $width = 200, ?int $height = 200)
    {
        // Rename new pictures
        $fichier = md5(uniqid(rand(), true)) . '.png';

        // Get informations about picture
        $tripPictureInfos = getimagesize($tripPicture->getPathname());

        if ($tripPictureInfos === false) {
            throw new \Exception('Format d\'image incorrect');
        }

        // Check format
        switch ($tripPictureInfos['mime']) {
            case 'image/png':
                $tripPictureSource = imagecreatefrompng($tripPicture->getPathname());
                break;
            case 'image/jpeg':
            case 'image/jpg':
                $tripPictureSource = imagecreatefromjpeg($tripPicture->getPathname());
                break;
            default:
                throw new \Exception('Format d\'image incorrect');
        }

        // Resize picture
        $imageWidth = $tripPictureInfos[0];
        $imageHeight = $tripPictureInfos[1];

        // Create new resized picture
        $resizedPicture = imagecreatetruecolor($width, $height);
        imagecopyresampled($resizedPicture, $tripPictureSource, 0, 0, 0, 0, $width, $height, $imageWidth, $imageHeight);

        // Path to store resized picture
        $path = $this->params->get('images_directory') . $folder;

        // Store resized picture in png format
        imagepng($resizedPicture, $path . $width . 'x' . $height . '-' . $fichier);

        // Move original picture to destination folder
        $tripPicture->move($path . '/', $fichier);

        return $fichier;
    }
}

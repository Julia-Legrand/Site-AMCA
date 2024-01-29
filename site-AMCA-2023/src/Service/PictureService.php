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

    public function add(UploadedFile $tripPicture, ?string $folder = '')
    {
        // Rename new pictures
        $fichier = md5(uniqid(rand(), true)) . '.png';

        // Path to store original picture
        $path = $this->params->get('images_directory') . $folder;

        // Move original picture to destination folder
        $tripPicture->move($path . '/', $fichier);

        return $fichier;
    }
}

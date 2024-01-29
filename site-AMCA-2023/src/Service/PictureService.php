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
        // Rename the new picture
        $fichier = md5(uniqid(rand(), true)) . '.png';

        // Path to store the picture
        $path = $this->params->get('images_directory') . $folder;

        // Move the picture to the destination folder
        $tripPicture->move($path . '/', $fichier);

        return $fichier;
    }
}

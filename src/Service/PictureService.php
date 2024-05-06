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

    public function addTripPicture(UploadedFile $tripPicture, ?string $folder = '')
    {
        // Use original name
        $fichier = $tripPicture->getClientOriginalName();

        // Path to store the picture
        $path = $this->params->get('images_directory') . $folder;

        // Move the picture to the destination folder
        $tripPicture->move($path . '/', $fichier);

        return $fichier;
    }

    public function addPostPicture(UploadedFile $postPicture, ?string $folder = '')
    {
        // Use original name
        $fichier = $postPicture->getClientOriginalName();

        // Path to store the picture
        $path = $this->params->get('images_directory') . $folder;

        // Move the picture to the destination folder
        $postPicture->move($path . '/', $fichier);

        return $fichier;
    }
}

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
        // Nouveau nom pour les images
        $fichier = md5(uniqid(rand(), true)) . '.png';

        // Obtention des informations sur l'image
        $tripPictureInfos = getimagesize($tripPicture->getPathname());

        if ($tripPictureInfos === false) {
            throw new \Exception('Format d\'image incorrect');
        }

        // Vérification du format de l'image
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

        // Redimensionnement de l'image
        $imageWidth = $tripPictureInfos[0];
        $imageHeight = $tripPictureInfos[1];

        // Création de la nouvelle image
        $resizedPicture = imagecreatetruecolor($width, $height);
        imagecopyresampled($resizedPicture, $tripPictureSource, 0, 0, 0, 0, $width, $height, $imageWidth, $imageHeight);

        // Chemin pour stocker l'image redimensionnée
        $path = $this->params->get('images_directory') . $folder;

        // Stockage de l'image redimensionnée au format PNG
        imagepng($resizedPicture, $path . $width . 'x' . $height . '-' . $fichier);

        // Déplacement de l'image originale vers le répertoire de destination
        $tripPicture->move($path . '/', $fichier);

        return $fichier;
    }
}

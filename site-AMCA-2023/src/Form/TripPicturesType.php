<?php

namespace App\Form;

use App\Entity\TripPictures;
use App\Entity\PreviousTrips;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class TripPicturesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tripPicture', FileType::class, [
                'label' => 'Photo de la sortie',
                'attr' => ['class' => 'custom-form'],
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2000k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Image trop lourde',
                    ])
                ],
            ])
            ->add('previousTrips', EntityType::class, [
                'class' => PreviousTrips::class,
                'choice_label' => function (PreviousTrips $previousTrips) {
                    return $previousTrips->getPreviousTripName();
                },
                'attr' => ['class' => 'custom-form'],
                'label' => 'Sortie',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TripPictures::class,
        ]);
    }
}

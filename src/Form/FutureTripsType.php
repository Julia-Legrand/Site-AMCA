<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\FutureTrips;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FutureTripsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('futureTripName', TextType::class, [
                'label' => 'Nom de la sortie',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('futureTripPicture', FileType::class, [
                'label' => 'Photo principale',
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
            ->add('startDate', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de départ',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('endDate', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de retour',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('budget', NumberType::class, [
                'label' => 'Budget à prévoir',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('futureTripContent', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('numberOfPlaces', NumberType::class, [
                'label' => 'Nombre de places',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('futureTripLon', NumberType::class, [
                'label' => 'Longitude',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('futureTripLat', NumberType::class, [
                'label' => 'Latitude',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('users', EntityType::class, [
                'class' => User::class,
                'label' => 'Adhérents :',
                'attr' => ['class' => 'usersChoice'],
                'choice_label' => function (User $user) {
                    return $user->getFirstName() . ' ' . $user->getLastName();
                },
                'multiple' => true,
                'expanded' => true,
                'choice_attr' => function ($choice, $key, $value) {
                    return ['style' => 'margin-right: 5px;'];
                },
            ])
            ->add('presentationSheet', FileType::class, [
                'label' => 'Fiche de présentation',
                'attr' => ['class' => 'custom-form'],
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2000k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Document ne répondant pas aux contraintes.',
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FutureTrips::class,
        ]);
    }
}

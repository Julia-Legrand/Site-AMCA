<?php

namespace App\Form;

use App\Entity\Meetings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MeetingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('meetingDate', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date et heure',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('meetingPicture', FileType::class, [
                'label' => 'Photo de la salle',
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
            ->add('meetingAddress', TextType::class, [
                'label' => 'Lieu de la réunion',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('meetingLon', NumberType::class, [
                'label' => 'Longitude',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('meetingLat', NumberType::class, [
                'label' => 'Latitude',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('meetingContent', TextareaType::class, [
                'label' => 'Texte de présentation',
                'attr' => ['class' => 'custom-form'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meetings::class,
        ]);
    }
}

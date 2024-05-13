<?php

namespace App\Form;

use App\Entity\Presentations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PresentationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('presentationTitle', TextType::class, [
                'label' => 'Titre',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('presentationPicture', FileType::class, [
                'label' => 'Photo des membres fondateurs',
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
            ->add('presentationContent', TextareaType::class, [
                'label' => 'Texte de présentation',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('logo', FileType::class, [
                'label' => 'Logo de l\'association',
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
            ->add('statutesDoc', FileType::class, [
                'label' => 'Statuts de l\'association',
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
            ])
            ->add('internalRulesDoc', FileType::class, [
                'label' => 'Règlement intérieur',
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
            ])
            ->add('otherClubTitle', TextType::class, [
                'label' => 'Nom du club',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('otherClubPicture', FileType::class, [
                'label' => 'Photo du club jumelé',
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
            ->add('otherClubContent', TextareaType::class, [
                'label' => 'Texte de présentation',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('otherClubWebsite', TextType::class, [
                'label' => 'Site internet',
                'attr' => ['class' => 'custom-form'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Presentations::class,
        ]);
    }
}

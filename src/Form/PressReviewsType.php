<?php

namespace App\Form;

use App\Entity\PressReviews;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PressReviewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pressReviewTitle', TextType::class, [
                'label' => 'Titre',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('pressReviewPicture', FileType::class, [
                'label' => 'Article',
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
            ->add('pressReviewDate', DateType::class, [
                'label' => 'Date de l\'article',
                'widget' => 'single_text',
                'attr' => ['class' => 'custom-form'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PressReviews::class,
        ]);
    }
}

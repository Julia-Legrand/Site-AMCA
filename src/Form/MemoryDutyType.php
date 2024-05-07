<?php

namespace App\Form;

use App\Entity\MemoryDuty;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MemoryDutyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('memoryTitle', TextType::class, [
                'label' => 'Nom et prénom, surnom',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('memoryPicture', FileType::class, [
                'label' => 'Sa plus belle photo',
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
            ->add('memoryContent', TextareaType::class, [
                'label' => 'Une petite description',
                'attr' => ['class' => 'custom-form'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MemoryDuty::class,
        ]);
    }
}

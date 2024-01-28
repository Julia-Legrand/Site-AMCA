<?php

namespace App\Form;

use App\Entity\PreviousTrips;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PreviousTripsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('previousTripName', TextType::class, [
                'label' => 'Nom de la sortie',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('previousTripContent', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('pictures', FileType::class, [
                'label' => 'Photos de la sortie',
                'attr' => ['class' => 'custom-form'],
                'multiple' => true,
                'mapped' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PreviousTrips::class,
        ]);
    }
}

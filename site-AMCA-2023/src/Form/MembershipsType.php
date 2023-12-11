<?php

namespace App\Form;

use App\Entity\Memberships;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class MembershipsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('membershipForm', FileType::class, [
                'label' => 'Bulletin d\'adhésion',
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
            ->add('driverFee', NumberType::class, [
                'label' => 'Cotisation conducteur',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('passengerFee', NumberType::class, [
                'label' => 'Cotisation passager',
                'attr' => ['class' => 'custom-form'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Memberships::class,
        ]);
    }
}

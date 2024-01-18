<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('memberNumber', TextType::class, [
                'label' => 'Numéro adhérent',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('assignment', ChoiceType::class, [
                'label' => 'Profil',
                'choices' => [
                    'Conducteur' => 'Conducteur',
                    'Passager' => 'Passager',
                ],
                'multiple' => false,
                'expanded' => true,
                'choice_attr' => function ($choice, $key, $value) {
                    return ['style' => 'margin-right: 5px; margin-left: 10px'];
                },
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['class' => 'custom-form'],
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'class' => 'custom-form'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        // Max length autorised by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Téléphone',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('postCode', TextType::class, [
                'label' => 'Code Postal',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('birthdate', BirthdayType::class, [
                'label' => 'Date de naissance',
                'attr' => ['class' => 'custom-form'],
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('bike', TextType::class, [
                'label' => 'Moto',
                'attr' => ['class' => 'custom-form'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

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

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Add plainPassword only if user is created
        if ($options['data']->getId() === null) {
            $builder->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Mot de passe',
                'attr' => ['autocomplete' => 'new-password', 'class' => 'custom-form'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
            ]);
        }
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
                'label' => 'E-mail',
                'attr' => ['class' => 'custom-form'],
                'constraints' => [
                    new NotBlank(),
                    new Email(),
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
            ])
            ->add('bike', TextType::class, [
                'label' => 'Moto',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôles',
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => true,
                'choice_attr' => function ($choice, $key, $value) {
                    return ['style' => 'margin-right: 5px; margin-left: 8px;'];
                },
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'En attente' => false,
                    'Validé' => true,
                ],
                'multiple' => false,
                'expanded' => true,
                'choice_attr' => function ($choice, $key, $value) {
                    return ['style' => 'margin-right: 5px; margin-left: 10px'];
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

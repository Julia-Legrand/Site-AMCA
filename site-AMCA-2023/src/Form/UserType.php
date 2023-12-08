<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
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
        $builder
            ->add('memberNumber', TextType::class, [
                'label' => 'Numéro adhérent',
                'attr' => ['class' => 'custom-form'],
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
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'attr' => ['class' => 'custom-form'],
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
                'format' => 'dd-MM-yyyy',
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
                'expanded' => true, // pour afficher les choix sous forme de cases à cocher
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

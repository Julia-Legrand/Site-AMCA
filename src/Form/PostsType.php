<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Posts;
use App\Entity\Themes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PostsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('postTitle', TextType::class, [
                'label' => 'Titre du post',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('themes', EntityType::class, [
                'class' => Themes::class,
                'choice_label' => function (Themes $theme) {
                    return $theme->getThemeTitle();
                },
                'attr' => ['class' => 'custom-form'],
                'label' => 'Thème relié',
            ])
            ->add('postContent', TextareaType::class, [
                'label' => 'Texte',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('postPicture', FileType::class, [
                'label' => 'Ajouter des photos',
                'attr' => ['class' => 'custom-form'],
                'multiple' => true,
                'mapped' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
}

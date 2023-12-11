<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Posts;
use App\Entity\Comments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('post', EntityType::class, [
                'class' => Posts::class,
                'choice_label' => function (Posts $post) {
                    return $post->getPostTitle();
                },
                'attr' => ['class' => 'custom-form'],
                'label' => 'Post',
            ])
            ->add('commentContent', TextareaType::class, [
                'label' => 'Texte',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('created_at', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Créé le',
                'attr' => ['class' => 'custom-form'],
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => function (User $user) {
                    return $user->getFirstName() . ' ' . $user->getLastName();
                },
                'attr' => ['class' => 'custom-form'],
                'label' => 'Auteur',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}

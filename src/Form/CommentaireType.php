<?php

namespace App\Form;

use App\Entity\Commentaire;
use App\Entity\User;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu',TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '150'
                ],
                'label' => 'Contenu',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 150])
                ]
            ])
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy HH:mm',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'jj/mm/aaaa hh:mm'
                ]
            ])
        ;
    }
    
            /*->add('description')

            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'choice_label' => 'id',
            ])
            ->add('typePlainte', EntityType::class, [
                'class' => TypePlainte::class,
                'choice_label' => 'id',
            ])
            ->add('commune', EntityType::class, [
                'class' => Commune::class,
                'choice_label' => 'id',
            ])
        ;
    }*/

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
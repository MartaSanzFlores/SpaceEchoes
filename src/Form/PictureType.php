<?php

namespace App\Form;

use App\Entity\Picture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class PictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', UrlType::class)
            ->add('description', TextareaType::class, [
            'label' => 'Description',
            'attr' => [
                'rows' => 12,
            ],])
            ->add('credit', TextType::class, [
                'label' => 'Crédit'
                ])
            ->add('altText', TextType::class, [
                'label' => 'Text alternative (alt)'
                ])
            ->add('galery', ChoiceType::class, [
                'label' => 'L\'image fait partie de la galerie?',
                'choices' => [
                    // libellé / valeur transmise
                    'Oui' => true,
                    'Non' => false,
                ],
                // choix multiple
                'multiple' => false,
                // checkboxes
                'expanded' => true,
            ])
            ->add('slug', TextType::class, [
                'label' => 'Slug'
                ])
            ->add('publishedAt', DateType::class,[ 
                'label' => 'Date de publication de l\'image',
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
                'constraints' => [
                new GreaterThanOrEqual(['value' => new \DateTimeImmutable()]),
            ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Picture::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Author;
use DateTimeImmutable;
use App\Entity\Picture;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType ;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;


class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'article',
                'attr' => [
                    // attribut HTML
                    'placeholder' => 'Par ex. L\'Andromède : Notre Voisin Galactique Gigantesque',
                ],
            ])

            ->add('excerpt', TextareaType::class, [
                'label' => 'Résumé de l\'article',
                // attributs HTML supplémentaires
                'attr' => [
                    'rows' => 6,
                ],
                // message d'aide
                'help' => '800 caractères max.',
            ])

            ->add('content', TextareaType::class, [
                'label' => 'Contenu de l\'article',
                // attributs HTML supplémentaires
                'attr' => [
                    'rows' => 12,
                ],
            ])

            ->add('slug', TextType::class, [
                'label' => 'Slug de l\'article',
                'attr' => [
                    // attribut HTML
                    'placeholder' => 'Par ex. la-galaxie-andromede',
                ],
                // message d'aide
                'help' => 'Substituez l\'espace par le tiret "-" et veuillez éviter d\'utiliser des accents.',
            ])

            ->add('author', EntityType::class, [
                'label' => 'Auteur de l\'article',
                'class' => Author::class,
                'choice_label' => 'lastName',
                // requête custom pour la liste d'entités
                // @see https://symfony.com/doc/5.4/reference/forms/types/entity.html#using-a-custom-query-for-the-entities
                // $er = EntityRepository de l'entité Author
                'query_builder' => function (EntityRepository $et) {
                    // requête comme dans le Repository
                    return $et->createQueryBuilder('a')
                        ->orderBy('a.lastName', 'ASC');
                },
            ])
            ->add('picture', EntityType::class, [
                'label' => 'Image de l\'article',
                'class' => Picture::class,
                'choice_label' => 'url',
                // requête custom pour la liste d'entités
                // $er = EntityRepository de l'entité Picture
                'query_builder' => function (EntityRepository $ep) {
                    // requête comme dans le Repository
                    return $ep->createQueryBuilder('p')
                        ->where('p.galery = 0');
                },
            ])

            ->add('categories', EntityType::class, [
                'label' => 'Catégories de l\'article',
                'class' => Category::class,
                'choice_label' => 'name', // plusieurs genres (ToMany)
                'multiple' => true,
                // choix étendu (checkboxes)
                'expanded' => true,
                // requête custom pour la liste d'entités
                // $er = EntityRepository de l'entité Category
                'query_builder' => function (EntityRepository $et) {
                    // requête comme dans le Repository
                    return $et->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
            ])

            ->add('publishedAt',DateType::class,[ 
                'label' => 'Date de publication de l\'article',
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
                'constraints' => [
                new GreaterThanOrEqual(['value' => new \DateTimeImmutable()]),
            ],
            ]
            );

            // ->add('userPost', ::class, [
            //      'data' => '5', 
            //     ]);
            //->add('userPost', HiddenType::class, [
            //     'data' => $options['id'], // Utiliser l'ID de l'utilisateur
             
            // ->add('userPost', EntityType::class, [
            //     'label'=>'Utilisateur', 
            //     'class' => User::class,
            //     'choice_label' => 'id',
            //     ])

        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}

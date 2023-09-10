<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôles',
                'choices' => [
                    // libellé / valeur transmise
                    'Manager' => 'ROLE_MANAGER',
                    'Administrateur' => 'ROLE_ADMIN'
                ],
                // choix multiple
                'multiple' => true,
                // checkboxes
                'expanded' => true,
            ])
            ->add('userName', TextType::class)


            // Ci dessous on place un écouteur d'évenement sur le formulaire
            // Des que l'evenement PRE_SET_DATA se declenche, la fonction de callback en 2eme parametre va s'executer
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                // Ici je stock toutes les données du formulaire dans $form, on recupere tout ca depuis l'event (pour travailler avec)
                $form = $event->getForm();
                // On veut récupérer l'user mappé sur le form depuis l'event
                $user = $event->getData();
                // Ici je vérifie si l'user est existant ou pas
                if ($user->getId() !== null) {
                    // Je rentre dans ce if si l'utilisateur existe
                    // Edit
                    $form->add('email', EmailType::class, [
                        'label' => 'E-mail',
                        // si la valeur de e-mail est "null" à l'edit
                        // on lui dit que c'est une chaine vide (pour que le setter soit content)
                        // et que le Validator prenne le relais
                        'empty_data' => '',
                    ])
                    ->add('roles', ChoiceType::class, [
                        'label' => 'Rôles',
                        'choices' => [
                            // libellé / valeur transmise
                            'Manager' => 'ROLE_MANAGER',
                            'Administrateur' => 'ROLE_ADMIN'
                        ],
                        // choix multiple
                        'multiple' => true,
                        // checkboxes
                        'expanded' => true,
                    ])
                    // TODO button reset password ??
                    ->add('password', null, [
                        'label' => 'Nouveau mot de passe',
                        // cette option permet que le formulaire de gère plus cette propriété de l'entité
                        // c'est juste un champ de formulaire, non lié à l'entité
                        'mapped' => false,
                    ]);
                }else{
                    $form->add('password', RepeatedType::class, [
                        // type de champ répété
                        'type' => PasswordType::class,
                        // message d'erreur
                        'invalid_message' => 'Les mots de passe ne correspondent pas.',
                        // options communes aux deux champs (ex. bidon ici)
                        'options' => ['attr' => ['class' => 'password-field']],
                        'required' => true,
                        // options pour le champ 1 (celui qui est transmis au back)
                        'first_options'  => ['label' => 'Mot de passe'],
                        // options pour le champ 2
                        'second_options' => ['label' => 'Confirmer le mot de passe'],
                    ]);
                }
                
            })



            
      
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

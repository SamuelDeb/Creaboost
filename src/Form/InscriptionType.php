<?php

namespace App\Form;

use App\Entity\Membres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Regex;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Saisir le nom' ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prenom',
                'attr' => ['placeholder' => 'Saisir le prénom' ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse E-mail',
                'attr' => ['placeholder' => 'Saisir l\'adresse email']
            ])
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo',
                'constraints' => new Regex([
                    'pattern' => '#^([a-zA-Z0-9-_]{2,36})$#',
                    'message' => "Le pseudo ne peux contenir de caractères spéciaux"
                ]),
                    'attr' => ['placeholder' => 'Saisir votre pseudo']
            ])
            ->add('categorie', ChoiceType::class, [
                'label'=>'Choisissez votre catégorie',
                'choices'=>[
                    'Collégien'=>'Collégien',
                    'Lycéen'=>'Lycéen',  
                    'Hors-scolaire'=>'Hors-scolaire'  
                ],
                'multiple'=>false,
                'expanded'=>false,
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe de confirmation ne correspond pas',
              
                'required' => true,
                'constraints' => new Length([
                    'min' => 8,
                    'max' => 255,
                    'minMessage' => 'Votre mot de passe est trop court',
                    'maxMessage' => 'Votre mot de passe est trop long.'
                ]),
                'first_options'  => ['label' => 'Mot de passe', 'attr' =>['placeholder'=>'Saisir le mot de passe']],
                'second_options' => ['label' => 'Confirmer mot de passe', 'attr' =>['placeholder'=>'Confirmer le mot de passe']],
            ])
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Valider l\'inscription'
                ]
            );
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membres::class,
        ]);
    }
}

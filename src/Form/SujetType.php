<?php

namespace App\Form;

use DateTime;
use App\Entity\Sujets;
use App\Entity\Membres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SujetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'attr' => ['placeholder' => 'Saisir un titre' ]
            ])
            ->add('categorie', ChoiceType::class, [
                'label'=>'Choisissez votre catégorie',
                'choices'=>[
                    'Collégien'=>'Collégien',
                    'Lycéen'=>'Lycéen',  
                ],
                'multiple'=>false,
                'expanded'=>false,
            ])
            ->add('contenu', TextareaType::class, [
                'attr' => [
                    'rows' => "9", 
                'cols' => "45",
                    'placeholder' => 'Saisir votre message' 
                ],
                'required' => true,
                'mapped' => false
            ])
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Valider'
                ]
            );
        
       

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sujets::class,
        ]);
    }
}

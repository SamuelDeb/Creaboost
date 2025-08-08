<?php

namespace App\Form;

use App\Entity\Membres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UpdateProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            'label' => 'Adresse E-mail',
            'attr' => ['placeholder' => 'Saisir l\'adresse email']
        ])
        ->add('avatar', FileType::class, [
            'label'=> 'Modifier votre avatar',
            'required'   => false,
            'constraints' => [
                new File([
                    'maxSize' => '5M',
                    'mimeTypes' => [
                        'image/*',
                    ],
                    'mimeTypesMessage' => 'Le fichier n\'est pas valide, assurez vous d\'avoir un fichier au format JPG, JPEG)',
                ]),
            ],
            'data_class' => null

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
        ->add('profil', TextareaType::class,[
            'label'=>'Profil',
            'attr' => ['placeholder' => 'Ajoutez des informations à votre propos']
        ]
        )
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
            'data_class' => Membres::class,
        ]);
    }
}

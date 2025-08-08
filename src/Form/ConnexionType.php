<?php

namespace App\Form;

use App\Entity\Membres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConnexionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo')
           
            ->add('password')
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('classe')
            ->add('avatar')
            ->add('grade')
            ->add('categorie')
            ->add('profil')
            ->add('meilleur_score')
            ->add('xp')
            ->add('sujets')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membres::class,
        ]);
    }
}

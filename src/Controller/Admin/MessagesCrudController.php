<?php

namespace App\Controller\Admin;

use App\Entity\Messages;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MessagesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Messages::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            IdField::new('auteur_id'),
            TextField::new('contenu'),
        ];
    }
    
}

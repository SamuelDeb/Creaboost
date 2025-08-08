<?php

namespace App\Controller\Admin;

use App\Entity\Sujets;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SujetsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sujets::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('titre'),
            TextField::new('categorie'),
        ];
    }
    
}

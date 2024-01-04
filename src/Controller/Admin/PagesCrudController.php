<?php

namespace App\Controller\Admin;

use App\Entity\Pages;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class PagesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Pages::class;
    }

   
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            SlugField::new('slug')->setTargetFieldName('title'),
            TextEditorField::new('content')->onlyOnForms(),
            DateField::new('createdAt')->hideOnForm(),
        ];
    }
   
}

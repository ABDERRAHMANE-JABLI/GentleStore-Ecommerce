<?php

namespace App\Controller\Admin;

use App\Entity\Adresse;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;

class AdresseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Adresse::class;
    }
  
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            ChoiceField::new('type')->setChoices([
                'Blilling Address'=>'Billing Address',
                'Shipping Address'=>'Shipping Address',
                'My House'=>'My House',
                'other'=>'other'
            ]),
            TextField::new('name', 'Address name'),
            CountryField::new('state')->showFlag(true),//default true
            TextField::new('city'),
            TextField::new('zip_code'),
            AssociationField::new('client'),
        ];
    }
    
}

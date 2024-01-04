<?php

namespace App\Controller\Admin;

use App\Entity\Orders;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrdersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Orders::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            ChoiceField::new('status')->setChoices([
                'Processing'=>'Processing',
                'Ready for Shipment'=>'Ready for Shipment',
                'Shipped'=>'Shipped',
                'On the Way'=>'On the Way'
            ]),
            AssociationField::new('client'),
            MoneyField::new('Total')->setCurrency('USD'),
            BooleanField::new('isPayed'),
        ];
    }
    
}

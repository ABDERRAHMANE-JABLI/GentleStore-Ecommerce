<?php

namespace App\Controller\Admin;

use App\Entity\Orders;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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
                'Incomplete'=>'Incomplete',
                'Processing'=>'Processing',
                'Ready for Shipment'=>'Ready for Shipment',
                'Shipped'=>'Shipped',
            ]),
            AssociationField::new('client'),
            MoneyField::new('Total')->setCurrency('USD'),
            BooleanField::new('isPayed'),
            TextField::new('ShippingAddr'),
            TextField::new('BillingAddr')
        ];
    }
    
}

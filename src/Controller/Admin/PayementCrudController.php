<?php

namespace App\Controller\Admin;

use App\Entity\Payement;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PayementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Payement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextField::new('description'),
            TextField::new('test_public_api_key')->hideOnIndex(),
            TextField::new('test_private_api_key')->hideOnIndex(),
            TextField::new('prod_public_api_key')->hideOnIndex(),
            TextField::new('prod_private_api_key')->hideOnIndex(),
            ImageField::new('logo')->setFormTypeOptions([
                'attr'=>['accept'=>'image/*']
            ])->setUploadDir("/public/assets/images/payements")
              ->setBasePath('/assets/images/payements')
              ->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired($pageName === Crud::PAGE_NEW),
        ];
    }
}

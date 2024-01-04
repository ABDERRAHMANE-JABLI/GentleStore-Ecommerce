<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            SlugField::new('slug')->setTargetFieldName('name'),
            TextField::new('brand'),
            TextField::new('description'),
            TextEditorField::new('more_details')->hideOnIndex(),
            TextEditorField::new('additionals_info')->hideOnIndex(),
            MoneyField::new('regular_price')->setCurrency('USD'),
            MoneyField::new('solde_price')->setCurrency('USD'),
            IntegerField::new('stock'),
            AssociationField::new('categories'),
            ImageField::new('imagesUrl')->setFormTypeOptions([
                'multiple'=>true,
                'attr'=>['accept'=>'image/*']
            ])->setUploadDir("/public/assets/images/products")
              ->setBasePath('/assets/images/products')
              ->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired($pageName === Crud::PAGE_NEW),
            BooleanField::new('isAvailable'),
            BooleanField::new('isBestSeller'),
            BooleanField::new('isNewArrival'),
            BooleanField::new('isFeatured'),
            BooleanField::new('isSpecialOffer'),
            AssociationField::new('product')
        ];
    }
    
}

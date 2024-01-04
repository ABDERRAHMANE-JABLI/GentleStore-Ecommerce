<?php

namespace App\Controller\Admin;

use App\Entity\Sliders;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SlidersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sliders::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextField::new('subTitle'),
            TextField::new('btnLink'),
            TextField::new('btnText'),
            ImageField::new('imageUrl')->setUploadDir("/public/assets/images/sliders")
                ->setBasePath('/assets/images/sliders')
                ->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired($pageName === Crud::PAGE_NEW),
        ];
    }
    
}

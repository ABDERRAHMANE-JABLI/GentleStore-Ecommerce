<?php

namespace App\Controller\Admin;

use App\Entity\Settings;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class SettingsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Settings::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('storeName'),
            TextField::new('Descrription'),
            ChoiceField::new('currency')->setChoices([
                'USD'=>'USD',
                'EUR'=>'EUR',
                'MAD'=>'MAD'
            ]),
            IntegerField::new('taxRate'),
            TextField::new('adresse'),
            TelephoneField::new('tel'),
            EmailField::new('mail'),
            ImageField::new('logo')->setFormTypeOptions([
                'attr'=>['accept'=>'image/*']
            ])->setUploadDir("/public/assets/images/settings")
              ->setBasePath('/assets/images/settings')
              ->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired($pageName === Crud::PAGE_NEW),
            UrlField::new('facebookLink')->onlyOnForms(),
            UrlField::new('instagramLink')->onlyOnForms(),
            UrlField::new('YoutubeLink')->onlyOnForms(),     
        ];
    }
    
}

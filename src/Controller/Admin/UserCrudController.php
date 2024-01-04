<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Component\Form\FormEvents;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Form\FormBuilderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    //encodeur du password : 
    
    public function __construct(
        public UserPasswordHasherInterface $userPasswordHasher
    ){/*injection de l'interface*/}

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('fullName'),
            ChoiceField::new('civility')->setChoices([
                'Mister'=>'Mr',
                'Madame'=>'Mrs',
                'Miss'=>'Miss'
            ]),
            EmailField::new('email')->setRequired($pageName === Crud::PAGE_NEW),
            TextField::new('password')->setFormType(RepeatedType::class)
            ->setFormTypeOptions([
                'type'=>PasswordType::class,
                'first_options'=>[
                    'label'=>'Password',
                    'row_attr'=>['class'=>'col-6']
                ],
                'second_options'=>[
                    'label'=>'Confirm Password',
                    'row_attr'=>['class'=>'col-6']
                ],
                'mapped'=>false,
            ])->onlyOnForms()->setRequired($pageName === Crud::PAGE_NEW) // required si on est dans la page de creation
        ];
    }
    
    //methode qui sera declenché automatiquement lorsqu'on creer un user :
    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions,$context);
        return $this->addPasswordEventListener($formBuilder);
    }

    //methode qui sera declenché automatiquement lorsqu'on modifier un user :
    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createEditFormBuilder($entityDto, $formOptions,$context);
        return $this->addPasswordEventListener($formBuilder);
    }

    public function addPasswordEventListener(FormBuilderInterface $formBuilder){
        return $formBuilder->addEventListener(FormEvents::POST_SUBMIT, $this->hashPassword());
    }

    public function hashPassword(){
        return function($event){
            $form = $event->getForm();
            if(!$form->isValid())
            {
                return;
            }
            $password = $form->get('password')->getData();
            if($password === null)
            {
                return;
            }
            $hash = $this->userPasswordHasher->hashPassword($this->getUser(), $password);
            $form->getData()->setPassword($hash);
        };
    }
}



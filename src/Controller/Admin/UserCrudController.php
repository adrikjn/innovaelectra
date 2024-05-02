<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    public function __construct(public UserPasswordHasherInterface $hasher)
    {
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email')->onlyOnIndex(),
            EmailField::new('email')->onlyWhenCreating(),
            TextField::new('password', 'Mot de passe')->setFormType(PasswordType::class)->onlyWhenCreating(),
            TextField::new('firstname', 'Prénom')->onlyOnIndex(),
            TextField::new('firstname', 'Prénom')->onlyWhenCreating(),
            TextField::new('lastname', 'Nom de famille')->onlyOnIndex(),
            TextField::new('lastname', 'Nom de famille')->onlyWhenCreating(),
            TextField::new('adress', 'Adresse')->onlyOnIndex(),
            TextField::new('adress', 'Adresse')->onlyWhenCreating(),
            TelephoneField::new('phoneNumber', 'Numéro de téléphone')->onlyOnIndex(),
            TelephoneField::new('phoneNumber', 'Numéro de téléphone')->onlyWhenCreating(),
            DateTimeField::new('createdAt')->setFormat('d/M/Y à H:m:s')->hideOnForm(), 
            DateTimeField::new('updatedAt')->setFormat('d/M/Y à H:m:s')->hideOnForm(), 
            CollectionField::new('roles')->setTemplatePath('admin/field/roles.html.twig')->onlyWhenUpdating(),
            CollectionField::new('roles')->setTemplatePath('admin/field/roles.html.twig')->onlyOnIndex(),
        ];
    }
    

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance->getId()) {
            $entityInstance->setPassword(
                $this->hasher->hashPassword(
                    $entityInstance,
                    $entityInstance->getPassword()
                )
            );
        }
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    public function createEntity(string $entityFqcn)
    {
        $produit = new $entityFqcn;
        $produit->setCreatedAt(new \DateTimeImmutable());
        $produit->setUpdatedAt(new \DateTimeImmutable());
        return $produit;
    }
}

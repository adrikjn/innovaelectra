<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoriesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categories::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Nom')->onlyOnIndex(),
            TextField::new('title', 'Nom')->onlyWhenCreating(),
            AssociationField::new('products')->onlyWhenUpdating(),
            AssociationField::new('products')->onlyOnIndex(),
            TextEditorField::new('description'),
            ImageField::new('image')->setUploadDir('assets/img/categories/')->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')->onlyWhenCreating(),
            ImageField::new('image')->setUploadDir('assets/img/categories/')->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')->onlyWhenUpdating()->setFormTypeOptions([
                'required' => false,
            ]),
            ImageField::new('image')->setBasePath('img/categories/')->hideOnForm(),
            TextEditorField::new('description'),
        ];
    }
    


    public function createEntity(string $entityFqcn)
    {
        $produit = new $entityFqcn;
        $produit->setCreatedAt(new \DateTimeImmutable());
        $produit->setUpdatedAt(new \DateTimeImmutable());
        return $produit;
    }
}

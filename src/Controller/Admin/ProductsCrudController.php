<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class ProductsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Products::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Nom'),
            AssociationField::new('category', 'Catégorie'),
            ImageField::new('image')->setUploadDir('assets/img/products/')->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')->onlyWhenCreating(),
            ImageField::new('image')->setUploadDir('assets/img/products/')->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')->onlyWhenUpdating()->setFormTypeOptions([
                'required' => false,
            ]),
            ImageField::new('image')->setBasePath('img/products/')->hideOnForm(),
            TextEditorField::new('description'),
            MoneyField::new('price', 'Prix')->setCurrency('EUR'),
            IntegerField::new('quantity', 'Quantité'),
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

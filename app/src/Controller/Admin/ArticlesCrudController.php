<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticlesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Articles::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title')->setLabel('Titre'),
            // TextEditorField::new('content'),
            TextEditorField::new('content')->setLabel('Contenu'),
            DateTimeField::new('createdAt')->onlyOnIndex()->setFormat('dd/MM/yyyy')->setLabel('Date de création'),
            ImageField::new('image')->setBasePath('/uploads/')->setUploadDir('/public/uploads/')->setLabel('Image'),
        ];
    }

    public function configureCrud(Crud $crud) : Crud {
        return $crud
            ->setEntityLabelInSingular('article')
            ->setEntityLabelInPlural('articles')
        ;
    }
}

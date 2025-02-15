<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id')->onlyOnIndex(),
            TextField::new('title', 'Titres')->setColumns('col-md-6'),
            TextField::new('marque', 'Marque')->setColumns('col-md-3'),
            TextField::new('modele', 'Modèle')->setColumns('col-md-3'),
            MoneyField::new('prix', 'Prix')
                ->setCurrency('EUR')
                 ->setStoredAsCents(false) // Ajoute cette ligne pour éviter la conversion en centimes
                ->setColumns('col-md-3'),
            TextField::new('finition', 'Finition')->setColumns('col-md-3'),
            TextField::new('carrosserie', 'Carrosserie')->setColumns('col-md-3'),
            DateField::new('miseEnCirculation', 'Mise en circulation')
                ->setFormat('dd/MM/yyyy') // Format correct pour l'affichage
                ->setColumns('col-md-3'),
            IntegerField::new('kilometres', 'Kilométrage')->setColumns('col-md-3'),
            TextField::new('energie', 'Énergie')->setColumns('col-md-3'),
            TextField::new('typeDeBoite', 'Type de boîte')->setColumns('col-md-3'),
            IntegerField::new('puissance', 'Puissance (ch)')->setColumns('col-md-3'),
            IntegerField::new('places', 'Nombre de places')->setColumns('col-md-3'),
            // Équipements en JSON
            ArrayField::new('equipement', 'Équipements')
                ->setColumns('col-md-6'),
            TextField::new('classeCo2', 'Classe CO2')->setColumns('col-md-3'),
            TextField::new('consommation', 'Consommation (L/100km)')->setColumns('col-md-3'),
            DateField::new('createdAt', 'Date de création')->onlyOnIndex(),
            $image = ImageField::new('image')
                ->setUploadDir('public/divers/images')
                ->setBasePath('divers/images')
                ->setFormTypeOption('required', false)
                ->setColumns('col-md-2'),
            $image2 = ImageField::new('image2')
                ->setUploadDir('public/divers/images')
                ->setBasePath('divers/images')
                ->setSortable(false)
                ->setFormTypeOption('required', false)
                ->setColumns('col-md-2'),
            $image3 = ImageField::new('image3')
                ->setUploadDir('public/divers/images')
                ->setBasePath('divers/images')
                ->setSortable(false)
                ->setFormTypeOption('required', false)
                ->setColumns('col-md-2'),
            $image4 = ImageField::new('image4')
                ->setUploadDir('public/divers/images')
                ->setBasePath('divers/images')
                ->setSortable(false)
                ->setFormTypeOption('required', false)
                ->setColumns('col-md-2'),
            $image5 = ImageField::new('image5')
                ->setUploadDir('public/divers/images')
                ->setBasePath('divers/images')
                ->setSortable(false)
                ->setFormTypeOption('required', false)
                ->setColumns('col-md-2'),
            AssociationField::new('user', 'Utilisateurs')->setColumns('col-md-4'),
            DateField::new('createdAt', 'Date de création')->onlyOnIndex(),
            BooleanField::new('isPublished')
                ->setColumns('col-md-1')
                ->setLabel('Publié'),
        ];
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('un article')
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->setPaginatorPageSize(5);
    }
    // Configurer les filtres 
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('user')
            ->add('title')
            ->add('createdAt');
    }
    // Mise en place des actions possibles selon le rôle
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setLabel('Modifier') // Vous pouvez personnaliser le libellé
                    ->setIcon('fa fa-edit') // Ajouter une icône si nécessaire
                    ->addCssClass('btn btn-primary'); // Ajouter des classes CSS
            })
            ->setPermission(Action::DELETE, 'ROLE_SUPER_ADMIN'); // Conserver les permissions spécifiques pour DELETE
    }
}

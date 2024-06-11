<?php

namespace App\Controller\Admin;

use App\Entity\Account;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class AccountCrudController extends AbstractCrudController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return Account::class;
    }

    
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // ...
            // this will forbid to create or delete entities in the backend
            // ->disable(Action::NEW, Action::DELETE)
        ;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('firstname'),
            TextField::new('lastname'),
            TextField::new('email'),
            TextField::new('phone'),
            TextField::new('nidno'),
            TextField::new('ranking'),
            TextField::new('shareno'),
            Field::new('totalDepositAmount', 'Total Amount')->onlyOnIndex(),
            ImageField::new('photos')->setUploadedFileNamePattern('[year]-[month]-[day]-[uuid]-[contenthash].[extension]')->setBasePath('uploads/images/users')->setUploadDir('public/uploads/images/users'),
        ];
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $alias = $qb->getRootAliases()[0]; // Alias for the main entity

        // Add the subquery to calculate total deposits
        // $qb->addSelect('(SELECT SUM(d.amount) FROM App\Entity\Deposit d WHERE d.account = ' . $alias . '.id) AS totalDeposits');

        return $qb;
    }
    
}

<?php

namespace App\Controller\Admin;

use App\Entity\Administrator;
use App\Form\Type\AdministratorType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdministratorCrudController extends AbstractCrudController
{
    public function __construct(
        public UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Administrator::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setPageTitle('edit', 'Edit')
        ->setEntityLabelInSingular('Administrator')
        ->setEntityLabelInPlural('Administrators');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id', 'ID')->onlyOnIndex(),
            EmailField::new('email', 'Email'),
            TextField::new('name', 'Name'),
            BooleanField::new('isVerified', 'Is Verified'),
            TextField::new('plainPassword', 'Password')->onlyOnForms(),
            DateTimeField::new('createdAt', 'Created At')->hideOnForm(),
            DateTimeField::new('updatedAt', 'Updated At')->hideOnForm(),
            DateTimeField::new('deletedAt', 'Deleted At')->hideOnForm()
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Administrator) {
            if ($plainPassword = $entityInstance->getPlainPassword()) {
                $entityInstance->setPassword(
                    $this->userPasswordHasher->hashPassword(
                        $entityInstance,
                        $plainPassword
                    )
                );
            }
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Administrator) {
            if ($plainPassword = $entityInstance->getPlainPassword()) {
                $entityInstance->setPassword(
                    $this->userPasswordHasher->hashPassword(
                        $entityInstance,
                        $plainPassword
                    )
                );
            }
        }

        parent::updateEntity($entityManager, $entityInstance);
    }
}

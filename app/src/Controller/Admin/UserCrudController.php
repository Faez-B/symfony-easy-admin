<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{    
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {

    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        
        yield IdField::new('id')->onlyOnIndex();
        yield EmailField::new('email');
        yield TextField::new('password')->onlyWhenCreating();
        yield ChoiceField::new('roles')->setChoices([
            'User' => 'ROLE_USER',
            'Guest' => 'ROLE_GUEST',
            'Admin' => 'ROLE_ADMIN',
            'Super Admin' => 'ROLE_SUPER_ADMIN',
        ])
        ->allowMultipleChoices()
        ->renderAsBadges()
        ->renderExpanded()
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityPermission('ROLE_SUPER_ADMIN')
        ;
    }

    public function persistEntity(EntityManagerInterface $em, $entity): void
    {
        if (!$entity instanceof User) {
            throw new \InvalidArgumentException(sprintf('Expected an instance of %s, got %s', User::class, get_class($entity)));
        }

        $entity->setPassword(
            $this->passwordHasher->hashPassword(
                $entity,
                $entity->getPassword()
            )
        );
        $em->persist($entity);
        $em->flush();
    }
}

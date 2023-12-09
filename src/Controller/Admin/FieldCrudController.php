<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Field;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class FieldCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Field::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort([
                'id' => 'DESC',
            ])
            ->setEntityLabelInSingular('Field')
            ->setEntityLabelInPlural('Fields')
            ->setSearchFields([
                'name',
            ])
            ->setPaginatorPageSize(30);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield TextField::new('condition');
    }
}

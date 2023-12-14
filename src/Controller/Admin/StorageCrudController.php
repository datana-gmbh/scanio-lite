<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Storage;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class StorageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Storage::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort([
                'id' => 'DESC',
            ])
            ->setEntityLabelInSingular('Speicher')
            ->setEntityLabelInPlural('Speicher')
            ->setPaginatorPageSize(100);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('id')
            ->hideOnIndex()
            ->setFormTypeOption('disabled', true);

        yield ChoiceField::new('storageType', 'Type');

        yield TextField::new('path');

        yield TextField::new('token')
            ->hideOnIndex();

        yield BooleanField::new('enabled');

        yield BooleanField::new('recursive')
            ->setHelp('Sollen Dateien ebenfalls aus Unterordnern importiert werden?');
    }
}

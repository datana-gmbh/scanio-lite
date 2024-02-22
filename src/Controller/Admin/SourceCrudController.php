<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Source;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class SourceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Source::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort([
                'id' => 'DESC',
            ])
            ->setEntityLabelInSingular('Quelle')
            ->setEntityLabelInPlural('Quellen')
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

        yield ChoiceField::new('type');

        yield TextField::new('path');

        yield TextField::new('token')
            ->hideOnIndex();

        yield BooleanField::new('enabled');

        yield BooleanField::new('recursiveImport')
            ->setHelp('Sollen Dateien ebenfalls aus Unterordnern importiert werden?');

        yield BooleanField::new('deleteAfterImport')
            ->setHelp('Sollen Dateien nach einem erfolgreichen Import gelöscht werden?');
    }
}

<?php

declare(strict_types=1);

namespace App\Crud\Edit\Form\Types\Default;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BaseForm extends AbstractType
{
    public function getParent(): string
    {
        return \App\Form\BaseForm::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }
}

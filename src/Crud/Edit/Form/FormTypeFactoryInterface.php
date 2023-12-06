<?php

declare(strict_types=1);

namespace App\Crud\Edit\Form;

use App\Domain\Enum\Category;
use App\Domain\Enum\Group;
use Symfony\Component\Form\FormTypeInterface;

interface FormTypeFactoryInterface
{
    public function create(Group $group, Category $category): FormTypeInterface;
}

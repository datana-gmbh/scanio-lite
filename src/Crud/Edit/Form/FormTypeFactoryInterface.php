<?php

declare(strict_types=1);

namespace App\Crud\Edit\Form;

use App\Domain\Enum\Group;
use App\Domain\Enum\Type;
use Symfony\Component\Form\FormTypeInterface;

interface FormTypeFactoryInterface
{
    public function create(Group $group, Type $type): FormTypeInterface;
}

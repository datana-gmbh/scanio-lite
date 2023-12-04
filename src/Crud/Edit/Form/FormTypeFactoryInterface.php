<?php

declare(strict_types=1);

namespace App\Crud\Edit\Form;

use App\Domain\Enum\Type;
use App\Domain\Enum\Venture;
use Symfony\Component\Form\FormTypeInterface;

interface FormTypeFactoryInterface
{
    public function create(Venture $venture, Type $type): FormTypeInterface;
}

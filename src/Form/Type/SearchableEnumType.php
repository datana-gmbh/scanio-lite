<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

final class SearchableEnumType extends AbstractType
{
    public function getParent(): string
    {
        return EnumType::class;
    }
}

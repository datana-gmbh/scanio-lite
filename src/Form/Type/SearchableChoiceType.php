<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

final class SearchableChoiceType extends AbstractType
{
    public function getParent(): string
    {
        return ChoiceType::class;
    }
}

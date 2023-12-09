<?php

declare(strict_types=1);

namespace App\Condition;

interface ConditionProviderInterface
{
    public function getCondition(string $fieldName): string;
}

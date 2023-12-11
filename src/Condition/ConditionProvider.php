<?php

declare(strict_types=1);

namespace App\Condition;

use App\Repository\FieldRepositoryInterface;

final class ConditionProvider implements ConditionProviderInterface
{
    /**
     * @var array<string, string>
     */
    private array $conditions = [];

    public function __construct(
        private readonly FieldRepositoryInterface $fields,
    ) {
    }

    public function getCondition(string $fieldName): string
    {
        $field = $this->fields->findOneBy([
            'name' => $fieldName,
        ]);

        if (null === $field
            || $field->getCondition() === null
        ) {
            return 'true';
        }

        return $field->getCondition();
    }
}

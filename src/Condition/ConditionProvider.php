<?php

declare(strict_types=1);

namespace App\Condition;

use App\Entity\Field;
use App\Repository\FieldRepositoryInterface;
use App\Routing\AdminRoutes;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ConditionProvider implements ConditionProviderInterface
{
    /** @var array<string, string> */
    private array $conditions = [];

    public function __construct(
        private readonly FieldRepositoryInterface $fields
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

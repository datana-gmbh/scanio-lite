<?php

declare(strict_types=1);

namespace App\Condition;

use App\Entity\Field;
use App\Routing\AdminRoutes;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

interface ConditionProviderInterface
{
    public function getCondition(string $fieldName): string;
}


<?php

declare(strict_types=1);

namespace App\Tree\Node;

use App\Routing\Routes;
use App\Tree\Domain\Value\Node;

final class DashboardNodeBuilder extends AbstractNodeBuilder
{
    public static function priority(): int
    {
        return -100;
    }

    protected function configure(Node $node): Node
    {
        return $node
            ->icon('fa-light fa-house')
            ->route(Routes::DASHBOARD);
    }

    protected static function name(): string
    {
        return Routes::DASHBOARD;
    }

    protected static function label(): string
    {
        return 'Dashboard';
    }
}

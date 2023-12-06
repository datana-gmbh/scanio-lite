<?php

declare(strict_types=1);

namespace App\Tree\Node;

use App\Domain\Enum\Category;
use App\Domain\Enum\Group;
use App\Tree\Domain\Value\Node;

final class DefaultGroupNodeBuilder extends AbstractNodeBuilder
{
    public function __construct(
        private readonly CategoryNodeFactory $categoryNodeFactory,
    ) {
    }

    public static function priority(): int
    {
        return -300;
    }

    protected function configure(Node $node): Node
    {
        $group = Group::Default;

        foreach ([
            Category::Pending,
            Category::Other,
            Category::Unknown,
        ] as $category) {
            $node->addChild(
                $this->categoryNodeFactory->create($group, $category),
            );
        }

        return $node
            ->showCountIf(static fn () => false);
    }

    protected static function name(): string
    {
        return 'default';
    }

    protected static function label(): string
    {
        return 'Standard';
    }
}

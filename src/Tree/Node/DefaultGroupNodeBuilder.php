<?php

declare(strict_types=1);

namespace App\Tree\Node;

use App\Domain\Enum\Group;
use App\Domain\Enum\Type;
use App\Tree\Domain\Value\Node;

final class DefaultGroupNodeBuilder extends AbstractNodeBuilder
{
    public function __construct(
        private readonly TypeNodeFactory $typeNodeFactory,
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
            Type::Pending,
            Type::Other,
            Type::Unknown,
        ] as $type) {
            $node->addChild(
                $this->typeNodeFactory->create($group, $type),
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

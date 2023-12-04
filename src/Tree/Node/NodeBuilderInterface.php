<?php

declare(strict_types=1);

namespace App\Tree\Node;

use App\Tree\Domain\Value\Node;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(self::class)]
interface NodeBuilderInterface
{
    public function build(): Node;

    public static function priority(): int;
}

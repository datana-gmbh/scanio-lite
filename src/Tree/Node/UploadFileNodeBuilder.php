<?php

declare(strict_types=1);

namespace App\Tree\Node;

use App\Routing\Routes;
use App\Tree\Domain\Value\Node;

final class UploadFileNodeBuilder extends AbstractNodeBuilder
{
    public static function priority(): int
    {
        return -200;
    }

    protected function configure(Node $node): Node
    {
        return $node
            ->icon('fa-light fa-upload')
            ->route(Routes::UPLOAD);
    }

    protected static function name(): string
    {
        return Routes::UPLOAD;
    }

    protected static function label(): string
    {
        return 'Upload';
    }
}

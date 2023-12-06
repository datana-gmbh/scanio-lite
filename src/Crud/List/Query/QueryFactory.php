<?php

declare(strict_types=1);

namespace App\Crud\List\Query;

use App\Crud\List\Query\Letter\DefaultLetterQuery;
use App\Domain\Enum\Type;
use App\Domain\Enum\Venture;
use App\Repository\LetterRepositoryInterface;

final readonly class QueryFactory implements QueryFactoryInterface
{
    public function __construct(
        private LetterRepositoryInterface $letters,
    ) {
    }

    public function create(Venture $venture, Type $type): QueryInterface
    {
        return new DefaultLetterQuery($this->letters, $type);
    }
}

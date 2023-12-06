<?php

declare(strict_types=1);

namespace App\Crud\List\Query\Letter;

use App\Crud\Domain\Enum\FieldType;
use App\Crud\Domain\Value\Field;
use App\Crud\Domain\Value\Pagination;
use App\Crud\List\ListResult;
use App\Crud\List\Query\QueryInterface;
use App\Domain\Enum\Type;
use App\Repository\LetterRepositoryInterface;
use Doctrine\ORM\QueryBuilder;

final readonly class DefaultLetterQuery implements QueryInterface
{
    private QueryBuilder $qb;

    public function __construct(
        private LetterRepositoryInterface $repository,
        private Type $type,
    ) {
        $qb = $this->repository->createQueryBuilder('l');
        $qb->where(
            $qb->expr()->eq('l.status', ':status'),
        );
        $qb->setParameter('status', $this->type->status());

        $this->qb = $qb;
    }

    public function count(): int
    {
        $qb = clone $this->qb;
        $qb->select('count(l.id)');

        /** @var int */
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function execute(Pagination $pagination, array $sortings): ListResult
    {
        $qb = clone $this->qb;

        foreach ($sortings as $sorting) {
            $qb->addOrderBy(sprintf('l.%s', $sorting->property), $sorting->direction->value);
        }

        $qb
            ->setMaxResults($pagination->limit)
            ->setFirstResult($pagination->offset);

        return new ListResult(
            [
                (new Field(FieldType::ID, 'ID', 'id'))->sortable(),
                (new Field(FieldType::DATETIME, 'Erstellungsdatum', 'createdAt'))->sortable(),
                new Field(FieldType::TEXT, 'Benutzer', 'user'),
            ],
            $qb->getQuery()->getResult(),
        );
    }
}

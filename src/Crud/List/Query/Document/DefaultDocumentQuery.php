<?php

declare(strict_types=1);

namespace App\Crud\List\Query\Document;

use App\Crud\Domain\Enum\FieldType;
use App\Crud\Domain\Value\Field;
use App\Crud\Domain\Value\Pagination;
use App\Crud\List\ListResult;
use App\Crud\List\Query\QueryInterface;
use App\Domain\Enum\Category;
use App\Repository\DocumentRepositoryInterface;
use Doctrine\ORM\QueryBuilder;

final readonly class DefaultDocumentQuery implements QueryInterface
{
    private QueryBuilder $qb;

    public function __construct(
        private DocumentRepositoryInterface $repository,
        private Category $category,
    ) {
        $qb = $this->repository->createQueryBuilder('d');
        $qb->where(
            $qb->expr()->eq('d.category', ':category'),
        );
        $qb->andWhere(
            $qb->expr()->isNull('d.finishedAt'),
        );
        $qb->setParameter('category', $this->category->value);

        $this->qb = $qb;
    }

    public function count(): int
    {
        $qb = clone $this->qb;
        $qb->select('count(d.id)');

        /** @var int */
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function execute(Pagination $pagination, array $sortings): ListResult
    {
        $qb = clone $this->qb;

        foreach ($sortings as $sorting) {
            $qb->addOrderBy(sprintf('d.%s', $sorting->property), $sorting->direction->value);
        }

        $qb
            ->setMaxResults($pagination->limit)
            ->setFirstResult($pagination->offset);

        return new ListResult(
            [
                (new Field(FieldType::TEXT, 'Dateiname', 'originalFilename'))->sortable(),
                (new Field(FieldType::TEXT, 'Quelle', 'source'))->sortable(),
                (new Field(FieldType::DATETIME, 'Erstellungsdatum', 'createdAt'))->sortable(),
                new Field(FieldType::TEXT, 'Benutzer', 'user'),
            ],
            $qb->getQuery()->getResult(),
        );
    }
}

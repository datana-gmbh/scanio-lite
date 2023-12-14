<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Identifier\SourceId;
use App\Entity\Source;
use App\Exception\SourceNotFound;
use App\Source\Value\Type;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\ORM\QueryBuilder;

/**
 * @method null|Source  find($id, $lockMode = null, $lockVersion = null)
 * @method null|Source  findOneBy(array $criteria, array $orderBy = null)
 * @method Source[]     findAll()
 * @method Source[]     findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method QueryBuilder createQueryBuilder($alias, $indexBy = null)
 */
interface SourceRepositoryInterface
{
    /**
     * @throws SourceNotFound
     */
    public function get(SourceId $id): Source;

    /**
     * @return Source[]
     */
    public function byType(Type $type): array;

    /**
     * @return Source[]
     */
    public function findEnabled(): array;

    /**
     * @throws ORMException
     * @throws ORMInvalidArgumentException
     * @throws UniqueConstraintViolationException
     */
    public function save(Source $source): void;

    /**
     * @throws ORMException
     * @throws ORMInvalidArgumentException
     */
    public function delete(Source $source): void;
}

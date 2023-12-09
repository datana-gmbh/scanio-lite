<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Identifier\FieldId;
use App\Entity\Field;
use App\Exception\FieldNotFound;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\ORM\QueryBuilder;

/**
 * @method null|Field   find($id, $lockMode = null, $lockVersion = null)
 * @method null|Field   findOneBy(array $criteria, array $orderBy = null)
 * @method Field[]      findAll()
 * @method Field[]      findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method QueryBuilder createQueryBuilder($alias, $indexBy = null)
 */
interface FieldRepositoryInterface
{
    /**
     * @throws FieldNotFound
     */
    public function get(FieldId $id): Field;

    /**
     * @throws ORMException
     * @throws ORMInvalidArgumentException
     * @throws UniqueConstraintViolationException
     */
    public function save(Field $field): void;

    /**
     * @throws ORMException
     * @throws ORMInvalidArgumentException
     */
    public function delete(Field $field): void;
}

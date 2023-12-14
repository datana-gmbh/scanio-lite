<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Identifier\StorageId;
use App\Entity\Storage;
use App\Exception\StorageNotFound;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\ORM\QueryBuilder;

/**
 * @method null|Storage find($id, $lockMode = null, $lockVersion = null)
 * @method null|Storage findOneBy(array $criteria, array $orderBy = null)
 * @method Storage[]    findAll()
 * @method Storage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method QueryBuilder createQueryBuilder($alias, $indexBy = null)
 */
interface StorageRepositoryInterface
{
    /**
     * @throws StorageNotFound
     */
    public function get(StorageId $id): Storage;

    /**
     * @throws ORMException
     * @throws ORMInvalidArgumentException
     * @throws UniqueConstraintViolationException
     */
    public function save(Storage $storage): void;

    /**
     * @throws ORMException
     * @throws ORMInvalidArgumentException
     */
    public function delete(Storage $storage): void;
}

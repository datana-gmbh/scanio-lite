<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Identifier\LetterId;
use App\Entity\Letter;
use App\Exception\LetterNotFound;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\ORM\QueryBuilder;

/**
 * @method null|Letter  find($id, $lockMode = null, $lockVersion = null)
 * @method null|Letter  findOneBy(array $criteria, array $orderBy = null)
 * @method Letter[]     findAll()
 * @method Letter[]     findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method QueryBuilder createQueryBuilder($alias, $indexBy = null)
 */
interface LetterRepositoryInterface
{
    /**
     * @throws LetterNotFound
     */
    public function get(LetterId $id): Letter;

    /**
     * @throws ORMException
     * @throws ORMInvalidArgumentException
     * @throws UniqueConstraintViolationException
     */
    public function save(Letter $letter): void;

    /**
     * @throws ORMException
     * @throws ORMInvalidArgumentException
     */
    public function delete(Letter $letter): void;
}

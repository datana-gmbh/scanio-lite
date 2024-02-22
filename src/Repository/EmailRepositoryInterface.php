<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Identifier\EmailId;
use App\Entity\Email;
use App\Exception\EmailNotFound;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\ORM\QueryBuilder;

/**
 * @method null|Email   find($id, $lockMode = null, $lockVersion = null)
 * @method null|Email   findOneBy(array $criteria, array $orderBy = null)
 * @method Email[]      findAll()
 * @method Email[]      findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method QueryBuilder createQueryBuilder($alias, $indexBy = null)
 */
interface EmailRepositoryInterface
{
    /**
     * @throws EmailNotFound
     */
    public function get(EmailId $id): Email;

    /**
     * @throws ORMException
     * @throws ORMInvalidArgumentException
     * @throws UniqueConstraintViolationException
     */
    public function save(Email $source): void;

    /**
     * @throws ORMException
     * @throws ORMInvalidArgumentException
     */
    public function delete(Email $source): void;
}

<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Identifier\DocumentId;
use App\Entity\Document;
use App\Exception\DocumentNotFound;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\ORM\QueryBuilder;

/**
 * @method null|Document find($id, $lockMode = null, $lockVersion = null)
 * @method null|Document findOneBy(array $criteria, array $orderBy = null)
 * @method Document[]    findAll()
 * @method Document[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method QueryBuilder  createQueryBuilder($alias, $indexBy = null)
 */
interface DocumentRepositoryInterface
{
    /**
     * @throws DocumentNotFound
     */
    public function get(DocumentId $id): Document;

    /**
     * @throws ORMException
     * @throws ORMInvalidArgumentException
     * @throws UniqueConstraintViolationException
     */
    public function save(Document $document): void;

    /**
     * @throws ORMException
     * @throws ORMInvalidArgumentException
     */
    public function delete(Document $document): void;
}

<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Identifier\DocumentId;
use App\Entity\Document;
use App\Exception\DocumentNotFound;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @phpstan-extends ServiceEntityRepository<Document>
 */
final class DocumentRepository extends ServiceEntityRepository implements DocumentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }

    public function get(DocumentId $id): Document
    {
        /** @var null|Document $document */
        $document = $this->find($id);

        if (null === $document) {
            throw DocumentNotFound::withId($id);
        }

        return $document;
    }

    public function save(Document $document): void
    {
        $this->_em->persist($document);
        $this->_em->flush();
    }

    public function delete(Document $document): void
    {
        $this->_em->remove($document);
        $this->_em->flush();
    }
}

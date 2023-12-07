<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Identifier\DocumentId;
use App\Entity\Document;
use App\Exception\LetterNotFound;
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
        /** @var null|Document $letter */
        $letter = $this->find($id);

        if (null === $letter) {
            throw LetterNotFound::withId($id);
        }

        return $letter;
    }

    public function save(Document $letter): void
    {
        $this->_em->persist($letter);
        $this->_em->flush();
    }

    public function delete(Document $letter): void
    {
        $this->_em->remove($letter);
        $this->_em->flush();
    }
}

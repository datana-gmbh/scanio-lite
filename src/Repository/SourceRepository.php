<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Identifier\SourceId;
use App\Entity\Source;
use App\Exception\StorageNotFound;
use App\Source\Value\Type;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @phpstan-extends ServiceEntityRepository<Source>
 */
final class SourceRepository extends ServiceEntityRepository implements SourceRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Source::class);
    }

    public function get(SourceId $id): Source
    {
        /** @var null|Source $storage */
        $storage = $this->find($id);

        if (null === $storage) {
            throw StorageNotFound::withId($id);
        }

        return $storage;
    }

    public function byType(Type $type): array
    {
        return $this->findBy(['type' => $type]);
    }

    public function save(Source $source): void
    {
        $this->_em->persist($source);
        $this->_em->flush();
    }

    public function delete(Source $source): void
    {
        $this->_em->remove($source);
        $this->_em->flush();
    }
}

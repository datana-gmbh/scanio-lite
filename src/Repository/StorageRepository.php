<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Identifier\StorageId;
use App\Entity\Storage;
use App\Exception\StorageNotFound;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @phpstan-extends ServiceEntityRepository<Storage>
 */
final class StorageRepository extends ServiceEntityRepository implements StorageRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Storage::class);
    }

    public function get(StorageId $id): Storage
    {
        /** @var null|Storage $storage */
        $storage = $this->find($id);

        if (null === $storage) {
            throw StorageNotFound::withId($id);
        }

        return $storage;
    }

    public function save(Storage $storage): void
    {
        $this->_em->persist($storage);
        $this->_em->flush();
    }

    public function delete(Storage $storage): void
    {
        $this->_em->remove($storage);
        $this->_em->flush();
    }
}

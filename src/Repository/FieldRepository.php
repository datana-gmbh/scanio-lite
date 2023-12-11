<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Identifier\FieldId;
use App\Entity\Field;
use App\Exception\FieldNotFound;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @phpstan-extends ServiceEntityRepository<Field>
 */
final class FieldRepository extends ServiceEntityRepository implements FieldRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Field::class);
    }

    public function get(FieldId $id): Field
    {
        /** @var null|Field $field */
        $field = $this->find($id);

        if (null === $field) {
            throw FieldNotFound::withId($id);
        }

        return $field;
    }

    public function save(Field $field): void
    {
        $this->_em->persist($field);
        $this->_em->flush();
    }

    public function delete(Field $field): void
    {
        $this->_em->remove($field);
        $this->_em->flush();
    }
}

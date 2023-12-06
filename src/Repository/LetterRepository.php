<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Identifier\LetterId;
use App\Entity\Letter;
use App\Exception\LetterNotFound;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @phpstan-extends ServiceEntityRepository<Letter>
 */
final class LetterRepository extends ServiceEntityRepository implements LetterRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Letter::class);
    }

    public function get(LetterId $id): Letter
    {
        /** @var null|Letter $letter */
        $letter = $this->find($id);

        if (null === $letter) {
            throw LetterNotFound::withId($id);
        }

        return $letter;
    }

    public function save(Letter $letter): void
    {
        $this->_em->persist($letter);
        $this->_em->flush();
    }

    public function delete(Letter $letter): void
    {
        $this->_em->remove($letter);
        $this->_em->flush();
    }
}

<?php

declare(strict_types=1);

namespace App\Repository;

use App\Domain\Identifier\EmailId;
use App\Entity\Email;
use App\Exception\EmailNotFound;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @phpstan-extends ServiceEntityRepository<Email>
 */
final class EmailRepository extends ServiceEntityRepository implements EmailRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Email::class);
    }

    public function get(EmailId $id): Email
    {
        /** @var null|Email $storage */
        $storage = $this->find($id);

        if (null === $storage) {
            throw EmailNotFound::withId($id);
        }

        return $storage;
    }

    public function save(Email $source): void
    {
        $this->_em->persist($source);
        $this->_em->flush();
    }

    public function delete(Email $source): void
    {
        $this->_em->remove($source);
        $this->_em->flush();
    }
}

<?php

declare(strict_types=1);

namespace App\Entity;

use App\Bridge\Doctrine\DBAL\Types\Type\Identifier\EmailIdType;
use App\Domain\Identifier\EmailId;
use App\Repository\EmailRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Safe\DateTimeImmutable;

#[ORM\Entity(repositoryClass: EmailRepository::class)]
#[ORM\Table(name: 'emails')]
class Email
{
    #[Id]
    #[Column(type: EmailIdType::class, unique: true)]
    private EmailId $id;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    public function __construct(
        #[ORM\Column(type: Types::STRING)]
        private string $from,
        #[ORM\Column(type: Types::STRING)]
        private string $to,
        #[ORM\Column(type: Types::STRING)]
        private string $subject,
        #[ORM\Column(type: Types::TEXT)]
        private string $body,
    ) {
        $this->id = new EmailId();
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): EmailId
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}

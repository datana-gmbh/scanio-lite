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

#[ORM\Entity(repositoryClass: EmailRepository::class)]
#[ORM\Table(name: 'emails')]
class Email
{
    #[Id]
    #[Column(type: EmailIdType::class, unique: true)]
    private EmailId $id;

    public function __construct(
        #[ORM\Column(type: Types::STRING)]
        private string $from,
        #[ORM\Column(type: Types::STRING)]
        private string $to,
        #[ORM\Column(type: Types::STRING)]
        private string $subject,
        #[ORM\Column(type: Types::TEXT)]
        private string $body,
        /**
         * The date and time the physical email was created.
         */
        #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
        private \DateTimeImmutable $createdAt,
        /**
         * The message ID of the email.
         */
        #[ORM\Column(type: Types::STRING, nullable: true)]
        private ?string $messageId = null,
        /**
         * The source of the email, e.g. the name of the mailbox it was received in.
         */
        #[ORM\Column(type: Types::STRING, nullable: true)]
        private ?string $source = null,
    ) {
        $this->id = new EmailId();
    }

    public function getId(): EmailId
    {
        return $this->id;
    }

    public function getMessageId(): ?string
    {
        return $this->messageId;
    }

    public function setMessageId(?string $messageId): void
    {
        $this->messageId = $messageId;
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

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): void
    {
        $this->source = $source;
    }
}

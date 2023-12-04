<?php

declare(strict_types=1);

namespace App\Entity;

use App\Bridge\Doctrine\DBAL\Types\Type\Identifier\LetterIdType;
use App\Domain\Enum\Type;
use App\Domain\Identifier\LetterId;
use App\Repository\LetterRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;

/**
 * @todo Rename all Letter stuff to Document
 */
#[ORM\Entity(repositoryClass: LetterRepository::class)]
#[ORM\Table(name: 'letters')]
#[ORM\Index(name: 'letter_status', columns: ['status'])]
#[ORM\Index(name: 'letter_type', columns: ['type'])]
#[ORM\Index(name: 'letter_filepath', columns: ['filepath'])]
class Letter implements \Stringable
{
    #[Id]
    #[Column(type: LetterIdType::class, unique: true)]
    private LetterId $id;

    #[ORM\Column(type: Types::TEXT)]
    private string $content;

    #[ORM\Column(type: Types::STRING, enumType: Type::class)]
    private Type $type = Type::UNBEARBEITET;

    /**
     * @var array<mixed>
     */
    #[ORM\Column(type: Types::ARRAY)]
    private array $data = [];

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $user = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $finishedAt = null;

    public function __construct(
        #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
        private ?string $filepath = null,
    ) {
        $this->id = new LetterId();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function __toString(): string
    {
        return $this->id->toString();
    }

    public function getFinishedAt(): ?\DateTimeImmutable
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(?\DateTimeImmutable $finishedAt): void
    {
        $this->finishedAt = $finishedAt;
    }

    public function getId(): LetterId
    {
        return $this->id;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function setType(Type $type): void
    {
        $this->type = $type;
    }

    public function setFilepath(?string $filepath = null): void
    {
        $this->filepath = $filepath;
    }

    public function getFilepath(): ?string
    {
        return $this->filepath;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return array<mixed>
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array<mixed> $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(?string $user): void
    {
        $this->user = $user;
    }

    public function isFinished(): bool
    {
        return $this->finishedAt instanceof \DateTimeInterface;
    }
}

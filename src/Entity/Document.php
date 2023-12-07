<?php

declare(strict_types=1);

namespace App\Entity;

use App\Bridge\Doctrine\DBAL\Types\Type\Identifier\DocumentIdType;
use App\Domain\Enum\Category;
use App\Domain\Enum\Group;
use App\Domain\Identifier\DocumentId;
use App\Repository\DocumentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;

/**
 * @todo Rename all Letter stuff to Document
 */
#[ORM\Entity(repositoryClass: DocumentRepository::class)]
#[ORM\Table(name: 'letters')]
class Document implements \Stringable
{
    #[Id]
    #[Column(type: DocumentIdType::class, unique: true)]
    private DocumentId $id;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(type: Types::STRING, enumType: Group::class)]
    private Group $group = Group::Default;

    #[ORM\Column(type: Types::STRING, enumType: Category::class)]
    private Category $category = Category::Pending;

    /**
     * @var array<mixed>
     */
    #[ORM\Column(type: Types::ARRAY)]
    private array $data = [];

    #[ORM\Column(name: '`user`', type: Types::TEXT, nullable: true)]
    private ?string $user = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $inboxDate;

    /**
     * Das Dokument wurde gelöscht (soft delete) und kann wiederhergestellt werden.
     */
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    /**
     * Die Bearbeitung durch den Benutzer ist abgeschlossen.
     */
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $finishedAt = null;

    /**
     * Alle Informationen samt Dokument wurden an das Ziel-System gemeldet.
     */
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $exportedAt = null;

    public function __construct(
        #[ORM\Column(type: Types::STRING, length: 255)]
        private string $filename,
    ) {
        $this->id = new DocumentId();
        $this->createdAt = new \DateTimeImmutable();
        $this->inboxDate = clone $this->createdAt;
    }

    public function __toString(): string
    {
        return $this->id->toString();
    }

    public function getInboxDate(): \DateTimeImmutable
    {
        return $this->inboxDate;
    }

    public function setInboxDate(\DateTimeImmutable $inboxDate): void
    {
        $this->inboxDate = $inboxDate;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }

    public function setGroup(Group $group): void
    {
        $this->group = $group;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getId(): DocumentId
    {
        return $this->id;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function setFilename(string $filename): void
    {
        $this->filename = $filename;
    }

    public function getFilename(): string
    {
        return $this->filename;
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

    public function getFinishedAt(): ?\DateTimeImmutable
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(?\DateTimeImmutable $finishedAt): void
    {
        $this->finishedAt = $finishedAt;
    }

    public function getExportedAt(): ?\DateTimeImmutable
    {
        return $this->exportedAt;
    }

    public function setExportedAt(?\DateTimeImmutable $exportedAt): void
    {
        $this->exportedAt = $exportedAt;
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

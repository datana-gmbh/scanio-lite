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

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
#[ORM\Table(name: 'documents')]
class Document implements \Stringable
{
    #[Id]
    #[Column(type: DocumentIdType::class, unique: true)]
    private DocumentId $id;

    #[Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    /**
     * @var list<mixed>
     */
    #[Column(type: Types::ARRAY)]
    private array $data = [];

    #[Column(name: '`user`', type: Types::TEXT, nullable: true)]
    private ?string $user = null;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    /**
     * Das Posteingangsdatum des Dokuments.
     */
    #[Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $inboxDate = null;

    /**
     * Das Dokument wurde gelöscht (soft delete) und kann wiederhergestellt werden.
     */
    #[Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    /**
     * Die Bearbeitung durch den Benutzer ist abgeschlossen.
     */
    #[Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $finishedAt = null;

    /**
     * Alle Informationen samt Dokument wurden an das Ziel-System gemeldet.
     */
    #[Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $exportedAt = null;

    public function __construct(
        #[Column(type: Types::STRING, length: 255)]
        private string $filename,
        #[Column(type: Types::STRING, length: 255, nullable: true)]
        private ?string $originalFilename = null,
        #[Column(name: '`group`', type: Types::STRING, enumType: Group::class)]
        private Group $group = Group::Default,
        #[Column(type: Types::STRING, enumType: Category::class)]
        private Category $category = Category::Pending,
        #[Column(type: Types::TEXT, nullable: true)]
        private ?string $source = null,
    ) {
        $this->id = new DocumentId();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function __toString(): string
    {
        return $this->id->toString();
    }

    public function getInboxDate(): ?\DateTimeImmutable
    {
        return $this->inboxDate;
    }

    public function setInboxDate(?\DateTimeImmutable $inboxDate): void
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

    public function markFinished(): void
    {
        $this->finishedAt = new \DateTimeImmutable();
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
     * @return list<mixed>
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param list<mixed> $data
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

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): void
    {
        $this->source = $source;
    }

    public function getOriginalFilename(): ?string
    {
        return $this->originalFilename;
    }

    public function setOriginalFilename(?string $originalFilename): void
    {
        $this->originalFilename = $originalFilename;
    }

    public function isFinished(): bool
    {
        return $this->finishedAt instanceof \DateTimeInterface;
    }
}

<?php

declare(strict_types=1);

namespace App\Entity;

use App\Bridge\Doctrine\DBAL\Types\Type\Identifier\StorageIdType;
use App\Domain\Enum\StorageType;
use App\Domain\Identifier\StorageId;
use App\Repository\StorageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StorageRepository::class)]
#[ORM\Table(name: 'storages')]
class Storage implements \Stringable
{
    #[Id]
    #[Column(type: StorageIdType::class, unique: true)]
    private StorageId $id;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::STRING, enumType: StorageType::class)]
    private StorageType $storageType;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Assert\When(
        expression: 'this.getStorageType().value in ["dropbox"]',
        constraints: [new Assert\NotBlank()],
    )]
    private ?string $token = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Assert\When(
        expression: 'this.getStorageType().value in ["dropbox", "local"]',
        constraints: [new Assert\NotBlank()],
    )]
    private ?string $path = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $enabled = false;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $recursive = false;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $deleteAfterImport = false;

    public function __construct()
    {
        $this->id = new StorageId();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function __toString(): string
    {
        $string = $this->getStorageType()->value;

        $string .= ':'.($this->getPath() ?? 'null');

        return $string;
    }

    public function getId(): StorageId
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getStorageType(): StorageType
    {
        return $this->storageType;
    }

    public function setStorageType(StorageType $storageType): void
    {
        $this->storageType = $storageType;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): void
    {
        $this->path = $path;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function isRecursive(): bool
    {
        return $this->recursive;
    }

    public function setRecursive(bool $recursive): void
    {
        $this->recursive = $recursive;
    }

    public function deleteAfterImport(): bool
    {
        return $this->deleteAfterImport;
    }

    public function setDeleteAfterImport(bool $deleteAfterImport): void
    {
        $this->deleteAfterImport = $deleteAfterImport;
    }
}

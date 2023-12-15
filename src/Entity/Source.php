<?php

declare(strict_types=1);

namespace App\Entity;

use App\Bridge\Doctrine\DBAL\Types\Type\Identifier\SourceIdType;
use App\Domain\Identifier\SourceId;
use App\Repository\SourceRepository;
use App\Source\Value\Type;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SourceRepository::class)]
#[ORM\Table(name: 'sources')]
class Source implements \Stringable
{
    #[Id]
    #[Column(type: SourceIdType::class, unique: true)]
    private SourceId $id;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::STRING, enumType: Type::class)]
    private Type $type;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Assert\When(
        expression: 'this.getType().value in ["dropbox", "azure"]',
        constraints: [new Assert\NotBlank()],
    )]
    #[Assert\When(
        expression: 'this.getType().value in ["azure"]',
        constraints: [new Assert\Regex('/ContainerName\=[^;]+/', 'Dieser Wert muss einen Key "ContainerName" beinhalten')],
    )]
    private ?string $token = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    #[Assert\When(
        expression: 'this.getType().value in ["dropbox", "local", "azure"]',
        constraints: [new Assert\NotBlank()],
    )]
    private ?string $path = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $enabled = false;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $recursiveImport = false;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $deleteAfterImport = false;

    public function __construct()
    {
        $this->id = new SourceId();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function __toString(): string
    {
        $string = $this->getType()->value;

        $string .= ':'.($this->getPath() ?? 'null');

        return $string;
    }

    public function getId(): SourceId
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function setType(Type $type): void
    {
        $this->type = $type;
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

    public function recursiveImport(): bool
    {
        return $this->recursiveImport;
    }

    public function setRecursiveImport(bool $recursiveImport): void
    {
        $this->recursiveImport = $recursiveImport;
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

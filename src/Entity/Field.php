<?php

declare(strict_types=1);

namespace App\Entity;

use App\Bridge\Doctrine\DBAL\Types\Type\Identifier\FieldIdType;
use App\Domain\Identifier\FieldId;
use App\Repository\FieldRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;

#[Entity(repositoryClass: FieldRepository::class)]
class Field
{
    #[Id]
    #[Column(type: FieldIdType::class, unique: true)]
    private FieldId $id;

    #[ORM\Column(type: Types::STRING, nullable: false)]
    private string $name;

    #[ORM\Column(type: Types::STRING)]
    private ?string $condition = null;

    public function __construct()
    {
        $this->id = new FieldId();
    }

    public function getId(): FieldId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCondition(): ?string
    {
        return $this->condition;
    }

    public function setCondition(string $condition): self
    {
        $this->condition = $condition;

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace App\Tree\Domain\Value;

use App\Routing\Routes;

final class Node
{
    private ?string $label = null;
    private ?string $route = null;
    private ?string $icon = null;
    private ?int $count = null;

    /**
     * @var mixed[]
     */
    private array $routeParameters = [];
    private bool $enabled = true;
    private ?bool $display = null;
    private bool $showCount = true;

    /**
     * @var self[]
     */
    private array $children = [];

    private function __construct(
        public readonly string $name,
    ) {
    }

    public static function new(\BackedEnum|string $name): self
    {
        if ($name instanceof \BackedEnum) {
            $value = $name->value;

            if (\is_int($value)) {
                $name = (string) $value;
            } else {
                $name = $value;
            }
        }

        return new self($name);
    }

    public function label(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @param Routes::* $route
     * @param mixed[]   $parameters
     */
    public function route(string $route, array $parameters = []): self
    {
        $this->route = $route;

        $this->routeParameters = [];

        foreach ($parameters as $key => $value) {
            if ($value instanceof \BackedEnum) {
                $this->routeParameters[$key] = $value->value;

                continue;
            }

            $this->routeParameters[$key] = $value;
        }

        return $this;
    }

    public function icon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function count(?int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function hasCount(): bool
    {
        return null !== $this->count;
    }

    public function getCount(): ?int
    {
        if (null === $this->count
            && $this->hasChildren()
        ) {
            $count = 0;

            foreach ($this->children as $child) {
                $count += $child->getCount();
            }

            return $count;
        }

        return $this->count;
    }

    public function addChild(self $child): self
    {
        $this->children[] = $child;

        return $this;
    }

    public function disable(): self
    {
        $this->enabled = false;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    /**
     * @return mixed[]
     */
    public function getRouteParameters(): array
    {
        return $this->routeParameters;
    }

    /**
     * @return self[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    public function hasChildren(): bool
    {
        return \count($this->children) > 0;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function canDisplay(): bool
    {
        return $this->display ?? true;
    }

    public function displayIf(callable $function): self
    {
        $this->display = $function();

        return $this;
    }

    public function showCountIf(callable $function): self
    {
        $this->showCount = $function();

        return $this;
    }

    public function showCount(): bool
    {
        return $this->showCount;
    }
}

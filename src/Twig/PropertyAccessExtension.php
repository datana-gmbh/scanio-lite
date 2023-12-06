<?php

declare(strict_types=1);

namespace App\Twig;

use OskarStark\Value\TrimmedNonEmptyString;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class PropertyAccessExtension extends AbstractExtension
{
    /**
     * @return array<TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_value', $this->getValue(...)),
        ];
    }

    public function getValue(object $object, string $propertyPath): mixed
    {
        TrimmedNonEmptyString::fromString($propertyPath);

        $pa = PropertyAccess::createPropertyAccessor();

        return $pa->getValue($object, $propertyPath);
    }
}

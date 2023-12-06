<?php

declare(strict_types=1);

namespace App\Form;

use App\Domain\Enum\Type;
use App\Domain\Enum\Venture;

final class Choices
{
    public const PLACEHOLDER = 'Bitte auswählen';
    public const COMPANY_DEFAULT = 'Default Company';

    /**
     * Transforms an array like:
     *   array('a', 'b').
     *
     * to:
     *   array('a' => 'a', 'b' => 'b')
     *
     * @param array<int, string> $choices
     *
     * @return array<string, string>
     */
    public static function toAssociativeArray(array $choices): array
    {
        return array_combine($choices, $choices);
    }

    /**
     * @return array<string, string>
     */
    public static function ja_nein_ucfirst(): array
    {
        return self::toAssociativeArray([
            'Ja',
            'Nein',
        ]);
    }

    /**
     * @return array<string, string>
     */
    public static function ja_nein(): array
    {
        return self::toAssociativeArray([
            'ja',
            'nein',
        ]);
    }

    /**
     * @return array<string, string>
     */
    public static function ventures(): array
    {
        $ventures = [];

        foreach (Venture::cases() as $venture) {
            $ventures[$venture->value] = $venture->label();
        }

        return $ventures;
    }

    /**
     * @return array<string, string>
     */
    public static function types(): array
    {
        $types = [];

        foreach (Type::cases() as $type) {
            $types[$type->value] = $type->label();
        }

        return $types;
    }
}

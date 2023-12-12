<?php

declare(strict_types=1);

namespace App\Form;

use App\Domain\Enum\Category;
use App\Domain\Enum\Group;

final class Choices
{
    public const PLACEHOLDER = 'Bitte auswählen';

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
    public static function groups(): array
    {
        $groups = [];

        foreach (Group::cases() as $group) {
            $groups[$group->label()] = $group->value;
        }

        return $groups;
    }

    /**
     * @return array<string, string>
     */
    public static function categories(): array
    {
        $categories = [];

        foreach (Category::cases() as $category) {
            $categories[$category->label()] = $category->value;
        }

        return $categories;
    }
}

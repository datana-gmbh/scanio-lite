<?php

declare(strict_types=1);

namespace App\Tests\Unit\Form;

use App\Form\Choices;
use App\Tests\Unit\UnitTestCase;

/**
 * @covers \App\Form\Choices
 */
final class ChoicesTest extends UnitTestCase
{
    public function constants(): void
    {
        self::assertSame('Bitte auswählen', Choices::PLACEHOLDER);
    }

    /**
     * @test
     */
    public function toAssociativeArray(): void
    {
        $values = [
            self::faker()->sentence(),
            self::faker()->sentence(),
        ];

        self::assertSame(
            array_combine($values, $values),
            Choices::toAssociativeArray($values),
        );
    }

    /**
     * @test
     */
    public function jaNeinUcfirst(): void
    {
        $expected = [
            'Ja' => 'Ja',
            'Nein' => 'Nein',
        ];

        self::assertSame(
            $expected,
            Choices::ja_nein_ucfirst(),
        );
    }

    /**
     * @test
     */
    public function jaNein(): void
    {
        $expected = [
            'ja' => 'ja',
            'nein' => 'nein',
        ];

        self::assertSame(
            $expected,
            Choices::ja_nein(),
        );
    }

    /**
     * @test
     */
    public function types(): void
    {
        self::assertSame(
            [
                'other' => 'Sonstiges',
                'pending' => 'Unbearbeitet',
                'unknown' => 'Unbekannt',
            ],
            Choices::types(),
        );
    }

    /**
     * @test
     */
    public function ventures(): void
    {
        self::assertSame(
            [
                'default' => 'Standard',
            ],
            Choices::ventures(),
        );
    }
}

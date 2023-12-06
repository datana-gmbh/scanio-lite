<?php

declare(strict_types=1);

namespace App\Crud\Edit\Form;

use App\Domain\Enum\Type;
use App\Domain\Enum\Venture;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Form\FormTypeInterface;

#[AutoconfigureTag(self::class)]
interface FormTypeFactoryLoadableInterface extends FormTypeInterface
{
    public function supports(Venture $venture, Type $type): bool;
}

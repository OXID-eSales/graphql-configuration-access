<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

#[Type]
final class BooleanSetting
{
    public function __construct(
        private string $name,
        private bool $value
    ) {
    }

    /**
     * Field of Configuration Access module's BooleanSetting-Type
     */
    #[Field]
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Field of Configuration Access module's BooleanSetting-Type
     */
    #[Field]
    public function getValue(): bool
    {
        return $this->value;
    }
}

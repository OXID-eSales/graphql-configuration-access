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
final class IntegerSetting
{
    public function __construct(
        private string $name,
        private int $value
    ) {
    }

    /**
     * Field of Configuration Access module's StringSetting-Type
     */
    #[Field]
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Field of Configuration Access module's IntegerSetting-Type
     */
    #[Field]
    public function getValue(): int
    {
        return $this->value;
    }
}

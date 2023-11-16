<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;
use TheCodingMachine\GraphQLite\Types\ID;

#[Type]
final class StringSetting
{
    public function __construct(
        private ID $name,
        private string $value
    ) {
    }

    #[Field]
    public function getName(): ID
    {
        return $this->name;
    }

    #[Field]
    public function getValue(): string
    {
        return $this->value;
    }
}

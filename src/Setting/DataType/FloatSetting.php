<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
final class FloatSetting
{
    public function __construct(
        private string $name,
        private string $description,
        private float $value
    ) {}

    /**
     * @Field()
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @Field()
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @Field()
     */
    public function getValue(): float
    {
        return $this->value;
    }
}

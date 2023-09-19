<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
final class SettingType
{
    private FieldType $type;

    public function __construct(
        private string $name,
        private string $description,
        String $type
    ) {
        $this->type = FieldType::from($type);

    }

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
    public function getType(): string
    {
        return $this->type->value;
    }
}

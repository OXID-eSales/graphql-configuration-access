<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\Enum\FieldType;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * Contains type information of a setting
 */
#[Type]
final class SettingType
{
    public function __construct(
        private string $name,
        private string $type
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
     * Field of Configuration Access module's BooleanSetting-Type.
     * Indicates if the type is supported by our queries and mutations.
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    #[Field]
    public function isSupported(): bool
    {
        return FieldType::validateFieldType($this->getType());
    }

    /**
     * Field of Configuration Access module's StringSetting-Type
     */
    #[Field]
    public function getType(): string
    {
        return $this->type;
    }
}

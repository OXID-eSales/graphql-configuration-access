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

#[Type]
final class SettingType
{
    public function __construct(
        private string $name,
        private string $type
    ) {
    }

    #[Field]
    public function getName(): string
    {
        return $this->name;
    }

    #[Field]
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    #[Field]
    public function isSupported(): bool
    {
        return FieldType::validateFieldType($this->getType());
    }
}

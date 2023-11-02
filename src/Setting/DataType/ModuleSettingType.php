<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\ModuleFieldType;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
final class ModuleSettingType extends AbstractSettingType
{
    protected function validateFieldType(string $type): bool
    {
        return ModuleFieldType::validateFieldType($type);
    }

    protected function getFieldTypeEnums(): array
    {
        return ModuleFieldType::getEnums();
    }
}

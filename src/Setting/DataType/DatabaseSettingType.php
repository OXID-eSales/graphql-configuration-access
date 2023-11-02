<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\DatabaseFieldType;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
final class DatabaseSettingType extends AbstractSettingType
{
    protected function validateFieldType(string $type): bool
    {
        return DatabaseFieldType::validateFieldType($type);
    }

    protected function getFieldTypeEnums(): array
    {
        return DatabaseFieldType::getEnums();
    }
}

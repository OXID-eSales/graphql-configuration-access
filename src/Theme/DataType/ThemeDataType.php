<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\AbstractComponentDataType;
use TheCodingMachine\GraphQLite\Annotations\Type;

#[Type]
class ThemeDataType extends AbstractComponentDataType implements ThemeDataTypeInterface
{
    public function __construct(
        string $id,
        string $title,
        string $version,
        string $description,
        bool $active
    ) {
        parent::__construct($id, $title, $version, $description, $active);
    }
}

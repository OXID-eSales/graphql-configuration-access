<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum;

use TheCodingMachine\GraphQLite\Annotations\Type;

enum FieldType: string
{
    case ASSOCIATIVE_ARRAY = 'aarr';
    case NUMBER = 'num';
    case ARRAY = 'arr';
    case STRING = 'str';
    case BOOLEAN = 'bool';
    case SELECT = 'select';
}

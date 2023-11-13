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
use TheCodingMachine\GraphQLite\Types\ID;
use UnexpectedValueException;

/**
 * @Type()
 */
final class SettingType
{
    private string $type;

    public function __construct(
        private ID $name,
        string $type
    ) {
        $valid = FieldType::validateFieldType($type);
        if (!$valid) {
            throw new UnexpectedValueException('The value "' . $type . '" is not a valid field type.
Please use one of the following types: "' . implode('", "', FieldType::getEnums()) . '".');
        }

        $this->type = $type;
    }

    /**
     * @Field()
     */
    public function getName(): ID
    {
        return $this->name;
    }

    /**
     * @Field()
     */
    public function getType(): string
    {
        return $this->type;
    }
}

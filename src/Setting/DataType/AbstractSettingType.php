<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Types\ID;
use UnexpectedValueException;

abstract class AbstractSettingType
{
    public function __construct(
        protected ID $name,
        protected String $type
    ) {
        $valid = $this->validateFieldType($type);
        if (!$valid) {
            $this->throwUnexpectedValueExpception($this->getFieldTypeEnums());
        }
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

    /**
     * @param string[] $possibleEnums
     */
    protected function throwUnexpectedValueExpception(array $possibleEnums): void
    {
        throw new UnexpectedValueException('The value "'.$this->type.'" is not a valid field type.
Please use one of the following types: "'.implode('", "', $possibleEnums).'".');
    }

    abstract protected function validateFieldType(string $type): bool;

    /**
     * @return string[]
     */
    abstract protected function getFieldTypeEnums(): array;
}

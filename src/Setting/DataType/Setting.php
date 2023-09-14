<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\SourceType;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
final class Setting
{
    private array $settingData;

    public function __construct(array $settingData)
    {
        $this->settingData = $settingData;
    }

    /**
     * @Field()
     */
    public function getName(): string
    {
        return (string)$this->settingData['OXVARNAME'];
    }
    
    /**
     * @Field()
     */
    public function getDescription(): string
    {
        return (string)$this->settingData['DESCRIPTION'];
    }

    /**
     * @Field()
     */
    public function getValue(): string
    {
        return (string)$this->settingData['OXVARVALUE'];
    }

    /**
     * @Field()
     */
    public function getFieldType(): FieldType
    {
        return FieldType::fromInternalType($this->settingData['OXVARTYPE']);
    }
    
    /**
     * @Field()
     */
    public function getSourceType(): SourceType
    {
        return SourceType::fromSourceId($this->settingData['OXMODULE']);
    }

    /**
     * @Field()
     */
    public function getSourceId(): string
    {
        return $this->settingData['OXMODULE'];
    }
}

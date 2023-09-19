<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

/**
 * @Type()
 */
final class FloatSetting
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
}

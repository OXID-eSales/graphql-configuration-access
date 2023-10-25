<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception;

use Exception;

final class InvalidType extends Exception
{
    protected $typeMapping = [
        'aarr'   => 'associative array',
        'arr'    => 'array',
        'bool'   => 'boolean',
        'num'    => 'number',
        'str'    => 'string',
        'select' => 'select',
    ];

    protected $mutationMapping = [
        'aarr'   => 'getModuleSettingCollection',
        'arr'    => 'getModuleSettingCollection',
        'bool'   => 'changeModuleSettingBoolean',
        'num'    => 'changeModuleSettingInteger or changeModuleSettingFloat',
        'str'    => 'changeModuleSettingString',
        'select' => '???', //todo: add mutation when we have one for select type
    ];

    public function __construct(string $type)
    {
        parent::__construct(sprintf('This setting expects value of type %s. You should use %s mutation instead.', $this->typeMapping[$type], $this->mutationMapping[$type]));
    }
}

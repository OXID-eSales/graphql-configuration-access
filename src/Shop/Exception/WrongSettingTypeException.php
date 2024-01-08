<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shop\Exception;

use OxidEsales\GraphQL\Base\Exception\Error;

final class WrongSettingTypeException extends Error
{
    public function __construct()
    {
        parent::__construct('Wrong setting type');
    }
}

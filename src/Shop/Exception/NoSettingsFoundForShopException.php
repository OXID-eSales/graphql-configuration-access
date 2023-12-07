<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shop\Exception;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception\NoSettingsFoundException;

class NoSettingsFoundForShopException extends NoSettingsFoundException
{
    public function __construct(int $shopId)
    {
        $message = sprintf('No settings found for shop: %d', $shopId);

        parent::__construct($message);
    }
}

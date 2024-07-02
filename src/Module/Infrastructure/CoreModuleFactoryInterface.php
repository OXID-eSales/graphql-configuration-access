<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure;

use OxidEsales\Eshop\Core\Module\Module;

interface CoreModuleFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function getClass(): Module;
}

<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Infrastructure;

use OxidEsales\Eshop\Core\Module\Module;

class CoreModuleFactory implements CoreModuleFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function getClass(): Module
    {
        return oxNew(Module::class);
    }
}

<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Service;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Bridge\ModuleActivationBridgeInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\ContextInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleActivationException;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleDeactivationBlockedException;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Exception\ModuleDeactivationException;

class ModuleActivationService implements ModuleActivationServiceInterface
{
    public function __construct(
        private readonly ContextInterface $context,
        private readonly ModuleActivationBridgeInterface $moduleActivationBridge,
        private readonly ModuleBlocklistServiceInterface $moduleBlocklistService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function activateModule(string $moduleId): bool
    {
        $shopId = $this->context->getCurrentShopId();

        try {
            $this->moduleActivationBridge->activate(moduleId: $moduleId, shopId: $shopId);
        } catch (\Exception $exception) {
            throw new ModuleActivationException();
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function deactivateModule(string $moduleId): bool
    {
        if ($this->moduleBlocklistService->isModuleBlocked($moduleId)) {
            throw new ModuleDeactivationBlockedException($moduleId);
        }

        $shopId = $this->context->getCurrentShopId();

        try {
            $this->moduleActivationBridge->deactivate(moduleId: $moduleId, shopId: $shopId);
        } catch (\Exception $exception) {
            throw new ModuleDeactivationException();
        }

        return true;
    }
}

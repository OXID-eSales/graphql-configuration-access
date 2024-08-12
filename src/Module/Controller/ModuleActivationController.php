<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleActivationServiceInterface;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Mutation;
use TheCodingMachine\GraphQLite\Annotations\Right;

class ModuleActivationController
{
    public function __construct(
        private readonly ModuleActivationServiceInterface $moduleActivationService
    ) {
    }

    /**
     * Mutation of Configuration Access Module
     * @param string $moduleId
     * @return bool
     */
    #[Mutation]
    #[Logged]
    #[Right('CHANGE_CONFIGURATION')]
    public function activateModule(string $moduleId): bool
    {
        return $this->moduleActivationService->activateModule(moduleId: $moduleId);
    }

    /**
     * Mutation of Configuration Access Module
     * @param string $moduleId
     * @return bool
     */
    #[Mutation]
    #[Logged]
    #[Right('CHANGE_CONFIGURATION')]
    public function deactivateModule(string $moduleId): bool
    {
        return $this->moduleActivationService->deactivateModule(moduleId: $moduleId);
    }
}

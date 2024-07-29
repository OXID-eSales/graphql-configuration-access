<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataType;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleFilters;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleListServiceInterface;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Annotations\Right;

final class ModuleListController
{
    public function __construct(
        private readonly ModuleListServiceInterface $moduleListService
    ) {
    }

    /**
     * Query of Configuration Access Module
     * @return ModuleDataType[]
     */
    #[Query]
    #[Logged]
    #[Right('CHANGE_CONFIGURATION')]
    public function modulesList(?ModuleFilters $filters = null): array
    {
        return $this->moduleListService->getModuleList($filters ?? new ModuleFilters());
    }
}

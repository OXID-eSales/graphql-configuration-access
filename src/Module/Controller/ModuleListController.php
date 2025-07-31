<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleListServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter\ComponentFilters;
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
     * @return ModuleDataTypeInterface[]
     */
    #[Query]
    #[Logged]
    #[Right('LIST_MODULES')]
    public function modules(?ComponentFilters $filters): array
    {
        return $this->moduleListService->getModuleList($filters ?? new ComponentFilters());
    }
}

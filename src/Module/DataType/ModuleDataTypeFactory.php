<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\DataType;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\LanguageService;

class ModuleDataTypeFactory implements ModuleDataTypeFactoryInterface
{
    public function __construct(
        private LanguageService $languageService
    ) {
    }

    public function createFromCoreModule(
        ModuleConfiguration $moduleConfig
    ): ModuleDataType {
        $titlesData = $moduleConfig->getTitle();
        $title = $this->languageService->filterByLanguageAbbreviation(data: $titlesData);

        $descriptionData = $moduleConfig->getDescription();
        $description = $this->languageService->filterByLanguageAbbreviation(data: $descriptionData);

        return new ModuleDataType(
            id: $moduleConfig->getId(),
            version: $moduleConfig->getVersion(),
            title: $title,
            description: $description,
            thumbnail: $moduleConfig->getThumbnail(),
            author: $moduleConfig->getAuthor(),
            url: $moduleConfig->getUrl(),
            email: $moduleConfig->getEmail(),
            active: (bool) $moduleConfig->isActivated(),
        );
    }
}

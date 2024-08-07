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

    public function createFromModuleConfiguration(
        ModuleConfiguration $moduleConfig
    ): ModuleDataTypeInterface {
        $titlesData = $moduleConfig->getTitle();
        $translatedTitle = $this->languageService->filterByLanguageAbbreviation(
            data: $titlesData,
            defaultLang: $moduleConfig->getLang()
        );

        $description = $moduleConfig->getDescription();
        $translatedDescription = $this->languageService->filterByLanguageAbbreviation(
            data: $description,
            defaultLang: $moduleConfig->getLang()
        );

        return new ModuleDataType(
            id: $moduleConfig->getId(),
            title: $translatedTitle,
            version: $moduleConfig->getVersion(),
            description: $translatedDescription,
            active: $moduleConfig->isActivated(),
            thumbnail: $moduleConfig->getThumbnail(),
            author: $moduleConfig->getAuthor(),
            url: $moduleConfig->getUrl(),
            email: $moduleConfig->getEmail()
        );
    }
}

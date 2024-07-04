<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\Core\LanguageWrapperInterface;

class LanguageService implements LanguageServiceInterface
{
    public function __construct(
        private LanguageWrapperInterface $language
    ) {
    }

    public function filterByLanguageAbbreviation(array $data): ?string
    {
        $langId = $this->language->getBaseLanguage();
        $languageAbbr = $this->language->getLanguageAbbr(langId: $langId);

        return $data[$languageAbbr] ?? null;
    }
}

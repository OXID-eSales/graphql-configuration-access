<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\Service;

use OxidEsales\Eshop\Core\Language;

class LanguageService implements LanguageServiceInterface
{
    public function __construct(
        protected Language $language
    ) {
    }

    public function filterByLanguageAbbreviation(array $data): ?string
    {
        $langId = $this->language->getBaseLanguage();
        $languageAbbr = $this->language->getLanguageAbbr(iLanguage: $langId);

        return $data[$languageAbbr] ?? null;
    }
}

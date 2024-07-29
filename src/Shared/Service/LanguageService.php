<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\Infrastructure\LanguageWrapperInterface;

class LanguageService implements LanguageServiceInterface
{
    public function __construct(
        private LanguageWrapperInterface $languageWrapper
    ) {
    }

    public function filterByLanguageAbbreviation(array $data): ?string
    {
        $langId = $this->languageWrapper->getBaseLanguage();
        $languageAbbr = $this->languageWrapper->getLanguageAbbr(langId: $langId);

        if (isset($data[$languageAbbr])) {
            return $data[$languageAbbr];
        }

        if (isset($data['en'])) {
            return $data['en'];
        }

        return null;
    }
}

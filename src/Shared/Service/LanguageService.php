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
        private LanguageWrapperInterface $language
    ) {
    }

    public function filterByLanguageAbbreviation(array $data, string $defaultLang): string
    {
        $languageAbbr = $this->language->getCurrentLanguageAbbr();

        if (isset($data[$languageAbbr])) {
            return $data[$languageAbbr];
        }

        if (isset($data[$defaultLang])) {
            return $data[$defaultLang];
        }

        $dataReversed = array_reverse($data);
        return array_pop($dataReversed);
    }
}

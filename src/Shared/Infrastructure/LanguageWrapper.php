<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\Infrastructure;

use OxidEsales\Eshop\Core\Language;

class LanguageWrapper implements LanguageWrapperInterface
{
    public function __construct(
        private Language $language
    ) {
    }

    public function getCurrentLanguageAbbr(): string
    {
        $this->language->getLanguageAbbr();
        return $this->language->getLanguageAbbr();
    }
}

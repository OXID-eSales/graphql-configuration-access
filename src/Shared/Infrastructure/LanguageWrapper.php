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

    public function getBaseLanguage(): int
    {
        /**  @var int|null $langId */
        $langId = $this->language->getBaseLanguage();
        return (int)$langId;
    }

    public function getLanguageAbbr(?int $langId = null): string
    {
        return $this->language->getLanguageAbbr(iLanguage: $langId);
    }
}

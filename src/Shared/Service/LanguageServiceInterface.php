<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\Service;

interface LanguageServiceInterface
{
    public function filterByLanguageAbbreviation(array $data, string $defaultLang): string;
}

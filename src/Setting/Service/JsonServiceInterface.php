<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

interface JsonServiceInterface
{
    public function jsonEncodeArray(array $collection): string;

    public function jsonDecodeCollection(string $value): array;
}

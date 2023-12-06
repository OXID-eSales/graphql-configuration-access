<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

interface CollectionEncodingServiceInterface
{
    public function encodeArrayToString(array $collection): string;

    public function decodeStringCollectionToArray(string $value): array;
}

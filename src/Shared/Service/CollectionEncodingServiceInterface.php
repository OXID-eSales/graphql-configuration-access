<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception\CollectionEncodingException;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception\InvalidCollectionException;

interface CollectionEncodingServiceInterface
{
    /**
     * @throws CollectionEncodingException
     */
    public function encodeArrayToString(array $collection): string;

    /**
     * @throws InvalidCollectionException
     */
    public function decodeStringCollectionToArray(string $value): array;
}

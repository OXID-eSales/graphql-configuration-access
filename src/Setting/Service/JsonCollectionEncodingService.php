<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\CollectionEncodingException;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\InvalidCollectionException;

class JsonCollectionEncodingService implements CollectionEncodingServiceInterface
{
    /**
     * @throws CollectionEncodingException
     */
    public function encodeArrayToString(array $collection): string
    {
        $jsonValue = json_encode($collection);

        if ($jsonValue === false) {
            throw new CollectionEncodingException();
        }
        return $jsonValue;
    }

    /**
     * @throws InvalidCollectionException
     */
    public function decodeStringCollectionToArray(string $value): array
    {
        if ($value === '') {
            return [];
        }

        $arrayValue = json_decode($value, true);

        if (!is_array($arrayValue) || json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidCollectionException($value);
        }

        return $arrayValue;
    }
}

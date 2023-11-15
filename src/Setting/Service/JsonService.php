<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\CollectionEncodingException;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\InvalidCollection;

class JsonService implements JsonServiceInterface
{
    /**
     * @throws CollectionEncodingException
     */
    public function jsonEncodeArray(array $collection): string
    {
        $jsonValue = json_encode($collection);

        if ($jsonValue === false) {
            throw new CollectionEncodingException();
        }
        return $jsonValue;
    }

    /**
     * @throws InvalidCollection
     */
    public function jsonDecodeCollection(string $value): array
    {
        if ($value === '') {
            return [];
        }

        $arrayValue = json_decode($value, true);

        if (!is_array($arrayValue) || json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidCollection($value);
        }

        return $arrayValue;
    }
}

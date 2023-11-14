<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\CollectionEncodingException;

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
}

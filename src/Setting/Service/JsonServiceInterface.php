<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

interface JsonServiceInterface
{
    public function jsonEncodeArray(array $collection): string;

    public function jsonDecodeCollection(string $value): array;
}

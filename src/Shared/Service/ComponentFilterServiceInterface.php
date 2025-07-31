<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentDataTypeInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter\ComponentFiltersInterface;

interface ComponentFilterServiceInterface
{
    /**
     * @template T of ComponentDataTypeInterface
     * @param array<T> $components
     *
     * @return array<T>
     */
    public function filterComponents(array $components, ComponentFiltersInterface $filterList): array;
}

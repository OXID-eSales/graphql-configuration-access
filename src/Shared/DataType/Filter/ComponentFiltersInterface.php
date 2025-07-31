<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentDataTypeInterface;

interface ComponentFiltersInterface
{
    public function filterComponent(ComponentDataTypeInterface $component): bool;
}

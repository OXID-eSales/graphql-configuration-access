<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType;

interface ComponentFiltersInterface
{
    public function filterComponent(ComponentDataTypeInterface $component): bool;
}

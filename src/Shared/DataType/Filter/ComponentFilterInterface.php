<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentDataTypeInterface;

interface ComponentFilterInterface
{
    public function componentMatches(ComponentDataTypeInterface $componentDataType): bool;
}

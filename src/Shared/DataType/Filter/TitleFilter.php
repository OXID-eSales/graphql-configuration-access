<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter;

use OxidEsales\GraphQL\Base\DataType\Filter\StringFilter;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentDataTypeInterface;

class TitleFilter extends StringFilter implements ComponentFilterInterface
{
    public function componentMatches(ComponentDataTypeInterface $componentDataType): bool
    {
        return $this->matches($componentDataType->getTitle());
    }
}

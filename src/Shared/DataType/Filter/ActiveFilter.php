<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\Filter;

use OxidEsales\GraphQL\Base\DataType\Filter\BoolFilter;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentDataTypeInterface;

class ActiveFilter extends BoolFilter implements ComponentFilterInterface
{
    public function componentMatches(ComponentDataTypeInterface $componentDataType): bool
    {
        if ($componentDataType->isActive() !== $this->equals()) {
            return false;
        }

        return true;
    }
}

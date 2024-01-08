<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception;

use OxidEsales\GraphQL\Base\Exception\Error;

final class CollectionEncodingException extends Error
{
    public function __construct()
    {
        parent::__construct('Error encountered while encoding collection data');
    }
}

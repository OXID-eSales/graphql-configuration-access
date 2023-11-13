<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\Service;

use OxidEsales\GraphQL\Base\Framework\NamespaceMapperInterface;

final class NamespaceMapper implements NamespaceMapperInterface
{
    private const SPACE = '\\OxidEsales\\GraphQL\\ConfigurationAccess\\';

    public function getControllerNamespaceMapping(): array
    {
        return [
            self::SPACE . 'Setting\\Controller' => __DIR__ . '/../../Setting/Controller/',
        ];
    }

    public function getTypeNamespaceMapping(): array
    {
        return [
            self::SPACE . 'Setting\\DataType' => __DIR__ . '/../../Setting/DataType/',
        ];
    }
}

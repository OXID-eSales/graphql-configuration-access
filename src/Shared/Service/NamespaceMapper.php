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
            self::SPACE . 'Module\\Controller' => __DIR__ . '/../../Module/Controller/',
            self::SPACE . 'Shop\\Controller' => __DIR__ . '/../../Shop/Controller/',
            self::SPACE . 'Theme\\Controller' => __DIR__ . '/../../Theme/Controller/',
        ];
    }

    public function getTypeNamespaceMapping(): array
    {
        return [
            self::SPACE . 'Shared\\DataType' => __DIR__ . '/../../Shared/DataType/',
        ];
    }
}

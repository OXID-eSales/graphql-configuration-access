<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\Service;

use PHPUnit\Framework\TestCase;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\PermissionProvider;

class PermissionProviderTest extends TestCase
{
    public function testGetPermissions(): void
    {
        $expectedPermissions = [
            'oxidadmin' => [
                'CHANGE_CONFIGURATION',
                'LIST_THEMES',
                'LIST_MODULES'
            ],
        ];

        $permissionProvider = new PermissionProvider();
        $actualPermissions = $permissionProvider->getPermissions();

        $this->assertSame($expectedPermissions, $actualPermissions);
    }
}

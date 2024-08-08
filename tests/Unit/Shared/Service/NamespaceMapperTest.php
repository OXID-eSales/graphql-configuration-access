<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\NamespaceMapper;
use PHPUnit\Framework\TestCase;

class NamespaceMapperTest extends TestCase
{
    private const NAMESPACE_PREFIX = '\\OxidEsales\\GraphQL\\ConfigurationAccess';

    private static string $srcPath;

    public static function setUpBeforeClass(): void
    {
        self::$srcPath = self::getSrcDirectoryPath();
    }

    public function testGetControllerNamespaceMapping(): void
    {
        $expectedMapping = [
            self::NAMESPACE_PREFIX . '\\Module\\Controller' =>
                self::$srcPath . '/Shared/Service/../../Module/Controller/',
            self::NAMESPACE_PREFIX . '\\Shop\\Controller' =>
                self::$srcPath . '/Shared/Service/../../Shop/Controller/',
            self::NAMESPACE_PREFIX . '\\Theme\\Controller' =>
                self::$srcPath . '/Shared/Service/../../Theme/Controller/',
        ];

        $sut = $this->getSut();
        $actualMapping = $sut->getControllerNamespaceMapping();

        $this->assertSame($expectedMapping, $actualMapping);
    }

    public function testGetTypeNamespaceMapping(): void
    {
        $expectedMapping = [
            self::NAMESPACE_PREFIX . '\\Shared\\DataType' =>
                self::$srcPath . '/Shared/Service/../../Shared/DataType/',
            self::NAMESPACE_PREFIX . '\\Theme\\DataType' =>
                self::$srcPath . '/Shared/Service/../../Theme/DataType/',
            self::NAMESPACE_PREFIX . '\\Module\\DataType' =>
                self::$srcPath . '/Shared/Service/../../Module/DataType/',
        ];

        $sut = $this->getSut();
        $actualMapping = $sut->getTypeNamespaceMapping();

        $this->assertSame($expectedMapping, $actualMapping);
    }

    private static function getSrcDirectoryPath(): string
    {
        $testsDir = 'tests';
        $currentPath = __DIR__;
        $testsPos = strpos($currentPath, $testsDir);

        if ($testsPos === false) {
            return $currentPath;
        }

        return substr($currentPath, 0, $testsPos) . 'src';
    }

    private function getSut(): NamespaceMapper
    {
        return new NamespaceMapper();
    }
}

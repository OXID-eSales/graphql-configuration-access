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
    protected string $namespacePrefix;

    protected string $srcPath;

    protected function setUp(): void
    {
        $this->srcPath = $this->getSrcDirectoryPath();
        $this->namespacePrefix = '\\OxidEsales\\GraphQL\\ConfigurationAccess';
    }

    public function testGetControllerNamespaceMapping(): void
    {
        $expectedMapping = [
            $this->namespacePrefix . '\\Module\\Controller' =>
                $this->srcPath . '/Shared/Service/../../Module/Controller/',
            $this->namespacePrefix . '\\Shop\\Controller' =>
                $this->srcPath . '/Shared/Service/../../Shop/Controller/',
            $this->namespacePrefix . '\\Theme\\Controller' =>
                $this->srcPath . '/Shared/Service/../../Theme/Controller/',
        ];

        $sut = $this->getSut();
        $actualMapping = $sut->getControllerNamespaceMapping();

        $this->assertSame($expectedMapping, $actualMapping);
    }

    public function testGetTypeNamespaceMapping(): void
    {
        $expectedMapping = [
            $this->namespacePrefix . '\\Shared\\DataType' =>
                $this->srcPath . '/Shared/Service/../../Shared/DataType/',
            $this->namespacePrefix . '\\Module\\DataType' =>
                $this->srcPath . '/Shared/Service/../../Module/DataType/',
        ];

        $sut = $this->getSut();
        $actualMapping = $sut->getTypeNamespaceMapping();

        $this->assertSame($expectedMapping, $actualMapping);
    }

    private function getSrcDirectoryPath(): string
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

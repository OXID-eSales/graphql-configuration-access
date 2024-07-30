<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\DataType;

use OxidEsales\Eshop\Core\Module\Module;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeFactory;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\LanguageService;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeFactory
 */
class ModuleDataTypeFactoryTest extends UnitTestCase
{
    public function testCreateFromCoreModule()
    {
        $titlesData = [
            'de' => uniqid(),
            'en' => uniqid(),
        ];
        $descriptionData = [
            'de' => uniqid(),
            'en' => uniqid(),
        ];
        $expectedId = uniqid();
        $expectedVersion = uniqid();
        $expectedThumbnail = uniqid();
        $expectedAuthor = uniqid();
        $expectedUrl = uniqid();
        $expectedEmail = uniqid();

        $moduleConfigMock = $this->createMock(ModuleConfiguration::class);
        $moduleConfigMock->method('getId')->willReturn($expectedId);
        $moduleConfigMock->method('getVersion')->willReturn($expectedVersion);
        $moduleConfigMock->method('getTitle')->willReturn($titlesData);
        $moduleConfigMock->method('getDescription')->willReturn($descriptionData);
        $moduleConfigMock->method('getThumbnail')->willReturn($expectedThumbnail);
        $moduleConfigMock->method('getAuthor')->willReturn($expectedAuthor);
        $moduleConfigMock->method('getUrl')->willReturn($expectedUrl);
        $moduleConfigMock->method('getEmail')->willReturn($expectedEmail);
        $moduleConfigMock->method('isActivated')->willReturn((bool)random_int(0, 1));

        $languageServiceMock = $this->createMock(LanguageService::class);
        $languageServiceMock
            ->method('filterByLanguageAbbreviation')
            ->willReturnMap([
                [$titlesData, $titlesData['de']],
                [$descriptionData, $descriptionData['de']]
            ]);

        $moduleDataTypeFactory = new ModuleDataTypeFactory($languageServiceMock);
        $moduleDataType = $moduleDataTypeFactory->createFromCoreModule(moduleConfig: $moduleConfigMock);

        $this->assertSame($expectedId, $moduleDataType->getId());
        $this->assertSame($expectedVersion, $moduleDataType->getVersion());
        $this->assertSame($titlesData['de'], $moduleDataType->getTitle());
        $this->assertSame($descriptionData['de'], $moduleDataType->getDescription());
        $this->assertSame($expectedThumbnail, $moduleDataType->getThumbnail());
        $this->assertSame($expectedAuthor, $moduleDataType->getAuthor());
        $this->assertSame($expectedUrl, $moduleDataType->getUrl());
        $this->assertSame($expectedEmail, $moduleDataType->getEmail());
        $this->assertIsBool($moduleDataType->isActive());
    }
}

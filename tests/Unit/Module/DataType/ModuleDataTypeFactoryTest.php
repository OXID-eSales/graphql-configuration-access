<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\DataType;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeFactory;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\LanguageService;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(\OxidEsales\GraphQL\ConfigurationAccess\Module\DataType\ModuleDataTypeFactory::class)]
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
        $expectedLang = uniqid();
        $expectedIsActivated = (bool)random_int(0, 1);

        $moduleConfigMock = $this->createConfiguredStub(ModuleConfiguration::class, [
            'getId' => $expectedId,
            'getVersion' => $expectedVersion,
            'getTitle' => $titlesData,
            'getDescription' => $descriptionData,
            'getThumbnail' => $expectedThumbnail,
            'getAuthor' => $expectedAuthor,
            'getUrl' => $expectedUrl,
            'getEmail' => $expectedEmail,
            'isActivated' => $expectedIsActivated,
            'getLang' => $expectedLang
        ]);

        $languageServiceMock = $this->createMock(LanguageService::class);
        $languageServiceMock
            ->expects($this->exactly(2))
            ->method('filterByLanguageAbbreviation')
            ->willReturnMap([
                [$titlesData, $expectedLang, $titlesData['de']],
                [$descriptionData, $expectedLang, $descriptionData['de']]
            ]);

        $moduleDataTypeFactory = new ModuleDataTypeFactory($languageServiceMock);
        $moduleDataType = $moduleDataTypeFactory->createFromModuleConfiguration(moduleConfig: $moduleConfigMock);

        $this->assertSame($expectedId, $moduleDataType->getId());
        $this->assertSame($expectedVersion, $moduleDataType->getVersion());
        $this->assertSame($titlesData['de'], $moduleDataType->getTitle());
        $this->assertSame($descriptionData['de'], $moduleDataType->getDescription());
        $this->assertSame($expectedThumbnail, $moduleDataType->getThumbnail());
        $this->assertSame($expectedAuthor, $moduleDataType->getAuthor());
        $this->assertSame($expectedUrl, $moduleDataType->getUrl());
        $this->assertSame($expectedEmail, $moduleDataType->getEmail());
        $this->assertSame($expectedIsActivated, $moduleDataType->isActive());
        $this->assertSame($expectedLang, $moduleDataType->getLang());
    }
}

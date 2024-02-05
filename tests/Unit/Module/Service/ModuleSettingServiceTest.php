<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Module\Service;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Dao\ModuleConfigurationDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setting\Setting;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\ContextInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleSettingService;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\CollectionEncodingServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use Symfony\Component\String\UnicodeString;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Module\Service\ModuleSettingService
 */
class ModuleSettingServiceTest extends UnitTestCase
{
    public function testGetModuleSettingInteger(): void
    {
        $name = 'someSetting';
        $moduleId = 'awesomeModule';

        $shopServiceReturn = 123;
        $sut = $this->getSut(
            moduleSettingService: $this->getShopModuleSettingServiceMethodStub(
                'getInteger',
                $name,
                $moduleId,
                $shopServiceReturn
            )
        );

        $this->assertEquals(
            new IntegerSetting($name, $shopServiceReturn),
            $sut->getIntegerSetting($name, $moduleId)
        );
    }

    public function testGetModuleSettingFloat(): void
    {
        $name = 'floatSetting';
        $moduleId = 'awesomeModule';

        $shopServiceReturn = 1.23;
        $sut = $this->getSut(
            moduleSettingService: $this->getShopModuleSettingServiceMethodStub(
                'getFloat',
                $name,
                $moduleId,
                $shopServiceReturn
            ),
        );

        $this->assertEquals(
            new FloatSetting($name, $shopServiceReturn),
            $sut->getFloatSetting($name, $moduleId)
        );
    }

    public function testGetModuleSettingBoolean(): void
    {
        $name = 'booleanSetting';
        $moduleId = 'awesomeModule';

        $shopServiceReturn = false;
        $sut = $this->getSut(
            moduleSettingService: $this->getShopModuleSettingServiceMethodStub(
                'getBoolean',
                $name,
                $moduleId,
                $shopServiceReturn
            ),
        );

        $this->assertEquals(
            new BooleanSetting($name, $shopServiceReturn),
            $sut->getBooleanSetting($name, $moduleId)
        );
    }

    public function testGetModuleSettingString(): void
    {
        $name = 'stringSetting';
        $moduleId = 'awesomeModule';

        $shopServiceReturn = 'default';
        $sut = $this->getSut(
            moduleSettingService: $this->getShopModuleSettingServiceMethodStub(
                'getString',
                $name,
                $moduleId,
                new UnicodeString($shopServiceReturn)
            ),
        );

        $this->assertEquals(
            new StringSetting($name, $shopServiceReturn),
            $sut->getStringSetting($name, $moduleId)
        );
    }

    public function testGetModuleSettingCollection(): void
    {
        $name = 'arraySetting';
        $moduleId = 'awesomeModule';
        $shopServiceReturn = ['nice', 'values'];

        $encoderResponse = 'encoderResponse';
        $encoder = $this->createMock(CollectionEncodingServiceInterface::class);
        $encoder->method('encodeArrayToString')
            ->with($shopServiceReturn)
            ->willReturn($encoderResponse);

        $sut = $this->getSut(
            jsonService: $encoder,
            moduleSettingService: $this->getShopModuleSettingServiceMethodStub(
                'getCollection',
                $name,
                $moduleId,
                $shopServiceReturn
            )
        );

        $this->assertEquals(
            new StringSetting($name, $encoderResponse),
            $sut->getCollectionSetting($name, $moduleId)
        );
    }

    public function testChangeModuleSettingInteger(): void
    {
        $name = 'intSetting';
        $moduleId = 'awesomeModule';

        $callValue = 123;
        $repositoryValue = 321;

        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('saveInteger')
            ->with($name, $callValue, $moduleId);
        $moduleSettingService->method('getInteger')
            ->with($name, $moduleId)
            ->willReturn($repositoryValue);

        $sut = $this->getSut(
            moduleSettingService: $moduleSettingService
        );

        $setting = $sut->changeIntegerSetting($name, $callValue, $moduleId);

        $this->assertEquals($name, $setting->getName());
        $this->assertSame($repositoryValue, $setting->getValue());
    }

    public function testChangeModuleSettingFloat(): void
    {
        $name = 'floatSetting';
        $moduleId = 'awesomeModule';

        $callValue = 1.23;
        $repositoryValue = 3.21;

        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('saveFloat')
            ->with($name, $callValue, $moduleId);
        $moduleSettingService->method('getFloat')
            ->with($name, $moduleId)
            ->willReturn($repositoryValue);

        $sut = $this->getSut(
            moduleSettingService: $moduleSettingService
        );

        $setting = $sut->changeFloatSetting($name, $callValue, $moduleId);

        $this->assertEquals($name, $setting->getName());
        $this->assertSame($repositoryValue, $setting->getValue());
    }

    public function testChangeModuleSettingBoolean(): void
    {
        $name = 'boolSetting';
        $moduleId = 'awesomeModule';

        $callValue = true;
        $repositoryValue = false;

        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('saveBoolean')
            ->with($name, $callValue, $moduleId);
        $moduleSettingService->method('getBoolean')
            ->with($name, $moduleId)
            ->willReturn($repositoryValue);

        $sut = $this->getSut(
            moduleSettingService: $moduleSettingService
        );

        $setting = $sut->changeBooleanSetting($name, $callValue, $moduleId);

        $this->assertEquals($name, $setting->getName());
        $this->assertSame($repositoryValue, $setting->getValue());
    }

    public function testChangeModuleSettingString(): void
    {
        $name = 'stringSetting';
        $moduleId = 'awesomeModule';

        $callValue = 'someNewValue';
        $repositoryValue = 'realDatabaseValue';

        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('saveString')
            ->with($name, $callValue, $moduleId);
        $moduleSettingService->method('getString')
            ->with($name, $moduleId)
            ->willReturn(new UnicodeString($repositoryValue));

        $sut = $this->getSut(
            moduleSettingService: $moduleSettingService
        );

        $setting = $sut->changeStringSetting($name, $callValue, $moduleId);

        $this->assertEquals($name, $setting->getName());
        $this->assertSame($repositoryValue, $setting->getValue());
    }

    public function testChangeModuleSettingCollection(): void
    {
        $name = 'collectionSetting';
        $moduleId = 'awesomeModule';

        $callValue = 'someCollectionValue';
        $repositoryValue = ['realDatabaseValue'];

        $decodedValue = ['decodedCollectionValue'];

        $encoderResponse = 'encoderResponse';
        $encoder = $this->createMock(CollectionEncodingServiceInterface::class);
        $encoder->method('encodeArrayToString')
            ->with($repositoryValue)
            ->willReturn($encoderResponse);
        $encoder->method('decodeStringCollectionToArray')
            ->with($callValue)
            ->willReturn($decodedValue);

        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method('saveCollection')
            ->with($name, $decodedValue, $moduleId);
        $moduleSettingService->method('getCollection')
            ->with($name, $moduleId)
            ->willReturn($repositoryValue);

        $sut = $this->getSut(
            jsonService: $encoder,
            moduleSettingService: $moduleSettingService
        );

        $setting = $sut->changeCollectionSetting($name, $callValue, $moduleId);

        $this->assertEquals($name, $setting->getName());
        $this->assertSame($encoderResponse, $setting->getValue());
    }

    public function testListModuleSettings(): void
    {
        $shopId = 3;
        $moduleId = 'awesomeModule';

        $response = [
            (new Setting())->setName('intSetting')->setType(FieldType::NUMBER),
            (new Setting())->setName('stringSetting')->setType(FieldType::STRING),
            (new Setting())->setName('arraySetting')->setType(FieldType::ARRAY)
        ];

        $moduleConfigurationDao = $this->createMock(ModuleConfigurationDaoInterface::class);
        $moduleConfigurationDao->expects($this->once())
            ->method('get')
            ->with($moduleId, $shopId)
            ->willReturn(
                $this->createConfiguredMock(ModuleConfiguration::class, [
                    'getModuleSettings' => $response
                ])
            );

        $sut = $this->getSut(
            moduleConfigDao: $moduleConfigurationDao,
            context: $this->getContextMock(3)
        );

        $this->assertEquals($this->getSettingTypeList(), $sut->getSettingsList($moduleId));
    }

    private function getSut(
        ?CollectionEncodingServiceInterface $jsonService = null,
        ?ModuleSettingServiceInterface $moduleSettingService = null,
        ?ModuleConfigurationDaoInterface $moduleConfigDao = null,
        ?ContextInterface $context = null,
    ): ModuleSettingService {
        return new ModuleSettingService(
            jsonService: $jsonService ?? $this->createStub(CollectionEncodingServiceInterface::class),
            moduleSettingService: $moduleSettingService ?? $this->createStub(ModuleSettingServiceInterface::class),
            moduleConfigurationDao: $moduleConfigDao ?? $this->createStub(ModuleConfigurationDaoInterface::class),
            context: $context ?? $this->createStub(ContextInterface::class),
        );
    }

    private function getShopModuleSettingServiceMethodStub(
        string $methodName,
        string $name,
        string $moduleId,
        mixed $shopServiceReturn
    ): ModuleSettingServiceInterface {
        $moduleSettingService = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingService->expects($this->once())
            ->method($methodName)
            ->with($name, $moduleId)
            ->willReturn($shopServiceReturn);
        return $moduleSettingService;
    }
}

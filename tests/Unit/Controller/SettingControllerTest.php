<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Controller\SettingController;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\SettingServiceInterface;
use PHPUnit\Framework\TestCase;
use TheCodingMachine\GraphQLite\Types\ID;

class SettingControllerTest extends TestCase
{
//    public function testGetModuleSettingIntegerOld(): void
//    {
//        $configName = new ID('awesomeIntegerConfig');
//
//        $setting = (new Setting())->setType(FieldType::NUMBER)
//            ->setName($configName->val())
//            ->setValue(4);
//
//        $moduleConfiguration = $this->createMock(ModuleConfiguration::class);
//        $moduleConfiguration->expects($this->once())
//            ->method('getModuleSetting')
//            ->willReturn($setting);
//
//        $moduleConfigurationDao = $this->createMock(ModuleConfigurationDaoInterface::class);
//        $moduleConfigurationDao->expects($this->once())
//            ->method('get')
//            ->willReturn($moduleConfiguration);
//
//        $context = $this->createMock(BasicContextInterface::class);
//        $context->expects($this->once())
//            ->method('getCurrentShopId')
//            ->willReturn(1);
//
//
//        $moduleRepository = new ModuleSettingRepository($moduleConfigurationDao, $context);
//        $settingService = new SettingService($moduleRepository);
//        $moduleSettingController = new SettingController($settingService);
//
//        $integerSetting = $moduleSettingController->getModuleSettingInteger($configName, 'awesomeModule');
//
//        $this->assertInstanceOf(IntegerSetting::class, $integerSetting);
//        $this->assertSame(4, $integerSetting->getValue());
//        $this->assertSame($configName->val(), $integerSetting->getName());
//    }

    public function testGetModuleSettingInteger(): void
    {
        $serviceIntegerSetting = new IntegerSetting('integerSetting', '', 123);

        $settingService = $this->createMock(SettingServiceInterface::class);
        $settingService->expects($this->once())
            ->method('getModuleIntegerSetting')
            ->willReturn($serviceIntegerSetting);

        $settingController = new SettingController($settingService);

        $nameID = new ID('integerSetting');
        $integerSetting = $settingController->getModuleSettingInteger($nameID, 'awesomeModule');

        $this->assertSame($serviceIntegerSetting, $integerSetting);
    }

}

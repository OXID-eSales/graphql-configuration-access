<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Config\Utility\ShopSettingEncoderInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\Base\Exception\NotFound;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepository;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use TheCodingMachine\GraphQLite\Types\ID;

class ChangeThemeSettingRepositoryTest extends UnitTestCase
{
    public function testChangeThemeSettingInteger(): void
    {
        $nameID = new ID('integerSetting');
        $settingEncoder = $this->createMock(ShopSettingEncoderInterface::class);
        $settingEncoder->expects($this->once())
            ->method('encode')
            ->with(FieldType::NUMBER, 123)
            ->willReturn(123);

        $repository = $this->getMockBuilder(ThemeSettingRepository::class)
            ->setConstructorArgs([
                $this->createMock(BasicContextInterface::class),
                $this->createMock(EventDispatcherInterface::class),
                $this->createMock(QueryBuilderFactoryInterface::class),
                $settingEncoder
            ])
            ->onlyMethods(['saveSettingValue'])
            ->getMock();
        $repository->expects($this->once())
            ->method('saveSettingValue')
            ->with($nameID, 'awesomeTheme', '123');

        $repository->saveIntegerSetting($nameID, 123, 'awesomeTheme');
    }

    public function testChangeNoThemeSettingInteger(): void
    {
        $nameID = new ID('NotExistingSetting');
        $settingEncoder = $this->createMock(ShopSettingEncoderInterface::class);
        $settingEncoder->expects($this->once())
            ->method('encode')
            ->with(FieldType::NUMBER, 123)
            ->willReturn(123);
        $repository = $this->getMockBuilder(ThemeSettingRepository::class)
            ->setConstructorArgs([
                $this->createMock(BasicContextInterface::class),
                $this->createMock(EventDispatcherInterface::class),
                $this->createMock(QueryBuilderFactoryInterface::class),
                $settingEncoder
            ])
            ->onlyMethods(['saveSettingValue'])
            ->getMock();
        $repository->expects($this->once())
            ->method('saveSettingValue')
            ->with($nameID, 'awesomeTheme', '123')
            ->willThrowException(new NotFound());

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The integer setting "' . $nameID->val() . '" doesn\'t exist');

        $repository->saveIntegerSetting($nameID, 123, 'awesomeTheme');
    }
}

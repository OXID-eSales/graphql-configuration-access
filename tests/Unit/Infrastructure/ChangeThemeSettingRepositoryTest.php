<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Config\Utility\ShopSettingEncoderInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\Base\Exception\NotFound;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepository;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use TheCodingMachine\GraphQLite\Types\ID;

class ChangeThemeSettingRepositoryTest extends UnitTestCase
{
    public function testChangeThemeSettingInteger(): void
    {
        $nameID = new ID('integerSetting');

        $settingEncoder = $this->getShopSettingEncoderMock(
            FieldType::NUMBER,
            123,
            123
        );
        $repository = $this->getSut(settingEncoder: $settingEncoder);
        $repository->expects($this->once())
            ->method('saveSettingValue')
            ->with($nameID, 'awesomeTheme', '123');

        $repository->saveIntegerSetting($nameID, 123, 'awesomeTheme');
    }

    public function testChangeThemeSettingFloat(): void
    {
        $nameID = new ID('floatSetting');

        $settingEncoder = $this->getShopSettingEncoderMock(
            FieldType::NUMBER,
            1.23,
            1.23
        );
        $repository = $this->getSut(settingEncoder: $settingEncoder);
        $repository->expects($this->once())
            ->method('saveSettingValue')
            ->with($nameID, 'awesomeTheme', '1.23');

        $repository->saveFloatSetting($nameID, 1.23, 'awesomeTheme');
    }

    public function testChangeThemeSettingBoolean(): void
    {
        $nameID = new ID('booleanSetting');

        $settingEncoder = $this->getShopSettingEncoderMock(
            FieldType::BOOLEAN,
            false,
            ''
        );
        $repository = $this->getSut(settingEncoder: $settingEncoder);
        $repository->expects($this->once())
            ->method('saveSettingValue')
            ->with($nameID, 'awesomeTheme', '');

        $repository->saveBooleanSetting($nameID, false, 'awesomeTheme');
    }

    public function getShopSettingEncoderMock(
        string $fieldType,
        mixed $decodedValue,
        mixed $encodedValue
    ): ShopSettingEncoderInterface|MockObject {
        $settingEncoder = $this->createMock(ShopSettingEncoderInterface::class);
        $settingEncoder->expects($this->once())
            ->method('encode')
            ->with($fieldType, $decodedValue)
            ->willReturn($encodedValue);
        return $settingEncoder;
    }

    public function getSut(
        ?BasicContextInterface $basicContext = null,
        ?EventDispatcherInterface $eventDispatcher = null,
        ?QueryBuilderFactoryInterface $queryBuilderFactory = null,
        ?ShopSettingEncoderInterface $settingEncoder = null
    ): MockObject|ThemeSettingRepository {
        $repository = $this->getMockBuilder(ThemeSettingRepository::class)
            ->setConstructorArgs([
                $basicContext ?? $this->createMock(BasicContextInterface::class),
                $eventDispatcher ?? $this->createMock(EventDispatcherInterface::class),
                $queryBuilderFactory ?? $this->createMock(QueryBuilderFactoryInterface::class),
                $settingEncoder ?? $this->createMock(ShopSettingEncoderInterface::class)
            ])
            ->onlyMethods(['saveSettingValue'])
            ->getMock();
        return $repository;
    }
}

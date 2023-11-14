<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\InvalidCollection;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepositoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\JsonServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ThemeSettingService;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use TheCodingMachine\GraphQLite\Types\ID;

class ThemeSettingServiceTest extends UnitTestCase
{
    public function testGetThemeSettingInteger(): void
    {
        $serviceIntegerSetting = $this->getIntegerSetting();

        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getInteger')
            ->willReturn(123);

        $settingService = $this->getSut(themeSettingRepository: $repository);

        $nameID = new ID('integerSetting');
        $integerSetting = $settingService->getIntegerSetting($nameID, 'awesomeTheme');

        $this->assertEquals($serviceIntegerSetting, $integerSetting);
    }

    public function testGetThemeSettingFloat(): void
    {
        $serviceFloatSetting = $this->getFloatSetting();

        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getFloat')
            ->willReturn(1.23);

        $settingService = $this->getSut(themeSettingRepository: $repository);

        $nameID = new ID('floatSetting');
        $floatSetting = $settingService->getFloatSetting($nameID, 'awesomeTheme');

        $this->assertEquals($serviceFloatSetting, $floatSetting);
    }

    public function testGetThemeSettingBoolean(): void
    {
        $serviceBooleanSetting = $this->getNegativeBooleanSetting();

        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getBoolean')
            ->willReturn(false);

        $settingService = $this->getSut(themeSettingRepository: $repository);

        $nameID = new ID('booleanSetting');
        $booleanSetting = $settingService->getBooleanSetting($nameID, 'awesomeTheme');

        $this->assertEquals($serviceBooleanSetting, $booleanSetting);
    }

    public function testGetThemeSettingString(): void
    {
        $serviceStringSetting = $this->getStringSetting();

        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getString')
            ->willReturn('default');

        $settingService = $this->getSut(themeSettingRepository: $repository);

        $nameID = new ID('stringSetting');
        $stringSetting = $settingService->getStringSetting($nameID, 'awesomeTheme');

        $this->assertEquals($serviceStringSetting, $stringSetting);
    }

    public function testGetThemeSettingSelect(): void
    {
        $serviceSelectSetting = $this->getSelectSetting();

        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getSelect')
            ->willReturn('select');

        $settingService = $this->getSut(themeSettingRepository: $repository);

        $nameID = new ID('selectSetting');
        $selectSetting = $settingService->getSelectSetting($nameID, 'awesomeTheme');

        $this->assertEquals($serviceSelectSetting, $selectSetting);
    }

    public function testGetThemeSettingCollection(): void
    {
        $nameID = new ID('arraySetting');
        $themeId = 'awesomeTheme';

        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $repositoryResult = ['nice', 'values'];
        $repository->expects($this->once())
            ->method('getCollection')
            ->with($nameID, $themeId)
            ->willReturn($repositoryResult);

        $jsonService = $this->createMock(JsonServiceInterface::class);
        $collectionEncodingResult = 'someEncodedResult';
        $jsonService->method('jsonEncodeArray')
            ->with($repositoryResult)
            ->willReturn($collectionEncodingResult);

        $sut = $this->getSut(
            themeSettingRepository: $repository,
            jsonService: $jsonService,
        );

        $this->assertEquals(
            new StringSetting($nameID, $collectionEncodingResult),
            $sut->getCollectionSetting($nameID, $themeId)
        );
    }

    public function testGetThemeSettingAssocCollection(): void
    {
        $nameID = new ID('aarraySetting');
        $themeId = 'awesomeTheme';

        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $repositoryResult = ['first' => '10', 'second' => '20', 'third' => '50'];
        $repository->expects($this->once())
            ->method('getAssocCollection')
            ->with($nameID, $themeId)
            ->willReturn($repositoryResult);

        $jsonService = $this->createMock(JsonServiceInterface::class);
        $collectionEncodingResult = 'someEncodedResult';
        $jsonService->method('jsonEncodeArray')
            ->with($repositoryResult)
            ->willReturn($collectionEncodingResult);

        $sut = $this->getSut(
            themeSettingRepository: $repository,
            jsonService: $jsonService
        );

        $this->assertEquals(
            new StringSetting($nameID, $collectionEncodingResult),
            $sut->getAssocCollectionSetting($nameID, $themeId)
        );
    }

    public function testListThemeSettings(): void
    {
        $themeId = 'awesomeTheme';

        $repositorySettingsList = [
            'intSetting' => FieldType::NUMBER,
            'stringSetting' => FieldType::STRING,
            'arraySetting' => FieldType::ARRAY
        ];
        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getSettingsList')
            ->with($themeId)
            ->willReturn($repositorySettingsList);

        $sut = $this->getSut(themeSettingRepository: $repository);
        $this->assertEquals($this->getSettingTypeList(), $sut->getSettingsList($themeId));
    }

    public function testChangeThemeSettingInteger(): void
    {
        $nameID = new ID('intSetting');
        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getInteger')
            ->with($nameID, 'awesomeTheme')
            ->willReturn(123);

        $settingService = $this->getSut(themeSettingRepository: $repository);

        $integerSetting = $settingService->changeIntegerSetting($nameID, 123, 'awesomeTheme');

        $this->assertSame($nameID, $integerSetting->getName());
        $this->assertSame(123, $integerSetting->getValue());
    }

    public function testChangeThemeSettingFloat(): void
    {
        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);

        $settingService = $this->getSut(themeSettingRepository: $repository);

        $nameID = new ID('floatSetting');
        $floatSetting = $settingService->changeFloatSetting($nameID, 1.23, 'awesomeTheme');

        $this->assertSame($nameID, $floatSetting->getName());
        $this->assertSame(1.23, $floatSetting->getValue());
    }

    public function testChangeThemeSettingBoolean(): void
    {
        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);

        $settingService = $this->getSut(themeSettingRepository: $repository);

        $nameID = new ID('boolSetting');
        $value = false;
        $booleanSetting = $settingService->changeBooleanSetting($nameID, $value, 'awesomeTheme');

        $this->assertSame($nameID, $booleanSetting->getName());
        $this->assertSame($value, $booleanSetting->getValue());
    }

    public function testChangeThemeSettingString(): void
    {
        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);

        $settingService = $this->getSut(themeSettingRepository: $repository);

        $nameID = new ID('stringSetting');
        $value = 'default';
        $stringSetting = $settingService->changeStringSetting($nameID, $value, 'awesomeTheme');

        $this->assertSame($nameID, $stringSetting->getName());
        $this->assertSame($value, $stringSetting->getValue());
    }

    /**
     * @dataProvider invalidCollectionDataProvider
     */
    public function testChangeThemeSettingInvalidCollection($value): void
    {
        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);

        $settingService = $this->getSut(themeSettingRepository: $repository);

        $nameID = new ID('collectionSetting');

        $this->expectException(InvalidCollection::class);
        $this->expectExceptionMessage(sprintf('%s is not a valid collection string.', $value));

        $settingService->changeCollectionSetting($nameID, $value, 'awesomeTheme');
    }

    public function invalidCollectionDataProvider(): array
    {
        return [
            ['[2, "values"'],
            ['{2, "values"}'],
            ['2, "values"}'],
            ['[2, values]'],
            ['"3, interesting, values"'],
            ['"3, \'interesting\', \'values\'"'],
        ];
    }

    public function testChangeThemeSettingCollection(): void
    {
        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);

        $settingService = $this->getSut(themeSettingRepository: $repository);

        $nameID = new ID('collectionSetting');
        $value = '[2, "values"]';
        $collectionSetting = $settingService->changeCollectionSetting($nameID, $value, 'awesomeTheme');

        $this->assertSame($nameID, $collectionSetting->getName());
        $this->assertSame($value, $collectionSetting->getValue());
    }

    public function getSut(
        ?ThemeSettingRepositoryInterface $themeSettingRepository = null,
        ?JsonServiceInterface $jsonService = null,
    ): ThemeSettingService {
        return new ThemeSettingService(
            themeSettingRepository: $themeSettingRepository ?? $this->createStub(ThemeSettingRepositoryInterface::class),
            jsonService: $jsonService ?? $this->createStub(JsonServiceInterface::class)
        );
    }
}

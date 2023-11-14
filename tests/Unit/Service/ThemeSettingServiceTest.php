<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
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
        $nameID = new ID('integerSetting');
        $themeId = 'awesomeTheme';

        $repositoryResult = 123;
        $sut = $this->getSut(
            themeSettingRepository: $this->getRepositorySettingGetterMock(
                'getInteger',
                $nameID,
                $themeId,
                $repositoryResult
            )
        );

        $this->assertEquals(
            new IntegerSetting($nameID, $repositoryResult),
            $sut->getIntegerSetting($nameID, $themeId)
        );
    }

    public function testGetThemeSettingFloat(): void
    {
        $nameID = new ID('floatSetting');
        $themeId = 'awesomeTheme';

        $repositoryResult = 1.23;
        $sut = $this->getSut(
            themeSettingRepository: $this->getRepositorySettingGetterMock(
                'getFloat',
                $nameID,
                $themeId,
                $repositoryResult
            )
        );

        $this->assertEquals(
            new FloatSetting($nameID, $repositoryResult),
            $sut->getFloatSetting($nameID, $themeId)
        );
    }

    public function testGetThemeSettingBoolean(): void
    {
        $nameID = new ID('booleanSetting');
        $themeId = 'awesomeTheme';

        $repositoryResult = false;
        $sut = $this->getSut(
            themeSettingRepository: $this->getRepositorySettingGetterMock(
                'getBoolean',
                $nameID,
                $themeId,
                $repositoryResult
            )
        );

        $this->assertEquals(
            new BooleanSetting($nameID, $repositoryResult),
            $sut->getBooleanSetting($nameID, $themeId)
        );
    }

    public function testGetThemeSettingString(): void
    {
        $nameID = new ID('stringSetting');
        $themeId = 'awesomeTheme';

        $repositoryResult = 'default';
        $sut = $this->getSut(
            themeSettingRepository: $this->getRepositorySettingGetterMock(
                'getString',
                $nameID,
                $themeId,
                $repositoryResult
            )
        );

        $this->assertEquals(
            new StringSetting($nameID, $repositoryResult),
            $sut->getStringSetting($nameID, $themeId)
        );
    }

    public function testGetThemeSettingSelect(): void
    {
        $nameID = new ID('selectSetting');
        $themeId = 'awesomeTheme';

        $repositoryResult = 'select';
        $sut = $this->getSut(
            themeSettingRepository: $this->getRepositorySettingGetterMock(
                'getSelect',
                $nameID,
                $themeId,
                $repositoryResult
            )
        );

        $this->assertEquals(
            new StringSetting($nameID, $repositoryResult),
            $sut->getSelectSetting($nameID, $themeId)
        );
    }

    public function testGetThemeSettingCollection(): void
    {
        $nameID = new ID('arraySetting');
        $themeId = 'awesomeTheme';

        $repositoryResult = ['nice', 'values'];
        $collectionEncodingResult = 'someEncodedResult';

        $sut = $this->getSut(
            themeSettingRepository: $this->getRepositorySettingGetterMock(
                'getCollection',
                $nameID,
                $themeId,
                $repositoryResult
            ),
            jsonService: $this->getJsonEncodeServiceMock($repositoryResult, $collectionEncodingResult),
        );

        $this->assertEquals(
            new StringSetting($nameID, $collectionEncodingResult),
            $sut->getCollectionSetting($nameID, $themeId)
        );
    }

    public function testGetThemeSettingAssocCollectionGetsAndEncodesRepositoryResult(): void
    {
        $nameID = new ID('aarraySetting');
        $themeId = 'awesomeTheme';

        $repositoryResult = ['first' => '10', 'second' => '20', 'third' => '50'];
        $collectionEncodingResult = 'someEncodedResult';

        $sut = $this->getSut(
            themeSettingRepository: $this->getRepositorySettingGetterMock(
                'getAssocCollection',
                $nameID,
                $themeId,
                $repositoryResult
            ),
            jsonService: $this->getJsonEncodeServiceMock($repositoryResult, $collectionEncodingResult)
        );

        $this->assertEquals(
            new StringSetting($nameID, $collectionEncodingResult),
            $sut->getAssocCollectionSetting($nameID, $themeId)
        );
    }

    private function getRepositorySettingGetterMock(
        string $repositoryMethod,
        ID $nameID,
        string $themeId,
        $repositoryResult
    ): ThemeSettingRepositoryInterface {
        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method($repositoryMethod)
            ->with($nameID, $themeId)
            ->willReturn($repositoryResult);
        return $repository;
    }

    private function getJsonEncodeServiceMock(
        array $repositoryResult,
        string $collectionEncodingResult
    ): JsonServiceInterface {
        $jsonService = $this->createMock(JsonServiceInterface::class);
        $jsonService->method('jsonEncodeArray')
            ->with($repositoryResult)
            ->willReturn($collectionEncodingResult);
        return $jsonService;
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
            themeSettingRepository: $themeSettingRepository ?? $this->createStub(
            ThemeSettingRepositoryInterface::class
        ),
            jsonService: $jsonService ?? $this->createStub(JsonServiceInterface::class)
        );
    }
}

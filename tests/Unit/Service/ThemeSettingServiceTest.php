<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Exception\InvalidCollectionException;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepositoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\JsonServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ThemeSettingService;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use TheCodingMachine\GraphQLite\Types\ID;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Setting\Service\ThemeSettingService
 */
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
    ): ThemeSettingRepositoryInterface|MockObject {
        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method($repositoryMethod)
            ->with($nameID, $themeId)
            ->willReturn($repositoryResult);
        return $repository;
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
        $themeID = 'awesomeTheme';
        $setterValue = 123;
        $getterValue = 124;
        $repository = $this->getRepositorySettingGetterMock(
            'getInteger',
            $nameID,
            $themeID,
            $getterValue
        );
        $repository->expects($this->once())
            ->method('saveIntegerSetting')
            ->with($nameID, $setterValue, $themeID);

        $settingService = $this->getSut(themeSettingRepository: $repository);
        $integerSetting = $settingService->changeIntegerSetting($nameID, $setterValue, $themeID);

        $this->assertSame($nameID, $integerSetting->getName());
        $this->assertSame($getterValue, $integerSetting->getValue());
    }

    public function testChangeThemeSettingFloat(): void
    {
        $nameID = new ID('floatSetting');
        $themeID = 'awesomeTheme';
        $setterValue = 1.23;
        $getterValue = 1.24;
        $repository = $this->getRepositorySettingGetterMock(
            'getFloat',
            $nameID,
            $themeID,
            $getterValue
        );
        $repository->expects($this->once())
            ->method('saveFloatSetting')
            ->with($nameID, $setterValue, $themeID);

        $settingService = $this->getSut(themeSettingRepository: $repository);
        $floatSetting = $settingService->changeFloatSetting($nameID, $setterValue, $themeID);

        $this->assertSame($nameID, $floatSetting->getName());
        $this->assertSame($getterValue, $floatSetting->getValue());
    }

    public function testChangeThemeSettingBoolean(): void
    {
        $nameID = new ID('boolSetting');
        $themeID = 'awesomeTheme';
        $setterValue = true;
        $getterValue = false;
        $repository = $this->getRepositorySettingGetterMock(
            'getBoolean',
            $nameID,
            $themeID,
            $getterValue
        );
        $repository->expects($this->once())
            ->method('saveBooleanSetting')
            ->with($nameID, $setterValue, $themeID);

        $settingService = $this->getSut(themeSettingRepository: $repository);

        $booleanSetting = $settingService->changeBooleanSetting($nameID, $setterValue, $themeID);

        $this->assertSame($nameID, $booleanSetting->getName());
        $this->assertSame($getterValue, $booleanSetting->getValue());
    }

    public function testChangeThemeSettingString(): void
    {
        $nameID = new ID('stringSetting');
        $setterValue = 'default';
        $getterValue = 'otherValue';
        $themeID = 'awesomeTheme';
        $repository = $this->getRepositorySettingGetterMock(
            'getString',
            $nameID,
            $themeID,
            $getterValue
        );
        $repository->expects($this->once())
            ->method('saveStringSetting')
            ->with($nameID, $setterValue, $themeID);

        $settingService = $this->getSut(themeSettingRepository: $repository);

        $stringSetting = $settingService->changeStringSetting($nameID, $setterValue, $themeID);

        $this->assertSame($nameID, $stringSetting->getName());
        $this->assertSame($getterValue, $stringSetting->getValue());
    }

    public function testChangeThemeSettingSelect(): void
    {
        $nameID = new ID('selectSetting');
        $setterValue = 'select';
        $getterValue = 'otherValue';
        $themeID = 'awesomeTheme';
        $repository = $this->getRepositorySettingGetterMock(
            'getSelect',
            $nameID,
            $themeID,
            $getterValue
        );
        $repository->expects($this->once())
            ->method('saveSelectSetting')
            ->with($nameID, $setterValue, $themeID);

        $settingService = $this->getSut(themeSettingRepository: $repository);

        $selectSetting = $settingService->changeSelectSetting($nameID, $setterValue, $themeID);

        $this->assertSame($nameID, $selectSetting->getName());
        $this->assertSame($getterValue, $selectSetting->getValue());
    }

    /**
     * @dataProvider invalidCollectionDataProvider
     */
    public function testChangeThemeSettingInvalidCollection($value): void
    {
        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $settingService = $this->getSut(themeSettingRepository: $repository);
        $nameID = new ID('collectionSetting');

        $this->expectException(InvalidCollectionException::class);
        $this->expectExceptionMessage(sprintf('%s is not a valid collection string.', $value));

        $settingService->changeCollectionSetting($nameID, $value, 'awesomeTheme');
    }

    /**
     * @dataProvider invalidCollectionDataProvider
     */
    public function testChangeThemeSettingInvalidAssocCollection($value): void
    {
        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $settingService = $this->getSut(themeSettingRepository: $repository);
        $nameID = new ID('assocCollectionSetting');

        $this->expectException(InvalidCollectionException::class);
        $this->expectExceptionMessage(sprintf('%s is not a valid collection string.', $value));

        $settingService->changeAssocCollectionSetting($nameID, $value, 'awesomeTheme');
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
        $nameID = new ID('collectionSetting');
        $themeID = 'awesomeTheme';
        $getterCollection = [2, 'values'];
        $getterEncodedCollection = '[2, "values"]';
        $setterCollection = [2, 'new values'];
        $setterEncodedCollection = '[2, "new values"]';

        $repository = $this->getRepositorySettingGetterMock(
            'getCollection',
            $nameID,
            $themeID,
            $getterCollection
        );
        $repository->expects($this->once())
            ->method('saveCollectionSetting')
            ->with($nameID, $setterCollection, $themeID);
        $jsonService = $this->getJsonEncodeServiceMock($getterCollection, $getterEncodedCollection);

        $settingService = $this->getSut(themeSettingRepository: $repository, jsonService: $jsonService);
        $collectionSetting = $settingService->changeCollectionSetting($nameID, $setterEncodedCollection, $themeID);

        $this->assertSame($nameID, $collectionSetting->getName());
        $this->assertSame($getterEncodedCollection, $collectionSetting->getValue());
    }

    public function testChangeThemeSettingAssocCollection(): void
    {
        $nameID = new ID('assocCollectionSetting');
        $themeID = 'awesomeTheme';
        $getterCollection = ['first' => 2, 'second' => 'values', 'third' => 'nicevalue'];
        $getterEncodedCollection = '{"first":2,"second":"values","third":"nicevalue"}';
        $setterCollection = ['first' => 2, 'second' => 'values'];
        $setterEncodedCollection = '{"first":2,"second":"values"}';

        $repository = $this->getRepositorySettingGetterMock(
            'getAssocCollection',
            $nameID,
            $themeID,
            $getterCollection
        );
        $repository->expects($this->once())
            ->method('saveAssocCollectionSetting')
            ->with($nameID, $setterCollection, $themeID);
        $jsonService = $this->getJsonEncodeServiceMock($getterCollection, $getterEncodedCollection);

        $settingService = $this->getSut(themeSettingRepository: $repository, jsonService: $jsonService);
        $collectionSetting = $settingService->changeAssocCollectionSetting($nameID, $setterEncodedCollection, $themeID);

        $this->assertSame($nameID, $collectionSetting->getName());
        $this->assertSame($getterEncodedCollection, $collectionSetting->getValue());
    }

    private function getSut(
        ?ThemeSettingRepositoryInterface $themeSettingRepository = null,
        ?JsonServiceInterface $jsonService = null,
    ): ThemeSettingService {
        $themeSettingRepository = $themeSettingRepository ?? $this->createStub(ThemeSettingRepositoryInterface::class);
        return new ThemeSettingService(
            themeSettingRepository: $themeSettingRepository,
            jsonService: $jsonService ?? $this->createStub(JsonServiceInterface::class)
        );
    }
}

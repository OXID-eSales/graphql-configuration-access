<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Theme\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Exception\InvalidCollectionException;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\CollectionEncodingServiceInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeSettingRepositoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeSettingService;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeSettingService
 */
class ThemeSettingServiceTest extends UnitTestCase
{
    public function testGetThemeSettingInteger(): void
    {
        $name = 'integerSetting';
        $themeId = 'awesomeTheme';

        $repositoryResult = 123;
        $sut = $this->getSut(
            themeSettingRepository: $this->getRepositorySettingGetterMock(
                'getInteger',
                $name,
                $themeId,
                $repositoryResult
            )
        );

        $this->assertEquals(
            new IntegerSetting($name, $repositoryResult),
            $sut->getIntegerSetting($name, $themeId)
        );
    }

    public function testGetThemeSettingFloat(): void
    {
        $name = 'floatSetting';
        $themeId = 'awesomeTheme';

        $repositoryResult = 1.23;
        $sut = $this->getSut(
            themeSettingRepository: $this->getRepositorySettingGetterMock(
                'getFloat',
                $name,
                $themeId,
                $repositoryResult
            )
        );

        $this->assertEquals(
            new FloatSetting($name, $repositoryResult),
            $sut->getFloatSetting($name, $themeId)
        );
    }

    public function testGetThemeSettingBoolean(): void
    {
        $name = 'booleanSetting';
        $themeId = 'awesomeTheme';

        $repositoryResult = false;
        $sut = $this->getSut(
            themeSettingRepository: $this->getRepositorySettingGetterMock(
                'getBoolean',
                $name,
                $themeId,
                $repositoryResult
            )
        );

        $this->assertEquals(
            new BooleanSetting($name, $repositoryResult),
            $sut->getBooleanSetting($name, $themeId)
        );
    }

    public function testGetThemeSettingString(): void
    {
        $name = 'stringSetting';
        $themeId = 'awesomeTheme';

        $repositoryResult = 'default';
        $sut = $this->getSut(
            themeSettingRepository: $this->getRepositorySettingGetterMock(
                'getString',
                $name,
                $themeId,
                $repositoryResult
            )
        );

        $this->assertEquals(
            new StringSetting($name, $repositoryResult),
            $sut->getStringSetting($name, $themeId)
        );
    }

    public function testGetThemeSettingSelect(): void
    {
        $name = 'selectSetting';
        $themeId = 'awesomeTheme';

        $repositoryResult = 'select';
        $sut = $this->getSut(
            themeSettingRepository: $this->getRepositorySettingGetterMock(
                'getSelect',
                $name,
                $themeId,
                $repositoryResult
            )
        );

        $this->assertEquals(
            new StringSetting($name, $repositoryResult),
            $sut->getSelectSetting($name, $themeId)
        );
    }

    public function testGetThemeSettingCollection(): void
    {
        $name = 'arraySetting';
        $themeId = 'awesomeTheme';

        $repositoryResult = ['nice', 'values'];
        $collectionEncodingResult = 'someEncodedResult';

        $sut = $this->getSut(
            themeSettingRepository: $this->getRepositorySettingGetterMock(
                'getCollection',
                $name,
                $themeId,
                $repositoryResult
            ),
            jsonService: $this->getJsonEncodeServiceMock($repositoryResult, $collectionEncodingResult),
        );

        $this->assertEquals(
            new StringSetting($name, $collectionEncodingResult),
            $sut->getCollectionSetting($name, $themeId)
        );
    }

    public function testGetThemeSettingAssocCollectionGetsAndEncodesRepositoryResult(): void
    {
        $name = 'aarraySetting';
        $themeId = 'awesomeTheme';

        $repositoryResult = ['first' => '10', 'second' => '20', 'third' => '50'];
        $collectionEncodingResult = 'someEncodedResult';

        $sut = $this->getSut(
            themeSettingRepository: $this->getRepositorySettingGetterMock(
                'getAssocCollection',
                $name,
                $themeId,
                $repositoryResult
            ),
            jsonService: $this->getJsonEncodeServiceMock($repositoryResult, $collectionEncodingResult)
        );

        $this->assertEquals(
            new StringSetting($name, $collectionEncodingResult),
            $sut->getAssocCollectionSetting($name, $themeId)
        );
    }

    private function getRepositorySettingGetterMock(
        string $repositoryMethod,
        string $name,
        string $themeId,
        $repositoryResult
    ): ThemeSettingRepositoryInterface|MockObject {
        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $repository->expects($this->once())
            ->method($repositoryMethod)
            ->with($name, $themeId)
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
        $name = 'intSetting';
        $themeID = 'awesomeTheme';
        $setterValue = 123;
        $getterValue = 124;

        $repository = $this->getRepositorySettingGetterMock(
            'getInteger',
            $name,
            $themeID,
            $getterValue
        );
        $repository->expects($this->once())
            ->method('saveIntegerSetting')
            ->with($name, $setterValue, $themeID);

        $settingService = $this->getSut(themeSettingRepository: $repository);
        $integerSetting = $settingService->changeIntegerSetting($name, $setterValue, $themeID);

        $this->assertEquals($name, $integerSetting->getName());
        $this->assertSame($getterValue, $integerSetting->getValue());
    }

    public function testChangeThemeSettingFloat(): void
    {
        $name = 'floatSetting';
        $themeID = 'awesomeTheme';
        $setterValue = 1.23;
        $getterValue = 1.24;

        $repository = $this->getRepositorySettingGetterMock(
            'getFloat',
            $name,
            $themeID,
            $getterValue
        );
        $repository->expects($this->once())
            ->method('saveFloatSetting')
            ->with($name, $setterValue, $themeID);

        $settingService = $this->getSut(themeSettingRepository: $repository);
        $floatSetting = $settingService->changeFloatSetting($name, $setterValue, $themeID);

        $this->assertEquals($name, $floatSetting->getName());
        $this->assertSame($getterValue, $floatSetting->getValue());
    }

    public function testChangeThemeSettingBoolean(): void
    {
        $name = 'boolSetting';
        $themeID = 'awesomeTheme';
        $setterValue = true;
        $getterValue = false;

        $repository = $this->getRepositorySettingGetterMock(
            'getBoolean',
            $name,
            $themeID,
            $getterValue
        );
        $repository->expects($this->once())
            ->method('saveBooleanSetting')
            ->with($name, $setterValue, $themeID);

        $settingService = $this->getSut(themeSettingRepository: $repository);

        $booleanSetting = $settingService->changeBooleanSetting($name, $setterValue, $themeID);

        $this->assertEquals($name, $booleanSetting->getName());
        $this->assertSame($getterValue, $booleanSetting->getValue());
    }

    public function testChangeThemeSettingString(): void
    {
        $name = 'stringSetting';
        $setterValue = 'default';
        $getterValue = 'otherValue';
        $themeID = 'awesomeTheme';

        $repository = $this->getRepositorySettingGetterMock(
            'getString',
            $name,
            $themeID,
            $getterValue
        );
        $repository->expects($this->once())
            ->method('saveStringSetting')
            ->with($name, $setterValue, $themeID);

        $settingService = $this->getSut(themeSettingRepository: $repository);

        $stringSetting = $settingService->changeStringSetting($name, $setterValue, $themeID);

        $this->assertEquals($name, $stringSetting->getName());
        $this->assertSame($getterValue, $stringSetting->getValue());
    }

    public function testChangeThemeSettingSelect(): void
    {
        $name = 'selectSetting';
        $setterValue = 'select';
        $getterValue = 'otherValue';
        $themeID = 'awesomeTheme';
        $repository = $this->getRepositorySettingGetterMock(
            'getSelect',
            $name,
            $themeID,
            $getterValue
        );
        $repository->expects($this->once())
            ->method('saveSelectSetting')
            ->with($name, $setterValue, $themeID);

        $settingService = $this->getSut(themeSettingRepository: $repository);

        $selectSetting = $settingService->changeSelectSetting($name, $setterValue, $themeID);

        $this->assertEquals($name, $selectSetting->getName());
        $this->assertSame($getterValue, $selectSetting->getValue());
    }

    /**
     * @dataProvider invalidCollectionDataProvider
     */
    public function testChangeThemeSettingInvalidCollection($value): void
    {
        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $settingService = $this->getSut(themeSettingRepository: $repository);
        $name = 'collectionSetting';

        $this->expectException(InvalidCollectionException::class);
        $this->expectExceptionMessage(sprintf('%s is not a valid collection string.', $value));

        $settingService->changeCollectionSetting($name, $value, 'awesomeTheme');
    }

    /**
     * @dataProvider invalidCollectionDataProvider
     */
    public function testChangeThemeSettingInvalidAssocCollection($value): void
    {
        $repository = $this->createMock(ThemeSettingRepositoryInterface::class);
        $settingService = $this->getSut(themeSettingRepository: $repository);
        $name = 'assocCollectionSetting';

        $this->expectException(InvalidCollectionException::class);
        $this->expectExceptionMessage(sprintf('%s is not a valid collection string.', $value));

        $settingService->changeAssocCollectionSetting($name, $value, 'awesomeTheme');
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
        $name = 'collectionSetting';
        $themeID = 'awesomeTheme';
        $getterCollection = [2, 'values'];
        $getterEncodedCollection = '[2, "values"]';
        $setterCollection = [2, 'new values'];
        $setterEncodedCollection = '[2, "new values"]';

        $repository = $this->getRepositorySettingGetterMock(
            'getCollection',
            $name,
            $themeID,
            $getterCollection
        );
        $repository->expects($this->once())
            ->method('saveCollectionSetting')
            ->with($name, $setterCollection, $themeID);
        $jsonService = $this->getJsonEncodeServiceMock($getterCollection, $getterEncodedCollection);

        $settingService = $this->getSut(themeSettingRepository: $repository, jsonService: $jsonService);
        $collectionSetting = $settingService->changeCollectionSetting($name, $setterEncodedCollection, $themeID);

        $this->assertEquals($name, $collectionSetting->getName());
        $this->assertSame($getterEncodedCollection, $collectionSetting->getValue());
    }

    public function testChangeThemeSettingAssocCollection(): void
    {
        $name = 'assocCollectionSetting';
        $themeID = 'awesomeTheme';
        $getterCollection = ['first' => 2, 'second' => 'values', 'third' => 'nicevalue'];
        $getterEncodedCollection = '{"first":2,"second":"values","third":"nicevalue"}';
        $setterCollection = ['first' => 2, 'second' => 'values'];
        $setterEncodedCollection = '{"first":2,"second":"values"}';

        $repository = $this->getRepositorySettingGetterMock(
            'getAssocCollection',
            $name,
            $themeID,
            $getterCollection
        );
        $repository->expects($this->once())
            ->method('saveAssocCollectionSetting')
            ->with($name, $setterCollection, $themeID);
        $jsonService = $this->getJsonEncodeServiceMock($getterCollection, $getterEncodedCollection);

        $settingService = $this->getSut(themeSettingRepository: $repository, jsonService: $jsonService);
        $collectionSetting = $settingService->changeAssocCollectionSetting($name, $setterEncodedCollection, $themeID);

        $this->assertEquals($name, $collectionSetting->getName());
        $this->assertSame($getterEncodedCollection, $collectionSetting->getValue());
    }

    private function getSut(
        ?ThemeSettingRepositoryInterface $themeSettingRepository = null,
        ?CollectionEncodingServiceInterface $jsonService = null,
    ): ThemeSettingService {
        $themeSettingRepository = $themeSettingRepository ?? $this->createStub(ThemeSettingRepositoryInterface::class);
        return new ThemeSettingService(
            themeSettingRepository: $themeSettingRepository,
            jsonService: $jsonService ?? $this->createStub(CollectionEncodingServiceInterface::class)
        );
    }
}

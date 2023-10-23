<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use Doctrine\DBAL\ForwardCompatibility\Result;
use Doctrine\DBAL\Query\QueryBuilder;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\GraphQL\Base\Exception\NotFound;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepository;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use TheCodingMachine\GraphQLite\Types\ID;

class ThemeSettingRepositoryTest extends UnitTestCase
{
    public function testGetThemeSettingInteger(): void
    {
        $serviceIntegerSetting = $this->getIntegerSetting();
        $nameID = new ID('integerSetting');

        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('123');

        $repository = new ThemeSettingRepository($queryBuilderFactory);

        $integerSetting = $repository->getIntegerSetting($nameID, 'awesomeModule');

        $this->assertEquals($serviceIntegerSetting, $integerSetting);
    }

    public function testGetNoThemeSettingInteger(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock(False);

        $repository = new ThemeSettingRepository($queryBuilderFactory);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as an integer configuration');
        $repository->getIntegerSetting($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingInvalidInteger(): void
    {
        $nameID = new ID('floatSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('1.23');

        $repository = new ThemeSettingRepository($queryBuilderFactory);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as an integer configuration');
        $repository->getIntegerSetting($nameID, 'awesomeModule');
    }
    public function testGetThemeSettingFloat(): void
    {
        $serviceFloatSetting = $this->getFloatSetting();
        $nameID = new ID('floatSetting');

        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('1.23');

        $repository = new ThemeSettingRepository($queryBuilderFactory);

        $integerSetting = $repository->getFloatSetting($nameID, 'awesomeModule');

        $this->assertEquals($serviceFloatSetting, $integerSetting);
    }

    public function testGetNoThemeSettingFloat(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock(False);

        $repository = new ThemeSettingRepository($queryBuilderFactory);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a float configuration');
        $repository->getFloatSetting($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingInvalidFloat(): void
    {
        $nameID = new ID('intSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('123');

        $repository = new ThemeSettingRepository($queryBuilderFactory);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a float configuration');
        $repository->getFloatSetting($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingBooleanNegativ(): void
    {
        $serviceBooleanSetting = $this->getNegativBooleanSetting();
        $nameID = new ID('booleanSetting');

        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('');

        $repository = new ThemeSettingRepository($queryBuilderFactory);

        $booleanSetting = $repository->getBooleanSetting($nameID, 'awesomeModule');

        $this->assertEquals($serviceBooleanSetting, $booleanSetting);
    }

    public function testGetThemeSettingBooleanPositiv(): void
    {
        $serviceBooleanSetting = $this->getPositivBooleanSetting();
        $nameID = new ID('booleanSetting');

        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('1');

        $repository = new ThemeSettingRepository($queryBuilderFactory);

        $booleanSetting = $repository->getBooleanSetting($nameID, 'awesomeModule');

        $this->assertEquals($serviceBooleanSetting, $booleanSetting);
    }

    public function testGetNoThemeSettingBoolean(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock(False);

        $repository = new ThemeSettingRepository($queryBuilderFactory);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a boolean configuration');
        $repository->getBooleanSetting($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingString(): void
    {
        $serviceStringSetting = $this->getStringSetting();
        $nameID = new ID('stringSetting');

        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('default');

        $repository = new ThemeSettingRepository($queryBuilderFactory);

        $stringSetting = $repository->getStringSetting($nameID, 'awesomeModule');

        $this->assertEquals($serviceStringSetting, $stringSetting);
    }

    public function testGetNoThemeSettingString(): void
    {
        $nameID = new ID('NotExistingSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock(False);

        $repository = new ThemeSettingRepository($queryBuilderFactory);

        $this->expectException(NotFound::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as a string configuration');
        $repository->getStringSetting($nameID, 'awesomeModule');
    }

    /**
     * @param string|bool $returnedValue
     * @return QueryBuilderFactoryInterface|MockObject
     */
    public function getQueryBuilderFactoryMock(string|bool $returnedValue): QueryBuilderFactoryInterface|MockObject
    {
        $result = $this->createMock(Result::class);
        $result->expects($this->once())
            ->method('fetchOne')
            ->willReturn($returnedValue);
        $queryBuilder = $this->createPartialMock(QueryBuilder::class, ['execute']);
        $queryBuilder->expects($this->once())
            ->method('execute')
            ->willReturn($result);
        $queryBuilderFactory = $this->createMock(QueryBuilderFactoryInterface::class);
        $queryBuilderFactory->expects($this->once())
            ->method('create')
            ->willReturn($queryBuilder);
        return $queryBuilderFactory;
    }
}

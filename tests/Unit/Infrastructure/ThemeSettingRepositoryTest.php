<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use Doctrine\DBAL\ForwardCompatibility\Result;
use Doctrine\DBAL\Query\QueryBuilder;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepository;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use TheCodingMachine\GraphQLite\Types\ID;
use UnexpectedValueException;

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

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as an integer configuration');
        $repository->getIntegerSetting($nameID, 'awesomeModule');
    }

    public function testGetThemeSettingInvalidInteger(): void
    {
        $nameID = new ID('floatSetting');
        $queryBuilderFactory = $this->getQueryBuilderFactoryMock('1.23');

        $repository = new ThemeSettingRepository($queryBuilderFactory);

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('The queried name couldn\'t be found as an integer configuration');
        $repository->getIntegerSetting($nameID, 'awesomeModule');
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

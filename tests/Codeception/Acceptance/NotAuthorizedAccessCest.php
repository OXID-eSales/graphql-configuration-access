<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance;

use Codeception\Attribute\DataProvider;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\AcceptanceTester;

/**
 * @group theme_setting
 * @group setting_access
 * @group oe_graphql_configuration_access
 */
final class NotAuthorizedAccessCest extends BaseCest
{
    #[DataProvider('themeGettersDataProvider')]
    #[DataProvider('moduleGettersDataProvider')]
    #[DataProvider('shopGettersDataProvider')]
    public function testGetSettingNotAuthorizedQuery(AcceptanceTester $I, \Codeception\Example $example): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $result = $this->runSimplifiedAccessCheckQuery(
            I: $I,
            queryName: $example['queryName'],
            field: $example['field'],
            location: $example['location'],
            isList: false
        );

        $this->assertQueryNotFoundErrorInResult($I, $result);
    }

    #[DataProvider('listQueriesDataProvider')]
    public function testGetSettingNotAuthorizedQueryList(AcceptanceTester $I, \Codeception\Example $example): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $result = $this->runSimplifiedAccessCheckQuery(
            I: $I,
            queryName: $example['queryName'],
            field: $example['field'],
            location: $example['location'],
            isList: true
        );

        $this->assertQueryNotFoundErrorInResult($I, $result);
    }

    #[DataProvider('themeMutationsDataProvider')]
    #[DataProvider('moduleMutationsDataProvider')]
    #[DataProvider('shopMutationsDataProvider')]
    public function testGetSettingNotAuthorizedMutation(AcceptanceTester $I, \Codeception\Example $example): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $result = $this->runSimplifiedAccessCheckMutation(
            I: $I,
            queryName: $example['queryName'],
            field: $example['field'],
            value: $example['value'],
            location: $example['location']
        );

        $this->assertQueryNotFoundErrorInResult($I, $result);
    }

    protected function themeGettersDataProvider(): \Generator
    {
        yield ['queryName' => 'themeSettingInteger', 'field' => 'name', 'location' => 'theme'];
        yield ['queryName' => 'themeSettingFloat', 'field' => 'name', 'location' => 'theme'];
        yield ['queryName' => 'themeSettingBoolean', 'field' => 'name', 'location' => 'theme'];
        yield ['queryName' => 'themeSettingString', 'field' => 'name', 'location' => 'theme'];
        yield ['queryName' => 'themeSettingSelect', 'field' => 'name', 'location' => 'theme'];
        yield ['queryName' => 'themeSettingCollection', 'field' => 'name', 'location' => 'theme'];
        yield ['queryName' => 'themeSettingAssocCollection', 'field' => 'name', 'location' => 'theme'];
    }

    protected function themeMutationsDataProvider(): \Generator
    {
        yield ['queryName' => 'themeSettingIntegerChange', 'field' => 'name', 'value' => '1', 'location' => 'theme'];
        yield ['queryName' => 'themeSettingFloatChange', 'field' => 'name', 'value' => '1.1', 'location' => 'theme'];
        yield [
            'queryName' => 'themeSettingBooleanChange',
            'field' => 'name',
            'value' => 'false',
            'location' => 'theme'
        ];
        yield [
            'queryName' => 'themeSettingStringChange',
            'field' => 'name',
            'value' => '"test"',
            'location' => 'theme'
        ];
        yield [
            'queryName' => 'themeSettingSelectChange',
            'field' => 'name',
            'value' => '"test"',
            'location' => 'theme'
        ];
        yield [
            'queryName' => 'themeSettingCollectionChange',
            'field' => 'name',
            'value' => '"test"',
            'location' => 'theme'
        ];
        yield [
            'queryName' => 'themeSettingAssocCollectionChange',
            'field' => 'name',
            'value' => '"test"',
            'location' => 'theme'
        ];
    }

    protected function listQueriesDataProvider(): \Generator
    {
        yield ['queryName' => 'themeSettings', 'field' => 'name', 'location' => 'theme'];
        yield ['queryName' => 'moduleSettings', 'field' => 'name', 'location' => 'module'];
        yield ['queryName' => 'shopSettings', 'field' => 'name', 'location' => 'shop'];
    }

    protected function moduleGettersDataProvider(): \Generator
    {
        yield ['queryName' => 'moduleSettingInteger', 'field' => 'name', 'location' => 'module'];
        yield ['queryName' => 'moduleSettingFloat', 'field' => 'name', 'location' => 'module'];
        yield ['queryName' => 'moduleSettingBoolean', 'field' => 'name', 'location' => 'module'];
        yield ['queryName' => 'moduleSettingString', 'field' => 'name', 'location' => 'module'];
        yield ['queryName' => 'moduleSettingCollection', 'field' => 'name', 'location' => 'module'];
    }

    protected function moduleMutationsDataProvider(): \Generator
    {
        yield ['queryName' => 'moduleSettingIntegerChange', 'field' => 'name', 'value' => '1', 'location' => 'module'];
        yield ['queryName' => 'moduleSettingFloatChange', 'field' => 'name', 'value' => '1.1', 'location' => 'module'];
        yield [
            'queryName' => 'moduleSettingBooleanChange',
            'field' => 'name',
            'value' => 'false',
            'location' => 'module'
        ];
        yield [
            'queryName' => 'moduleSettingStringChange',
            'field' => 'name',
            'value' => '"test"',
            'location' => 'module'
        ];
        yield [
            'queryName' => 'moduleSettingCollectionChange',
            'field' => 'name',
            'value' => '"test"',
            'location' => 'module'
        ];
    }

    protected function shopGettersDataProvider(): \Generator
    {
        yield ['queryName' => 'shopSettingInteger', 'field' => 'name', 'location' => 'shop'];
        yield ['queryName' => 'shopSettingFloat', 'field' => 'name', 'location' => 'shop'];
        yield ['queryName' => 'shopSettingBoolean', 'field' => 'name', 'location' => 'shop'];
        yield ['queryName' => 'shopSettingString', 'field' => 'name', 'location' => 'shop'];
        yield ['queryName' => 'shopSettingSelect', 'field' => 'name', 'location' => 'shop'];
        yield ['queryName' => 'shopSettingCollection', 'field' => 'name', 'location' => 'shop'];
        yield ['queryName' => 'shopSettingAssocCollection', 'field' => 'name', 'location' => 'shop'];
    }

    protected function shopMutationsDataProvider(): \Generator
    {
        yield ['queryName' => 'shopSettingIntegerChange', 'field' => 'name', 'value' => '1', 'location' => 'shop'];
        yield ['queryName' => 'shopSettingFloatChange', 'field' => 'name', 'value' => '1.1', 'location' => 'shop'];
        yield ['queryName' => 'shopSettingBooleanChange', 'field' => 'name', 'value' => 'false', 'location' => 'shop'];
        yield ['queryName' => 'shopSettingStringChange', 'field' => 'name', 'value' => '"test"', 'location' => 'shop'];
        yield ['queryName' => 'shopSettingSelectChange', 'field' => 'name', 'value' => '"test"', 'location' => 'shop'];
        yield [
            'queryName' => 'shopSettingCollectionChange',
            'field' => 'name',
            'value' => '"test"',
            'location' => 'shop'
        ];
        yield [
            'queryName' => 'shopSettingAssocCollectionChange',
            'field' => 'name',
            'value' => '"test"',
            'location' => 'shop'
        ];
    }

    private function runSimplifiedAccessCheckQuery(
        AcceptanceTester $I,
        string $queryName,
        string $field,
        string $location,
        bool $isList
    ): array {
        $parameters = [];
        if (!$isList) {
            $parameters[] = 'name: "testSetting"';
        }
        $locationCondition = $this->getLocationParameterString($location);
        if ($locationCondition) {
            $parameters[] = $locationCondition;
        }

        $parameterString = !empty($parameters) ? '(' . implode(',', $parameters) . ')' : '';
        $I->sendGQLQuery(
            'query {
                ' . $queryName . $parameterString . '  {
                    ' . $field . '
                }
            }'
        );

        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
    }

    private function runSimplifiedAccessCheckMutation(
        AcceptanceTester $I,
        string $queryName,
        string $field,
        mixed $value,
        string $location
    ): array {
        $parameters = ['name:"testSetting"', 'value:' . $value];
        $locationCondition = $this->getLocationParameterString($location);
        if ($locationCondition) {
            $parameters[] = $locationCondition;
        }

        $I->sendGQLQuery(
            'mutation {
                ' . $queryName . '(' . implode(',', $parameters) . ') {
                    ' . $field . '
                }
            }'
        );

        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
    }

    private function getLocationParameterString(string $location): ?string
    {
        return match ($location) {
            'module' => 'moduleId: "testModule"',
            'theme' => 'themeId: "testTheme"',
            default => null
        };
    }

    protected function assertQueryNotFoundErrorInResult(AcceptanceTester $I, array $result): void
    {
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame(
            'You do not have sufficient rights to access this field',
            $errorMessage
        );
    }
}

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
    #[DataProvider('themeMutationsDataProvider')]
    #[DataProvider('listQueriesDataProvider')]
    #[DataProvider('moduleGettersDataProvider')]
    #[DataProvider('moduleMutationsDataProvider')]
    #[DataProvider('shopGettersDataProvider')]
    public function testGetSettingNotAuthorized(AcceptanceTester $I, \Codeception\Example $example): void
    {
        $I->login($this->getAgentUsername(), $this->getAgentPassword());

        $result = $this->runSimplifiedAccessCheckQuery(
            I: $I,
            queryType: $example['queryType'],
            queryName: $example['queryName'],
            field: $example['field']
        );

        $this->assertQueryNotFoundErrorInResult($I, $result, $example['queryName'], $example['queryType']);
    }

    protected function themeGettersDataProvider(): \Generator
    {
        yield ['queryType' => 'query', 'queryName' => 'themeSettingInteger', 'field' => 'name'];
        yield ['queryType' => 'query', 'queryName' => 'themeSettingFloat', 'field' => 'name'];
        yield ['queryType' => 'query', 'queryName' => 'themeSettingBoolean', 'field' => 'name'];
        yield ['queryType' => 'query', 'queryName' => 'themeSettingString', 'field' => 'name'];
        yield ['queryType' => 'query', 'queryName' => 'themeSettingSelect', 'field' => 'name'];
        yield ['queryType' => 'query', 'queryName' => 'themeSettingCollection', 'field' => 'name'];
        yield ['queryType' => 'query', 'queryName' => 'themeSettingAssocCollection', 'field' => 'name'];
    }

    protected function themeMutationsDataProvider(): \Generator
    {
        yield ['queryType' => 'mutation', 'queryName' => 'changeThemeSettingInteger', 'field' => 'name'];
        yield ['queryType' => 'mutation', 'queryName' => 'changeThemeSettingFloat', 'field' => 'name'];
        yield ['queryType' => 'mutation', 'queryName' => 'changeThemeSettingBoolean', 'field' => 'name'];
        yield ['queryType' => 'mutation', 'queryName' => 'changeThemeSettingString', 'field' => 'name'];
        yield ['queryType' => 'mutation', 'queryName' => 'changeThemeSettingCollection', 'field' => 'name'];
        yield ['queryType' => 'mutation', 'queryName' => 'changeThemeSettingAssocCollection', 'field' => 'name'];
    }

    protected function listQueriesDataProvider(): \Generator
    {
        yield ['queryType' => 'query', 'queryName' => 'themeSettingsList', 'field' => 'name'];
        yield ['queryType' => 'query', 'queryName' => 'moduleSettingsList', 'field' => 'name'];
        yield ['queryType' => 'query', 'queryName' => 'shopSettingsList', 'field' => 'name'];
    }

    protected function moduleGettersDataProvider(): \Generator
    {
        yield ['queryType' => 'query', 'queryName' => 'moduleSettingInteger', 'field' => 'name'];
        yield ['queryType' => 'query', 'queryName' => 'moduleSettingFloat', 'field' => 'name'];
        yield ['queryType' => 'query', 'queryName' => 'moduleSettingBoolean', 'field' => 'name'];
        yield ['queryType' => 'query', 'queryName' => 'moduleSettingString', 'field' => 'name'];
        yield ['queryType' => 'query', 'queryName' => 'moduleSettingCollection', 'field' => 'name'];
    }

    protected function moduleMutationsDataProvider(): \Generator
    {
        yield ['queryType' => 'mutation', 'queryName' => 'changeModuleSettingInteger', 'field' => 'name'];
        yield ['queryType' => 'mutation', 'queryName' => 'changeModuleSettingFloat', 'field' => 'name'];
        yield ['queryType' => 'mutation', 'queryName' => 'changeModuleSettingBoolean', 'field' => 'name'];
        yield ['queryType' => 'mutation', 'queryName' => 'changeModuleSettingString', 'field' => 'name'];
        yield ['queryType' => 'mutation', 'queryName' => 'changeModuleSettingCollection', 'field' => 'name'];
    }

    protected function shopGettersDataProvider(): \Generator
    {
        yield ['queryType' => 'query', 'queryName' => 'shopSettingInteger', 'field' => 'name'];
        yield ['queryType' => 'query', 'queryName' => 'shopSettingFloat', 'field' => 'name'];
        yield ['queryType' => 'query', 'queryName' => 'shopSettingBoolean', 'field' => 'name'];
        yield ['queryType' => 'query', 'queryName' => 'shopSettingString', 'field' => 'name'];
        yield ['queryType' => 'query', 'queryName' => 'shopSettingSelect', 'field' => 'name'];
        yield ['queryType' => 'query', 'queryName' => 'shopSettingCollection', 'field' => 'name'];
        yield ['queryType' => 'query', 'queryName' => 'shopSettingAssocCollection', 'field' => 'name'];
    }

    private function runSimplifiedAccessCheckQuery(
        AcceptanceTester $I,
        string $queryType,
        string $queryName,
        string $field,
    ): array {
        $I->sendGQLQuery(
            $queryType . '{
                ' . $queryName . '{
                    ' . $field . '
                }
            }'
        );

        $I->seeResponseIsJson();

        return $I->grabJsonResponseAsArray();
    }

    protected function assertQueryNotFoundErrorInResult(
        AcceptanceTester $I,
        array $result,
        string $query,
        string $queryType
    ): void {
        $errorMessage = $result['errors'][0]['message'];
        $I->assertSame(
            'Cannot query field "' . $query . '" on type "' . ucfirst($queryType) . '".',
            $errorMessage
        );
    }
}

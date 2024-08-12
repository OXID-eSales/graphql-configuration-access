<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\Module;

use Codeception\Attribute\DataProvider;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\BaseCest;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\AcceptanceTester;

/**
 * @group module_activation
 * @group theme_switch
 * @group setting_access
 * @group oe_graphql_configuration_access
 */
final class ModuleActivationCest extends BaseCest
{
    #[DataProvider('moduleDeActivationDataProvider')]
    public function testModuleActivationAuthorized(AcceptanceTester $I, \Codeception\Example $example): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runModuleMutation(
            I: $I,
            queryName: $example['queryName'],
            field: $example['field']
        );

        $I->assertArrayNotHasKey('errors', $result);
        $response = $result['data'][$example['queryName']];
        $I->assertTrue($response);
    }

    private function runModuleMutation(
        AcceptanceTester $I,
        string $queryName,
        string $field
    ): array {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());
        $I->sendGQLQuery(
            'mutation {
			  		' . $queryName . '(' . $field . ': "' . self::TEST_MODULE_ID . '")
				}'
        );

        $I->seeResponseIsJson();
        return $I->grabJsonResponseAsArray();
    }

    protected function moduleDeActivationDataProvider(): \Generator
    {
        yield ['queryName' => 'activateModule', 'field' => 'moduleId'];
        yield ['queryName' => 'deactivateModule', 'field' => 'moduleId'];
    }
}

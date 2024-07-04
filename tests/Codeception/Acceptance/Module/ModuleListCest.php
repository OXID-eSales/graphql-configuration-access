<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\Module;

use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\AcceptanceTester;

use function PHPUnit\Framework\assertCount;

/**
 * @group module_list
 * @group oe_graphql_configuration_access
 */
final class ModuleListCest extends ModuleSettingBaseCest
{
    public function testModuleListAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runModuleListQuery($I);
        $I->assertArrayNotHasKey('errors', $result);

        $moduleList = $result['data']['modulesList'];
        $I->assertEquals(
            [
                'id' => self::TEST_MODULE_ID,
                'version' => '',
                'title' => self::TEST_MODULE_TITLE,
                'description' => null,
                'thumbnail' => '',
                'author' => '',
                'url' => '',
                'email' => '',
                'active' => true
            ],
            $moduleList[0]
        );
    }

    public function runModuleListQuery(AcceptanceTester $I): array
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());
        $I->sendGQLQuery(
            'query modulesList {
			  modulesList(
				filters: {
				  title: {
					contains: "' . self::TEST_MODULE_TITLE . '"
				  }
				  active: {
					equals: true
				  }
				}
			  ) {
				id
				version
				title
				description
				thumbnail
				author
				url
				email
				active
			  }
			}'
        );

        $I->seeResponseIsJson();
        return $I->grabJsonResponseAsArray();
    }
}

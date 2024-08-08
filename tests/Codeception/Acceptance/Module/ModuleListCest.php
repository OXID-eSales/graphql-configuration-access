<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\Module;

use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\BaseCest;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\AcceptanceTester;

/**
 * @group module_list
 * @group oe_graphql_configuration_access
 */
final class ModuleListCest extends BaseCest
{
    public function testModuleListAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runModuleListQuery($I);
        $I->assertArrayNotHasKey('errors', $result);
    }

    public function runModuleListQuery(AcceptanceTester $I): array
    {
        $I->sendGQLQuery(
            'query modulesList {
			  modules(
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

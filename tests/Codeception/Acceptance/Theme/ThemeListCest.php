<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\Theme;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\Enum\FieldType;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\BaseCest;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\AcceptanceTester;

/**
 * @group theme_list
 * @group setting_access
 * @group oe_graphql_configuration_access
 */
final class ThemeListCest extends BaseCest
{
    public function testThemeListAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runThemeListQuery($I);
        $I->assertArrayNotHasKey('errors', $result);
    }

    private function runThemeListQuery(AcceptanceTester $I): array
    {
        $I->sendGQLQuery(
            'query themeList {
			  themesList(
				filters: null
			  ) {
				title
				id
				version
				description
				active
			  }
			}'
        );

        $I->seeResponseIsJson();
        return $I->grabJsonResponseAsArray();
    }
}

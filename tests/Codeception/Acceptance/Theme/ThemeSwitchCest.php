<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\Theme;

use OxidEsales\Eshop\Core\Theme;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\Acceptance\BaseCest;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Codeception\AcceptanceTester;

/**
 * @group theme_switch
 * @group oe_graphql_configuration_access
 */
final class ThemeSwitchCest extends BaseCest
{
    public function testThemeSwitchAuthorized(AcceptanceTester $I): void
    {
        $I->login($this->getAdminUsername(), $this->getAdminPassword());

        $result = $this->runThemeSwitchMutation($I);

        $I->assertArrayNotHasKey('errors', $result);
    }

    private function runThemeSwitchMutation(AcceptanceTester $I): array
    {
        $themeId = $this->getCurrentThemeId();

        $I->sendGQLQuery(
            'mutation switchThemeCest{
			  		switchTheme(themeId: "' . $themeId . '")
				}'
        );

        $I->seeResponseIsJson();
        return $I->grabJsonResponseAsArray();
    }

    private function getCurrentThemeId(): string
    {
        $theme = new Theme();
        return $theme->getActiveThemeId();
    }
}

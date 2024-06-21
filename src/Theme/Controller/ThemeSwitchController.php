<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\Controller;

use OxidEsales\GraphQL\ConfigurationAccess\Theme\Service\ThemeSwitchServiceInterface;
use TheCodingMachine\GraphQLite\Annotations\Logged;
use TheCodingMachine\GraphQLite\Annotations\Mutation;
use TheCodingMachine\GraphQLite\Annotations\Right;

final class ThemeSwitchController
{
    public function __construct(
        private readonly ThemeSwitchServiceInterface $themeSwitchService
    ) {
    }

    /**
     * Mutation of Configuration Access Module
     * @param string $identifier
     * @return bool
     */
    #[Mutation]
    #[Logged]
    #[Right('CHANGE_CONFIGURATION')]
    public function switchTheme(string $identifier): bool
    {
        return $this->themeSwitchService->switchTheme($identifier);
    }
}

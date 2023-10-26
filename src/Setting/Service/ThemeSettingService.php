<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ThemeSettingRepositoryInterface;
use TheCodingMachine\GraphQLite\Types\ID;

final class ThemeSettingService implements ThemeSettingServiceInterface
{
    public function __construct(
        private ThemeSettingRepositoryInterface $themeSettingRepository
    ) {}

    public function getIntegerSetting(ID $name, $themeId): IntegerSetting
    {
        return $this->themeSettingRepository->getIntegerSetting($name, $themeId);
    }

    public function getFloatSetting(ID $name, $themeId): FloatSetting
    {
        return $this->themeSettingRepository->getFloatSetting($name, $themeId);
    }

    public function getBooleanSetting(ID $name, $themeId): BooleanSetting
    {
        return $this->themeSettingRepository->getBooleanSetting($name, $themeId);
    }

    public function getStringSetting(ID $name, $themeId): StringSetting
    {
        return $this->themeSettingRepository->getStringSetting($name, $themeId);
    }

    public function getSelectSetting(ID $name, $themeId): StringSetting
    {
        return $this->themeSettingRepository->getSelectSetting($name, $themeId);
    }
}

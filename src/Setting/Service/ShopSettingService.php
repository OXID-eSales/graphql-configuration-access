<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ShopSettingRepositoryInterface;
use TheCodingMachine\GraphQLite\Types\ID;

final class ShopSettingService implements ShopSettingServiceInterface
{
    public function __construct(
        private ShopSettingRepositoryInterface $shopSettingRepository
    ) {}

    public function getIntegerSetting(ID $name): IntegerSetting
    {
        $integer = $this->shopSettingRepository->getInteger($name);
        return new IntegerSetting($name, $integer);
    }
}

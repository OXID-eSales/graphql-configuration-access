<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Config\Dao\ShopConfigurationSettingDaoInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Config\Utility\ShopSettingEncoderInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ShopSettingRepository;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure\ShopSettingRepositoryInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\UnitTestCase;

abstract class AbstractShopSettingRepositoryTest extends UnitTestCase
{
    protected function getSut(
        ?BasicContextInterface $basicContext = null,
        ?QueryBuilderFactoryInterface $queryBuilderFactory = null,
        ?ShopSettingEncoderInterface $shopSettingEncoder = null,
        ?ShopConfigurationSettingDaoInterface $shopSettingDao = null,
    ): ShopSettingRepositoryInterface {
        return new ShopSettingRepository(
            basicContext: $basicContext ?? $this->createStub(BasicContextInterface::class),
            queryBuilderFactory: $queryBuilderFactory ?? $this->createStub(QueryBuilderFactoryInterface::class),
            shopSettingEncoder: $shopSettingEncoder ?? $this->createStub(ShopSettingEncoderInterface::class),
            configurationSettingDao: $shopSettingDao ?? $this->createStub(ShopConfigurationSettingDaoInterface::class),
        );
    }
}

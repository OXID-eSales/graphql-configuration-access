<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Config\Utility\ShopSettingEncoderInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Theme\Infrastructure\ThemeSettingRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class AbstractThemeSettingRepositoryTestCase extends AbstractDatabaseSettingsRepositoryTestCase
{
    protected function getSut(
        ?array $methods = null,
        ?BasicContextInterface $basicContext = null,
        ?EventDispatcherInterface $eventDispatcher = null,
        ?QueryBuilderFactoryInterface $queryBuilderFactory = null,
        ?ShopSettingEncoderInterface $settingEncoder = null
    ): MockObject|ThemeSettingRepository {
        $repository = $this->getMockBuilder(ThemeSettingRepository::class)
            ->setConstructorArgs([
                $basicContext ?? $this->createMock(BasicContextInterface::class),
                $eventDispatcher ?? $this->createMock(EventDispatcherInterface::class),
                $queryBuilderFactory ?? $this->createMock(QueryBuilderFactoryInterface::class),
                $settingEncoder ?? $this->createMock(ShopSettingEncoderInterface::class)
            ])
            ->onlyMethods($methods ?? [])
            ->getMock();
        return $repository;
    }
}

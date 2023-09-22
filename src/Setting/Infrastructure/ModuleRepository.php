<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Basket\Infrastructure;

use Doctrine\DBAL\FetchMode;
use OxidEsales\Eshop\Application\Model\UserBasket as UserBasketEshopModel;
use OxidEsales\Eshop\Core\Registry as EshopRegistry;
use OxidEsales\Eshop\Core\TableViewNameGenerator;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Dao\ModuleConfigurationDaoInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\ContextInterface;
use OxidEsales\GraphQL\Base\DataType\Filter\IDFilter;
use OxidEsales\GraphQL\Base\DataType\Filter\StringFilter;
use OxidEsales\GraphQL\Base\DataType\Pagination\Pagination as PaginationFilter;
use OxidEsales\GraphQL\Base\Exception\NotFound;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\Storefront\Basket\DataType\Basket as BasketDataType;
use OxidEsales\GraphQL\Storefront\Basket\DataType\BasketByTitleAndUserIdFilterList;
use OxidEsales\GraphQL\Storefront\Basket\DataType\PublicBasket as PublicBasketDataType;
use OxidEsales\GraphQL\Storefront\Basket\DataType\Sorting;
use OxidEsales\GraphQL\Storefront\Basket\Exception\BasketForUserNotFound;
use OxidEsales\GraphQL\Storefront\Basket\Exception\BasketNotFound;
use OxidEsales\GraphQL\Storefront\Customer\DataType\Customer as CustomerDataType;
use OxidEsales\GraphQL\Storefront\Shared\Infrastructure\Repository as SharedRepository;
use PDO;
use TheCodingMachine\GraphQLite\Types\ID;

final class ModuleRepository
{
    public function __construct(
        private ModuleConfigurationDaoInterface $moduleConfigurationDao,
        private ContextInterface $context
    ) {}

    public function getIntegerSetting(ID $name, string $moduleId):IntegerSetting
    {
        $moduleConfiguration = $this->moduleConfigurationDao->get($moduleId, $this->context->getCurrentShopId());
        $setting = $moduleConfiguration->getModuleSetting($name->val());
        var_dump($setting->getValue());
    }
}

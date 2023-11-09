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
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
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

    public function getFloatSetting(ID $name): FloatSetting
    {
        $float = $this->shopSettingRepository->getFloat($name);
        return new FloatSetting($name, $float);
    }

    public function getBooleanSetting(ID $name): BooleanSetting
    {
        $bool = $this->shopSettingRepository->getBoolean($name);
        return new BooleanSetting($name, $bool);
    }

    public function getStringSetting(ID $name): StringSetting
    {
        $string = $this->shopSettingRepository->getString($name);
        return new StringSetting($name, $string);
    }

    public function getSelectSetting(ID $name): StringSetting
    {
        $select = $this->shopSettingRepository->getSelect($name);
        return new StringSetting($name, $select);
    }

    public function getCollectionSetting(ID $name): StringSetting
    {
        $collectionString = $this->shopSettingRepository->getCollection($name);
        return new StringSetting($name, json_encode($collectionString));
    }

    public function getAssocCollectionSetting(ID $name): StringSetting
    {
        $assocCollectionString = $this->shopSettingRepository->getAssocCollection($name);
        return new StringSetting($name, json_encode($assocCollectionString));
    }

    /**
     * @return SettingType[]
     */
    public function getSettingsList(): array
    {
        $settingsList = $this->shopSettingRepository->getSettingsList();
        $settingsTypeList = [];
        foreach ($settingsList as $name => $type) {
            $settingsTypeList[] = new SettingType(new ID($name), $type);
        }

        return $settingsTypeList;
    }
}

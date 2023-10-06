<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\BooleanSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\FloatSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\IntegerSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\SettingType;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\DataType\StringSetting;
use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use PHPUnit\Framework\TestCase;
use TheCodingMachine\GraphQLite\Types\ID;

class UnitTestCase extends TestCase
{
    protected function getIntegerSetting(): IntegerSetting
    {
        return new IntegerSetting(new ID('integerSetting'), 123);
    }

    protected function getFloatSetting(): FloatSetting
    {
        return new FloatSetting(new ID('floatSetting'), 1.23);
    }

    protected function getNegativeBooleanSetting(): BooleanSetting
    {
        return new BooleanSetting(new ID('booleanSetting'), false);
    }

    protected function getPositiveBooleanSetting(): BooleanSetting
    {
        return new BooleanSetting(new ID('booleanSetting'), true);
    }

    protected function getStringSetting(): StringSetting
    {
        return new StringSetting(new ID('stringSetting'), 'default');
    }

    protected function getSelectSetting(): StringSetting
    {
        return new StringSetting(new ID('selectSetting'), 'select');
    }

    protected function getCollectionSetting(): StringSetting
    {
        return new StringSetting(new ID('arraySetting'), json_encode(['nice', 'values']));
    }

    protected function getAssocCollectionSetting(): StringSetting
    {
        return new StringSetting(new ID('aarraySetting'), json_encode(
            ['first'=>'10','second'=>'20','third'=>'50']));
    }

    protected function getSettingType(): SettingType
    {
        return new SettingType(new ID('settingType'), FieldType::BOOLEAN);
    }
}

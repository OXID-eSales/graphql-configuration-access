<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Integration\Infrastructure;

use OxidEsales\EshopCommunity\Internal\Framework\Config\Utility\ShopSettingEncoder;

/**
 * This method is needed to execute en/de-coding and also notice if en/de-coder was executed
 */
class DecoratedShopSettingEncoder extends ShopSettingEncoder
{
    private int $encodeCounter = 0;
    private int $decodeCounter = 0;

    public function encode(string $encodingType, $value)
    {
        $this->encodeCounter += 1;
        return parent::encode($encodingType, $value);
    }

    public function decode(string $encodingType, $value)
    {
        $this->decodeCounter += 1;
        return parent::decode($encodingType, $value);
    }

    public function getEncodeCounter(): int
    {
        return $this->encodeCounter;
    }

    public function getDecodeCounter(): int
    {
        return $this->decodeCounter;
    }
}

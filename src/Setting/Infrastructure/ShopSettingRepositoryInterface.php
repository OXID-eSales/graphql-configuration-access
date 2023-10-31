<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use TheCodingMachine\GraphQLite\Types\ID;

interface ShopSettingRepositoryInterface
{
    public function getInteger(ID $name): int;
}

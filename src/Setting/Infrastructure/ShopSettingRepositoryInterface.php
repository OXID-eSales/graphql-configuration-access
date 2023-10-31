<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use TheCodingMachine\GraphQLite\Types\ID;

interface ShopSettingRepositoryInterface
{
    public function getInteger(ID $name): int;
    public function getFloat(ID $name): float;
    public function getBoolean(ID $name): bool;
    public function getString(ID $name): string;
    public function getSelect(ID $name): string;
}

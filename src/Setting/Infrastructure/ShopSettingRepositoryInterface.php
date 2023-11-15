<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use TheCodingMachine\GraphQLite\Types\ID;

interface ShopSettingRepositoryInterface
{
    public function getInteger(ID $name): int;

    public function getFloat(ID $name): float;

    public function getBoolean(ID $name): bool;

    public function getString(ID $name): string;

    public function getSelect(ID $name): string;

    public function getCollection(ID $name): array;

    public function getAssocCollection(ID $name): array;

    /**
     * @return array<string, string>
     */
    public function getSettingsList(): array;
}

<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Setting\Enum\FieldType;
use TheCodingMachine\GraphQLite\Types\ID;

interface ShopSettingRepositoryInterface
{
    public function getInteger(string $name): int;

    public function getFloat(string $name): float;

    public function getBoolean(string $name): bool;

    public function getString(string $name): string;

    public function getSelect(ID $name): string;

    public function getCollection(ID $name): array;

    public function getAssocCollection(ID $name): array;

    /**
     * @return array<string, string>
     */
    public function getSettingsList(): array;
}

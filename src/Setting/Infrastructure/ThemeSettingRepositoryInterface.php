<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Setting\Infrastructure;

use TheCodingMachine\GraphQLite\Types\ID;

interface ThemeSettingRepositoryInterface
{
    public function getInteger(ID $name, string $themeId): int;
    public function getFloat(ID $name, string $themeId): float;
    public function getBoolean(ID $name, string $themeId): bool;
    public function getString(ID $name, string $themeId): string;
    public function getSelect(ID $name, string $themeId): string;
    public function getCollection(ID $name, string $themeId): array;
    public function getAssocCollection(ID $name, string $themeId): array;
    /**
     * @return [
     * string $name => FieldType $type
     * ]
     */
    public function getSettingsList(string $themeId): array;
}

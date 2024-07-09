<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\Infrastructure;

interface LanguageWrapperInterface
{
    public function getBaseLanguage(): int;
    public function getLanguageAbbr(?int $langId = null): string;
}

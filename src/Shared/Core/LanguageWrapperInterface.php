<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\Core;

interface LanguageWrapperInterface
{
    public function getBaseLanguage(): int;
    public function getLanguageAbbr(?int $langId = null): string;
}

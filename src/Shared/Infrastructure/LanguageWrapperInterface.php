<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\Infrastructure;

interface LanguageWrapperInterface
{
    public function getCurrentLanguageAbbr(): string;
}

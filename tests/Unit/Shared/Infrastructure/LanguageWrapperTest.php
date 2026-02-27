<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\Infrastructure\LanguageWrapper;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use OxidEsales\Eshop\Core\Language;

#[CoversClass(\OxidEsales\GraphQL\ConfigurationAccess\Shared\Infrastructure\LanguageWrapper::class)]
class LanguageWrapperTest extends TestCase
{
    public function testGetCurrentLanguageAbbr(): void
    {
        $langAbbr = uniqid();
        $languageMock = $this->createConfiguredStub(Language::class, [
            'getLanguageAbbr' => $langAbbr,
        ]);

        $languageWrapper = new LanguageWrapper($languageMock);
        $actualLangAbbr = $languageWrapper->getCurrentLanguageAbbr();

        $this->assertSame($langAbbr, $actualLangAbbr);
    }
}

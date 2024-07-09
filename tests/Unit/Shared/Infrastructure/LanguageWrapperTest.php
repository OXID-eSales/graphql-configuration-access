<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\Infrastructure;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\Infrastructure\LanguageWrapper;
use PHPUnit\Framework\TestCase;
use OxidEsales\Eshop\Core\Language;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shared\Infrastructure\LanguageWrapper
 */
class LanguageWrapperTest extends TestCase
{
    public function testGetBaseLanguage(): void
    {
        $expectedLangId = 1;
        $languageMock = $this->createPartialMock(Language::class, ['getBaseLanguage']);
        $languageMock->method('getBaseLanguage')->willReturn($expectedLangId);

        $languageWrapper = new LanguageWrapper($languageMock);
        $actualLangId = $languageWrapper->getBaseLanguage();

        $this->assertSame($expectedLangId, $actualLangId);
    }

    public function testGetLanguageAbbr(): void
    {
        $langId = 1;
        $expectedLangAbbr = uniqid();
        $languageMock = $this->createPartialMock(Language::class, ['getLanguageAbbr']);
        $languageMock->method('getLanguageAbbr')->willReturn($expectedLangAbbr);

        $languageWrapper = new LanguageWrapper($languageMock);
        $actualLangAbbr = $languageWrapper->getLanguageAbbr($langId);

        $this->assertSame($expectedLangAbbr, $actualLangAbbr);
    }
}

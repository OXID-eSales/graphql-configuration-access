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

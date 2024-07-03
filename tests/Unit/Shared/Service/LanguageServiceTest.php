<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\Service;

use OxidEsales\Eshop\Core\Language;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\LanguageService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\LanguageService;
 */
class LanguageServiceTest extends TestCase
{
    public function testFilterByLanguageAbbreviationCorrectLangValue()
    {
        $expectedResult = "Title in de language";
        $titlesData = [
            'de' => 'Title in de language',
            'en' => 'Title in en language',
        ];

        $languageMock = $this->createPartialMock(Language::class, ['getBaseLanguage','getLanguageAbbr']);
        $languageMock->method('getBaseLanguage')->willReturn(1);
        $languageMock->method('getLanguageAbbr')->with(1)->willReturn('de');

        $languageService = new LanguageService($languageMock);
        $actualResult = $languageService->filterByLanguageAbbreviation($titlesData);

        $this->assertSame($actualResult, $expectedResult);
    }

    public function testFilterByLanguageAbbreviationWrongLangValue()
    {
        $titlesData = [
            'de' => 'Title in de language',
            'en' => 'Title in en language',
        ];

        $languageMock = $this->createPartialMock(Language::class, ['getBaseLanguage','getLanguageAbbr']);
        $languageMock->method('getBaseLanguage')->willReturn(2);
        $languageMock->method('getLanguageAbbr')->with(2)->willReturn('fr');

        $languageService = new LanguageService($languageMock);
        $actualResult = $languageService->filterByLanguageAbbreviation($titlesData);

        $this->assertNull($actualResult);
    }
}

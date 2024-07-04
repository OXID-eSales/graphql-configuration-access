<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\Core\LanguageWrapperInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\LanguageService;
use PHPUnit\Framework\TestCase;

class LanguageServiceTest extends TestCase
{
    public function testFilterByLanguageAbbreviationCorrectLangValue()
    {
        $expectedResult = "Title in de language";
        $titlesData = [
            'de' => 'Title in de language',
            'en' => 'Title in en language',
        ];

        $languageWrapperMock = $this->createMock(LanguageWrapperInterface::class);
        $languageWrapperMock->method('getBaseLanguage')->willReturn(1);
        $languageWrapperMock->method('getLanguageAbbr')->with(1)->willReturn('de');

        $languageService = new LanguageService($languageWrapperMock);
        $actualResult = $languageService->filterByLanguageAbbreviation($titlesData);

        $this->assertSame($actualResult, $expectedResult);
    }

    public function testFilterByLanguageAbbreviationDefaultedToEnglish()
    {
        $expectedResult = "Title in en language";
        $titlesData = [
            'de' => 'Title in de language',
            'en' => 'Title in en language',
        ];

        $languageWrapperMock = $this->createMock(LanguageWrapperInterface::class);
        $languageWrapperMock->method('getBaseLanguage')->willReturn(2);
        $languageWrapperMock->method('getLanguageAbbr')->with(2)->willReturn('fr');

        $languageService = new LanguageService($languageWrapperMock);
        $actualResult = $languageService->filterByLanguageAbbreviation($titlesData);

        $this->assertSame($expectedResult, $actualResult);
    }

    public function testFilterByLanguageAbbreviationReturnNull(): void
    {
        $titlesData = [];

        $languageWrapperMock = $this->createMock(LanguageWrapperInterface::class);
        $languageWrapperMock->method('getBaseLanguage')->willReturn(1);
        $languageWrapperMock->method('getLanguageAbbr')->with(1)->willReturn('de');

        $languageService = new LanguageService($languageWrapperMock);
        $actualResult = $languageService->filterByLanguageAbbreviation($titlesData);

        $this->assertNull($actualResult);
    }
}

<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Tests\Unit\Shared\Service;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\Infrastructure\LanguageWrapperInterface;
use OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\LanguageService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OxidEsales\GraphQL\ConfigurationAccess\Shared\Service\LanguageService
 */
class LanguageServiceTest extends TestCase
{
    public function testFilterByLanguageAbbreviationCorrectLangValue()
    {
        $titlesData = [
            'de' => 'Title in de language',
            'en' => 'Title in en language',
        ];
        $expectedExistingLanguageAbbreviation = 'de';

        $languageWrapperMock = $this->createMock(LanguageWrapperInterface::class);
        $languageWrapperMock->method('getCurrentLanguageAbbr')
            ->willReturn($expectedExistingLanguageAbbreviation);

        $languageService = new LanguageService($languageWrapperMock);
        $actualResult = $languageService->filterByLanguageAbbreviation($titlesData, 'en');

        $this->assertSame($titlesData[$expectedExistingLanguageAbbreviation], $actualResult);
    }

    public function testFilterByLanguageAbbreviationDefaultedToEnglish()
    {
        $titlesData = [
            'de' => 'Title in de language',
            'en' => 'Title in en language',
        ];
        $defaultLangAbbr = 'en';

        $languageWrapperMock = $this->createMock(LanguageWrapperInterface::class);
        $languageWrapperMock->method('getCurrentLanguageAbbr')->willReturn('fr');

        $languageService = new LanguageService($languageWrapperMock);
        $actualResult = $languageService->filterByLanguageAbbreviation($titlesData, $defaultLangAbbr);

        $this->assertSame($titlesData[$defaultLangAbbr], $actualResult);
    }

    public function testFilterByLanguageAbbreviationDefaultedToFirstInArray()
    {
        $titlesData = [
            'de' => 'Title in de language',
            'en' => 'Title in en language',
        ];

        $languageWrapperMock = $this->createMock(LanguageWrapperInterface::class);
        $languageWrapperMock->expects($this->once())
            ->method('getCurrentLanguageAbbr')->willReturn('pl');

        $languageService = new LanguageService($languageWrapperMock);
        $actualResult = $languageService->filterByLanguageAbbreviation($titlesData, 'fr');

        $this->assertSame($titlesData['de'], $actualResult);
    }
}

<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType;

use OxidEsales\GraphQL\Base\DataType\Filter\BoolFilter;
use OxidEsales\GraphQL\Base\DataType\Filter\StringFilter;

final class ThemeFilterList
{
    /** @var ?StringFilter */
    private $title;

    /** @var ?BoolFilter */
    private $active;

    public function __construct(
        ?StringFilter $title = null,
        ?BoolFilter $active = null
    ) {
        $this->title = $title;
        $this->active = $active;
    }

    /**
     * @return array{
     *                title: ?StringFilter,
     *                active : ?BoolFilter,
     *                }
     */
    public function getFilters(): array
    {
        return [
            'title' => $this->title,
            'active' => $this->active,
        ];
    }
}

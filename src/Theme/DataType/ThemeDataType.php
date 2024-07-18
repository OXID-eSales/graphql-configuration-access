<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

#[Type]
final class ThemeDataType
{
    public function __construct(
        private readonly string $title,
        private readonly string $identifier,
        private readonly string $version,
        private readonly string $description,
        private readonly bool $active
    ) {
    }

    #[Field]
    public function getTitle(): string
    {
        return $this->title;
    }

    #[Field]
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    #[Field]
    public function getVersion(): string
    {
        return $this->version;
    }

    #[Field]
    public function getDescription(): string
    {
        return $this->description;
    }

    #[Field]
    public function isActive(): bool
    {
        return $this->active;
    }
}

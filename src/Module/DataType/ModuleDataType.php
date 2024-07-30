<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\DataType;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

#[Type]
final class ModuleDataType implements ModuleDataTypeInterface
{
    public function __construct(
        private readonly string $id,
        private readonly string $version,
        private readonly string $title,
        private readonly string $description,
        private readonly ?string $thumbnail,
        private readonly ?string $author,
        private readonly ?string $url,
        private readonly ?string $email,
        private readonly bool $active
    ) {
    }

    #[Field]
    public function getId(): string
    {
        return $this->id;
    }

    #[Field]
    public function getTitle(): string
    {
        return $this->title;
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
    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    #[Field]
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    #[Field]
    public function getUrl(): ?string
    {
        return $this->url;
    }

    #[Field]
    public function getEmail(): ?string
    {
        return $this->email;
    }

    #[Field]
    public function isActive(): bool
    {
        return $this->active;
    }
}

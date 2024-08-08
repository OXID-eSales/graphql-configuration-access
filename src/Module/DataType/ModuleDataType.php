<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\AbstractComponentDataType;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

#[Type]
final class ModuleDataType extends AbstractComponentDataType implements ModuleDataTypeInterface
{
    /**
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        string $id,
        string $title,
        string $version,
        string $description,
        bool $active,
        private readonly ?string $thumbnail,
        private readonly ?string $author,
        private readonly ?string $url,
        private readonly ?string $email,
        private readonly string $lang
    ) {
        parent::__construct($id, $title, $version, $description, $active);
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
    public function getLang(): string
    {
        return $this->lang;
    }
}

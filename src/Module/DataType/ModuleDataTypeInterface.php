<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentDataTypeInterface;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

#[Type]
interface ModuleDataTypeInterface extends ComponentDataTypeInterface
{
    #[Field]
    public function getThumbnail(): ?string;

    #[Field]
    public function getAuthor(): ?string;

    #[Field]
    public function getUrl(): ?string;

    #[Field]
    public function getEmail(): ?string;

    #[Field]
    public function getLang(): string;
}

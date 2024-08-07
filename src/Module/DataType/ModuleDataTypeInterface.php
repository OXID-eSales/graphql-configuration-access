<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentDataTypeInterface;

interface ModuleDataTypeInterface extends ComponentDataTypeInterface
{
    public function getThumbnail(): ?string;

    public function getAuthor(): ?string;

    public function getUrl(): ?string;

    public function getEmail(): ?string;

    public function isActive(): bool;
}

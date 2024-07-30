<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\GraphQL\ConfigurationAccess\Module\DataType;

interface ModuleDataTypeInterface
{
    public function getId(): string;

    public function getTitle(): string;

    public function getVersion(): string;

    public function getDescription(): string;

    public function getThumbnail(): ?string;

    public function getAuthor(): ?string;

    public function getUrl(): ?string;

    public function getEmail(): ?string;

    public function isActive(): bool;
}

<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType;

interface ComponentDataTypeInterface
{
    public function getId(): string;

    public function getTitle(): string;

    public function getVersion(): string;

    public function getDescription(): string;

    public function isActive(): bool;
}

<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

#[Type]
interface ComponentDataTypeInterface
{
    #[Field]
    public function getId(): string;

    #[Field]
    public function getTitle(): string;

    #[Field]
    public function getVersion(): string;

    #[Field]
    public function getDescription(): string;

    #[Field]
    public function isActive(): bool;
}

<?php

namespace OxidEsales\GraphQL\ConfigurationAccess\Theme\DataType;

use OxidEsales\GraphQL\ConfigurationAccess\Shared\DataType\ComponentDataTypeInterface;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;

#[Type]
interface ThemeDataTypeInterface extends ComponentDataTypeInterface
{
    #[Field]
    public function getParentTheme(): ?string;

    /**
     * @return ?string[]
     */
    #[Field]
    public function getParentVersions(): ?array;
}

<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

// This is acceptance bootstrap

use Symfony\Component\Filesystem\Path;

$sourcePath = getenv('SHOP_ROOT_PATH') ?: (new \OxidEsales\Facts\Facts())->getShopRootPath();
require_once Path::join($sourcePath, 'source', 'bootstrap.php');

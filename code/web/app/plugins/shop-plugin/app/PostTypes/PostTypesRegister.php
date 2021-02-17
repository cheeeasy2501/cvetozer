<?php

namespace Shop\PostTypes;

use Shop\PostTypes\Catalog;

/**
 * Class PostTypesRegister
 * @package Shop\PostTypes
 */
class PostTypesRegister
{
    /**
     * PostTypesRegister constructor
     */
    public function __construct() {
        Catalog::register();
    }
}

new PostTypesRegister();

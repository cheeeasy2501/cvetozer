<?php

namespace Shop\PostTypes;

use Shop\PostTypes\Product;

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
        Product::register();
    }
}

new PostTypesRegister();

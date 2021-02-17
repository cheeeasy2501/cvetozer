<?php

namespace Shop\Taxonomies;

use Shop\Taxonomies\ProductCategory;

/**
 * Class TaxonomiesRegister
 * @package Shop\Taxonomies
 */
class TaxonomiesRegister
{
    /**
     * TaxonomiesRegister constructor
     */
    public function __construct() {
        ProductCategory::register();
    }
}

new TaxonomiesRegister();

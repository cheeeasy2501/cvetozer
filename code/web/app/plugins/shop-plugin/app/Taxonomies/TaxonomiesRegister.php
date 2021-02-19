<?php

namespace Shop\Taxonomies;

use Shop\Taxonomies\Catalog;

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
        Catalog::register();
    }
}

new TaxonomiesRegister();

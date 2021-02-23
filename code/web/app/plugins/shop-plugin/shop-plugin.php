<?php

/*
 * Plugin name: Shop
 * Description: Плагин для каталога
 * Author: Author
 * Version: 0.1
 * */

require_once __DIR__ . '/vendor/autoload.php';

use Shop\PostTypes\PostTypesRegister;
use Shop\Taxonomies\TaxonomiesRegister;
use Shop\MetaBoxes\MetaBoxRegister;

### Register custom taxonomies
new TaxonomiesRegister();

### Register custom post types
new PostTypesRegister();

### Register metaboxes
new MetaBoxRegister();

### Disable Gutenberg
add_filter('use_block_editor_for_post', '__return_false', 10);
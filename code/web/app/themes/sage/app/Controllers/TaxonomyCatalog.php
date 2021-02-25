<?php

namespace App\Controllers;

use App\Views\Category;
use Shop\Taxonomies\Catalog;
use Sober\Controller\Controller;

class TaxonomyCatalog extends Controller
{
    function currentCatalogCategories(): string {
        $category = get_queried_object();
        $categories = get_terms([
            'taxonomy'   => Catalog::TAXONOMY_TYPE,
            'hide_empty' => false,
            'parent' => $category->term_id
        ]);

        return Category::categoryRender($categories);
    }
}

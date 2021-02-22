<?php

namespace App\Views;

use Shop\Taxonomies\Catalog;

class Category
{
    /**
     * @param $catalogs
     * @return false|string
     */
    public static function categoryRender($catalogs) {
        if (empty($catalogs)) {
            return false;
        }

        $html = '<ul class="category-catalog__block">';

        foreach ($catalogs as $catalog) {
            $link = get_term_link($catalog->term_id, Catalog::TAXONOMY_TYPE);
            $title = $catalog->name;
            $description = $catalog->description;

            $html .= "<li class='catalog-category'>
                        <a class='catalog-category__link' href='{$link}'>
                            <div class='catalog-category__link__title'>{$title}</div>
                            <div class='catalog-category__link__description'>{$description}</div>
                        </a>
                      </li>";
        }

        $html .= '</ul>';

        return $html;
    }
}

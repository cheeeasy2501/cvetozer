<?php
namespace App\Controllers;

use Sober\Controller\Controller;

class TaxonomyCatalog extends Controller {

    function currentCatalogItems():string {
        $args = [
            'show_option_all'     => '',
            'show_option_none'    => __('No categories'),
            'orderby'             => 'name',
            'order'               => 'ASC',
            'style'               => 'list',
            'show_count'          => 0,
            'hide_empty'          => 1,
            'use_desc_for_title'  => 1,
            'child_of'            => 0,
            'feed'                => '',
            'feed_type'           => '',
            'feed_image'          => '',
            'exclude'             => '',
            'exclude_tree'        => '',
            'include'             => '',
            'hierarchical'        => true,
            'title_li'            => __('Categories'),
            'number'              => NULL,
            'echo'                => 0,
            'depth'               => 0,
            'current_category'    => 0,
            'pad_counts'          => 0,
            'taxonomy'            => 'catalog',
            'walker'              => 'Walker_Category',
            'hide_title_if_empty' => false,
            'separator'           => '<br />',
        ];

       return wp_list_categories( $args );
    }
}

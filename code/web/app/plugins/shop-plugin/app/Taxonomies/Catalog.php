<?php

namespace Shop\Taxonomies;

use Shop\PostTypes\Product;

/**
 * Class Catalog
 * @package Shop\Taxonomies
 */
class Catalog
{

    public const TAXONOMY_TYPE = 'catalog';

    public const TAXONOMY_POST_TYPES_RELATIONSHIP = [
        Product::POST_TYPE,
    ];

    /**
     * Register Catalog taxonomy
     */
    public static function register(): void {
        $instance = new self;

        add_action('init', [$instance, 'registerTaxanomy']);
    }

    /**
     * Catalog taxonomy settings
     *
     * @return array
     */
    private function settings(): array {

        $labels = [
            'name'              => __('Категория товара'),
            'singular_name'     => __('Категория товара'),
            'search_items'      => __('Поиск категории товара'),
            'all_items'         => __('Все категории'),
            'view_item '        => __('Просмотреть категории товара'),
            'parent_item'       => __('Родительская категория'),
            'parent_item_colon' => __('Родительский категория:'),
            'edit_item'         => __('Редактировать категорию'),
            'update_item'       => __('Обновить категорию'),
            'add_new_item'      => __('Добавить новую категорию'),
            'new_item_name'     => __('Новое имя кататегории'),
            'menu_name'         => __('Категории товаров'),
        ];

        return [
            'label'                 => '',
            'labels'                => $labels,
            "public"                => true,
            "publicly_queryable"    => true,
            "hierarchical"          => true,
            "show_ui"               => true,
            "show_in_menu"          => true,
            "show_in_nav_menus"     => true,
            "query_var"             => true,
            "rewrite"               => ['slug' => self::TAXONOMY_TYPE, 'with_front' => true, 'hierarchical' => true,],
            "show_admin_column"     => false,
            "show_in_rest"          => true,
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "rest_base"             => self::TAXONOMY_TYPE,
        ];
    }

    /**
     * Register Catalog taxonomy
     */
    public function registerTaxanomy(): void {
        $args = $this->settings();
        register_taxonomy(self::TAXONOMY_TYPE, self::TAXONOMY_POST_TYPES_RELATIONSHIP, $args);
    }
}

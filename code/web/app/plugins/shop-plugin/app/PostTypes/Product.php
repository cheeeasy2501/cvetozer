<?php

namespace Shop\PostTypes;

class Product
{

    public const POST_TYPE = 'product';

    /**
     * Product post type register
     */
    public static function register(): void {
        $instance = new self;

        add_action('init', [$instance, 'registerPostType']);
        add_filter('post_updated_messages', [$instance, 'ProductUpdateMessages']);
    }

    /**
     * Product post type settings
     *
     * @return array
     */
    private function settings(): array {
        return [
            'labels'             => [
                'name'               => __('Товары'),
                'singular_name'      => __('Товар'),
                'add_new'            => __('Добавить новый'),
                'add_new_item'       => __('Добавить новый товар'),
                'edit_item'          => __('Редактировать товар'),
                'new_item'           => __('Новый товар'),
                'view_item'          => __('Посмотреть товар'),
                'search_items'       => __('Найти товар'),
                'not_found'          => __('Товар не найден'),
                'not_found_in_trash' => __('В корзине товар не найдено'),
                'parent_item_colon'  => __(''),
                'menu_name'          => __('Товары'),

            ],
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => true,
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 10,
            'menu_icon'          => 'dashicons-products',
            'supports'           => ['title', 'thumbnail', 'excerpt',],
            'delete_with_user'   => false,
        ];
    }

    /**
     * Register Product post type
     */
    public function registerPostType(): void {
        $args = $this->settings();
        register_post_type(self::POST_TYPE, $args);
    }

    /**
     * Product post type messages
     *
     * @param $messages
     * @return mixed
     */
    function ProductUpdateMessages($messages) {
        global $post;

        $messages['product'] = [
            0  => '',
            1  => sprintf('Товар обновлен. <a href="%s">Посмотреть товар</a>', esc_url(get_permalink($post->ID))),
            2  => 'Произвольное поле обновлено.',
            3  => 'Произвольное поле удалено.',
            4  => 'Товар обновлен.',
            5  => isset($_GET['revision']) ? sprintf('Товар восстановлен из ревизии %s', wp_post_revision_title((int)$_GET['revision'], false)) : false,
            6  => sprintf('Товар опубликован. <a href="%s">Перейти к товару</a>', esc_url(get_permalink($post->ID))),
            7  => 'Товар сохранен.',
            8  => sprintf('Товар сохранен. <a target="_blank" href="%s">Предпросмотр товара</a>', esc_url(add_query_arg('preview', 'true', get_permalink($post->ID)))),
            9  => sprintf('Товар запланирован на: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Предпросмотр товара</a>',
                date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post->ID))),
            10 => sprintf('Черновик товара обновлен. <a target="_blank" href="%s">Предпросмотр товара</a>', esc_url(add_query_arg('preview', 'true', get_permalink($post->ID)))),
        ];

        return $messages;
    }
}
<?php

namespace Cvetozer\Widgets;

use WP_Widget;

class PhoneWidget extends WP_Widget
{
    const WIDGET_ID = 'phone-widget';

    function __construct() {
        // Запускаем родительский класс
        parent::__construct(
            self::WIDGET_ID,
            __('Номер телефона', 'shop'),
            ['description' => 'Контактные данные, номер телефона']
        );
        $this->loadScripts();
    }

    public static function register() {
        register_widget(new self());
    }

    private function loadScripts() {
        if (is_active_widget(false, false, $this->id_base) || is_customize_preview()) {
            add_action('wp_enqueue_scripts', [$this, 'addScripts']);
            add_action('wp_head', [$this, 'addStyles']);
        }
    }

    function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);
        echo $args['before_widget'];

        if ($title)
            echo $args['before_title'] . $title . $args['after_title'];

        echo 'Привет!';

        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance) {
    }

    function form($instance) {
        $title = $instance['title'] ?: 'Заголовок по умолчанию';
        echo '<p>
            <label for="' . $this->get_field_id('title') . '">' . _e('Title:') . '</label>
            <input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . esc_attr($title) . '">
        </p>';
    }

    // скрипт виджета
    function addScripts() {
        if (!apply_filters('show_phone_widget_script', true, $this->id_base)) {
            return;
        }

        $widgetUrl = get_stylesheet_directory_uri() . '/static/scripts/widgets';
        wp_enqueue_script('phone_widget_script', $widgetUrl . '/phone-widget.js');
    }

    function addStyles() {
        if (!apply_filters('show_phone_widget_style', true, $this->id_base))
            return;
        ?>
        <style>
            .my_widget a {
                display: inline;
            }
        </style>
        <?php
    }
}
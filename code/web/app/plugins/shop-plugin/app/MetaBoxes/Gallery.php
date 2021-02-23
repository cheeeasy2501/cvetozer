<?php

namespace Shop\MetaBoxes;

use Shop\AbstractClasses\AMetaBox;
use Shop\PostTypes\Product;

class Gallery extends AMetaBox
{
    public function __construct() {
        parent::__construct();
    }

    public static function register(): void {
        $instance = new self;
        add_action('admin_enqueue_scripts', [$instance, 'includeAssetsFiles']);
    }

    public function addMetaBox($postType) {
        add_meta_box('gallery', __('Gallery', 'shop'), [$this, 'renderHTML'], [Product::POST_TYPE], 'advanced', 'high');
    }

    public function includeAssetsFiles() {
        wp_enqueue_script('gallery-metabox', plugin_dir_url(__DIR__) . 'Assets/js/gallery-metabox.js', [], '1.0');
        wp_enqueue_style('gallery-metabox', plugin_dir_url(__DIR__) . 'Assets/css/gallery-metabox.css');
    }

    private function galleryImages() {
        $galleryData = get_post_meta(get_the_ID(), 'gallery_data', true);

        echo '  <div id="img_box_container">';
        if (isset($galleryData['image_url'])) {
            foreach ($galleryData['image_url'] as $data) {
                echo '<div class="gallery_single_row dolu">
                        <div class="gallery_area image_container ">
                            <img class="gallery_img_img" src="' . $data . '"
                            height="55" width="55" onclick="open_media_uploader_image_this(this)"/>
                            <input type="hidden"
                                   class="meta_image_url"
                                   name="gallery[image_url][]"
                                   value="' . $data . '"
                            />
                        </div>
                        <div class="gallery_area">
                            <span class="button remove" onclick="remove_img(this)" title="Remove"/><i
                                    class="fas fa-trash-alt"></i></span>
                        </div>
                        <div class="clear"></div>        
                    </div>';
            }
        }
        echo '</div>';
    }

    private function galleryAddImageModal() {
        echo '<div style="display:none" id="master_box">
                <div class="gallery_single_row">
                    <div class="gallery_area image_container" onclick="open_media_uploader_image(this)">
                        <input class="meta_image_url" value="" type="hidden" name="gallery[image_url][]"/>
                    </div>
                    <div class="gallery_area">
                        <span class="button remove" onclick="remove_img(this)" title="Remove"/><i
                                class="fas fa-trash-alt"></i></span>
                    </div>
                    <div class="clear"></div>
                </div>
              </div>';
    }

    public function galleryAddButton() {
        echo '<div id="add_gallery_single_row">
                 <input class="button add" type="button" value="+" onclick="open_media_uploader_image_plus();"
                   title="Add image"/>
              </div> ';
    }

    public function renderHTML() {
        wp_nonce_field(basename(__FILE__), 'gallery_nonce');

        echo '<div id="gallery_wrapper">';
        $this->galleryImages();
        $this->galleryAddImageModal();
        $this->galleryAddButton();
        $this->property_gallery_styles_scripts();
        echo '</div>';
    }

    function property_gallery_styles_scripts() {
        echo '
        <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/solid.js"
                integrity="sha384-+Ga2s7YBbhOD6nie0DzrZpJes+b2K1xkpKxTFFcx59QmVPaSA8c7pycsNaFwUK6l"
                crossorigin="anonymous"></script>
        <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
        <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js"
                integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c"
                crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
      ';
    }

    public function save() {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $post_id = get_the_ID();
        $isAutoSave = wp_is_post_autosave($post_id);
        $isRevision = wp_is_post_revision($post_id);
        $isValidNonce = wp_verify_nonce($_POST['gallery_nonce'], basename(__FILE__)) ? true : false;

        if ($isAutoSave || $isRevision || !$isValidNonce || !current_user_can('edit_post', $post_id)) {
            return;
        }

        if (Product::POST_TYPE !== $_POST['post_type']) {
            return;
        }

        if ($_POST['gallery']) {
            $galleryData = [];
            $postData = $_POST['gallery']['image_url'];

            foreach ($postData as $datum) {
                if(!empty($datum)) {
                    $galleryData['image_url'][] = $datum;
                }
            }

            if ($galleryData) {
                update_post_meta($post_id, 'gallery_data', $galleryData);
            }
        } else {
            delete_post_meta($post_id, 'gallery_data');
        }
    }
}
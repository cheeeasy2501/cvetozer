<?php

namespace Shop\MetaBoxes;

use Shop\AbstractClasses\AMetaBox;
use Shop\PostTypes\Product;

class Gallery extends AMetaBox
{
    /**
     * Gallery constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Register this metabox function
     */
    public static function register(): void {
        $instance = new self;
        add_action('admin_enqueue_scripts', [$instance, 'includeAssetsFiles']);
    }

    /**
     * Include assets for metabox
     */
    public function includeAssetsFiles() {
        wp_enqueue_script('gallery-metabox', plugin_dir_url(__DIR__) . 'Assets/js/gallery-metabox.js', ['jquery'], '1.0');
        wp_enqueue_style('gallery-metabox', plugin_dir_url(__DIR__) . 'Assets/css/gallery-metabox.css');
    }

    /**
     * Add metabox hook
     *
     * @param $postType
     * @return mixed|void
     */
    public function addMetaBox($postType) {
        add_meta_box('gallery', __('Галерея', 'shop'), [$this, 'render'], [Product::POST_TYPE], 'advanced', 'high');
    }

    /**
     * Get gallery data
     *
     * @return mixed
     */
    public static function getData() {
        return get_post_meta(get_the_ID(), 'gallery_data', true);
    }
    /**
     * Image html part
     */
    private function images() {
        $galleryData = self::getData();

        echo '<div id="img_box_container">';
        if (isset($galleryData['image_url'])) {
            foreach ($galleryData['image_url'] as $data) {
                echo '<div class="gallery_single_row dolu">
                        <div class="gallery_area image_container ">
                            <img class="gallery_img_img" src="' . $data . '"
                            height="55" width="55" onclick="openUploaderImages(this)"/>
                            <input type="hidden"
                                   class="meta_image_url"
                                   name="gallery[image_url][]"
                                   value="' . $data . '"
                            />
                        </div>
                        <div class="gallery_area">
                            <span class="button remove" onclick="removeImage(this)" title="Remove"/><i
                                    class="fas fa-trash-alt"></i></span>
                        </div>
                        <div class="clear"></div>        
                </div>';
            }
        }
        echo '</div>';
    }

    /**
     * Image modal part
     */
    private function addImageModal() {
        echo '<div style="display:none" id="master_box">
                <div class="gallery_single_row">
                    <div class="gallery_area image_container" onclick="openUploaderImages()">
                        <input class="meta_image_url" value="" type="hidden" name="gallery[image_url][]"/>
                    </div>
                    <div class="gallery_area">
                        <span class="button remove" onclick="removeImage(this)" title="Remove"/><i
                                class="fas fa-trash-alt"></i></span>
                    </div>
                    <div class="clear"></div>
                </div>
              </div>';
    }

    /**
     * Add image button part
     */
    public function addImageButton() {
        echo '<div id="add_gallery_single_row">
                 <input class="button add" type="button" value="+" onclick="openUploaderImages();"
                   title="Add image"/>
              </div> ';
    }

    /**
     * Helper script
     */
    function galleryHelperScripts() {
        echo '
        <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/solid.js"
                integrity="sha384-+Ga2s7YBbhOD6nie0DzrZpJes+b2K1xkpKxTFFcx59QmVPaSA8c7pycsNaFwUK6l"
                crossorigin="anonymous"></script>
              <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js"
                integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c"
                crossorigin="anonymous"></script>
      ';
    }

    /**
     * Html
     */
    public function render() {
        wp_nonce_field(basename(__FILE__), 'gallery_nonce');

        echo '<div id="gallery_wrapper">';
        $this->images();
        $this->addImageModal();
        $this->addImageButton();
        $this->galleryHelperScripts();
        echo '</div>';
    }

    /**
     * Save gallery data to database
     *
     * @return mixed|void
     */
    public function save() {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $post_id = get_the_ID();
        $isAutoSave = wp_is_post_autosave($post_id);
        $isRevision = wp_is_post_revision($post_id);

        if(isset($_POST['gallery_nonce'])) {
            $isValidNonce = wp_verify_nonce($_POST['gallery_nonce'], basename(__FILE__)) ? true : false;
        } else {
            $isValidNonce = false;
        }

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
            } else {
                delete_post_meta($post_id, 'gallery_data');
            }
        }
    }
}
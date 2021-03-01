<?php

namespace App\Controllers;

use App\Views\Category;
use Shop\Taxonomies\Catalog;
use Sober\Controller\Controller;

class SingleProduct extends Controller
{
    protected $acf = true;

    /**
     * @var array
     */
    public const LINKS = [
        'customAssets/scripts/single-product.js'
    ];

    public static function register(){

    }
    /**
     * Register script
     *
     * @return array
     */
    public function scripts(): array
    {
        $scripts = [];
        $currentPath = get_template_directory_uri();

        if (self::LINKS) {
            foreach (self::LINKS as $link) {
//                wp_enqueue_script(self::class);
                $scripts[] = $currentPath . $link;
            }
        }
    }

    /**
     * Get images
     *
     * @return mixed
     */
    public function images()
    {
        $imagesData = get_post_meta(get_the_ID(), 'gallery_data', true);

        return $imagesData['image_url'];
    }
}
new SingleProduct();

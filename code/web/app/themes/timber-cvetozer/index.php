<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package    WordPress
 * @subpackage Timber
 * @since      Timber 0.1
 */

use Shop\Taxonomies\Catalog;
use Timber\Image;
use Timber\Timber;
use Timber\PostQuery;
use Timber\URLHelper;

$templates = ['index.twig'];
$context                 = Timber::context();
$context['posts']        = new PostQuery();
$context['catalogTerms'] = Timber::get_terms(
    [
        'taxonomy'   => Catalog::TAXONOMY_TYPE,
        'hide_empty' => false,
        'parent'     => 29,
    ]
);

foreach ($context['catalogTerms'] as &$term) {
    if (isset($term->category_image) && strlen($term->category_image)) {
        $term->category_image = new Image($term->category_image);
    }
}

if (is_home()) {
    $context['menu']->items = unsetHomeMenu($context['menu']->items);
    array_unshift($templates, 'front-page.twig', 'home.twig');
}

Timber::render($templates, $context);


/**
 * Unset home menu if this homepage
 *
 * @param  $menuItems
 * @return mixed
 */
function unsetHomeMenu($menuItems)
{
    $helper     = new URLHelper();
    $currentUrl = $helper::get_current_url();

    foreach ($menuItems as $key => $item) {
        if ($item->url === $currentUrl) {
            unset($menuItems[$key]);
        }
    }

    return $menuItems;
}

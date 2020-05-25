<?php
/**
 * Online Shop functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Acme Themes
 * @subpackage Online Shop
 */

/**
 * require int.
 */
require_once trailingslashit( get_template_directory() ).'acmethemes/init.php';

add_action( 'woocommerce_after_shop_loop_item_title', 'wc_add_long_description' );
/**
 * WooCommerce, Add Long Description to Products on Shop Page with Character limit
 *
 * @link https://wpbeaches.com/woocommerce-add-short-or-long-description-to-products-on-shop-page
 */
function wc_add_long_description() {
	global $product;

	?>
        <div itemprop="description">
            <?php echo substr( apply_filters( 'the_content', $product->post->post_content ), 0,200 ); echo '...' ?>
        </div>
	<?php
}
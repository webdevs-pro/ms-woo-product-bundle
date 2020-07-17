<?php
/*
Plugin Name: MS Product Bundles for WooCommerce
Plugin URI: https://www.magnific-soft.com/
Description: MS Product Bundles is a plugin help you bundle a few products, offer them at a discount and watch the sales go up!
Version: 1.1
Author: Magnific Soft
Author URI: https://www.magnific-soft.com/
Text Domain: woo-product-bundle
Domain Path: /languages/
Requires at least: 4.0
Tested up to: 5.4.2
WC requires at least: 3.0
WC tested up to: 4.2.2
*/

defined( 'ABSPATH' ) || exit;

! defined( 'WOOSB_VERSION' ) && define( 'WOOSB_VERSION', '5.2.5' );
! defined( 'WOOSB_URI' ) && define( 'WOOSB_URI', plugin_dir_url( __FILE__ ) );
! defined( 'WOOSB_DIR' ) && define( 'WOOSB_DIR', plugin_dir_path( __FILE__ ) );
! defined( 'WOOSB_FILE' ) && define( 'WOOSB_FILE', __FILE__ );
! defined( 'WOOSB_REVIEWS' ) && define( 'WOOSB_REVIEWS', 'https://wordpress.org/support/plugin/woo-product-bundle/reviews/?filter=5' );
! defined( 'WOOSB_CHANGELOG' ) && define( 'WOOSB_CHANGELOG', 'https://wordpress.org/plugins/woo-product-bundle/#developers' );
! defined( 'WOOSB_DISCUSSION' ) && define( 'WOOSB_DISCUSSION', 'https://wordpress.org/support/plugin/woo-product-bundle' );
! defined( 'MS_URI' ) && define( 'MS_URI', WOOSB_URI );

include 'includes/wpc-menu.php';
include 'includes/wpc-dashboard.php';

if ( ! function_exists( 'woosb_init' ) ) {
	add_action( 'plugins_loaded', 'woosb_init', 11 );

	function woosb_init() {
		// load text-domain
		load_plugin_textdomain( 'woo-product-bundle', false, basename( __DIR__ ) . '/languages/' );

		if ( ! function_exists( 'WC' ) || ! version_compare( WC()->version, '3.0.0', '>=' ) ) {
			add_action( 'admin_notices', 'woosb_notice_wc' );

			return;
		}

		include_once 'includes/class-helper.php';
		include_once 'includes/class-product.php';
		include_once 'includes/class-woosb.php';
		include_once 'includes/class-compatible.php';

		// start
		$GLOBALS['woosb'] = MSleverWoosb();
	}
} else {
	add_action( 'admin_notices', 'woosb_notice_premium' );
}

if ( ! function_exists( 'woosb_notice_wc' ) ) {
	function woosb_notice_wc() {
		?>
        <div class="error">
            <p><strong>MS Product Bundles</strong> requires WooCommerce version 3.0.0 or greater.</p>
        </div>
		<?php
	}
}

if ( ! function_exists( 'woosb_notice_premium' ) ) {
	function woosb_notice_premium() {
		?>
        <div class="error">
            <p>Seems you're using both free and premium version of <strong>MS Product Bundles</strong>. Please
                deactivate the free version when using the premium version.</p>
        </div>
		<?php
	}
}





add_shortcode('ms_ajax_add_to_cart', function() {

	global $product;
	$id = $product ? $product->get_id() : 0;
	
	$product = new WC_Product_Woosb( $id );

	$bundle = new MSleverWoosb();
	

	$ids = $product->get_ids();


ob_start() //start buffering
?>

<script>
	jQuery(document).ready(function($){
		 
		 $('body').on('click touch', '.woosb_item_checkbox', function() {
			  
			  var product_qty_val = $(this).closest('.woosb-product').find('.woosb-qty').attr('data-qty');
			  
			  if($(this).prop("checked") == true) {
					$(this).closest('.woosb-product').find('.input-text.qty.text').val(product_qty_val);
					$(this).closest('.woosb-product').find('.input-text.qty.text').trigger('change');
			  } else {
					$(this).closest('.woosb-product').find('.input-text.qty.text').val('0');
					$(this).closest('.woosb-product').find('.input-text.qty.text').trigger('change');
			  }
			  
			  var ids = $('#woosb_ids-<?php echo $id; ?>').val();
			  $('.add_to_cart_item_<?php echo $id; ?> a').attr('data-woosb_ids', ids);
			  
		 });
		 
		 
	});
</script>

<?php $bundle->woosb_show_bundled($product); ?>

<input name="woosb_ids" id="woosb_ids-<?php echo $id; ?>" class="woosb_ids woosb-ids" type="hidden" value="<?php echo $ids; ?>">

<div class="add_to_cart_item_<?php echo $id; ?> add_to_cart_item">
	<a  href="?add-to-cart=<?php echo $id; ?>" 
		 data-quantity="1"   
		 class="button product_type_simple add_to_cart_button ajax_add_to_cart" 
		 data-product_id="<?php echo $id; ?>" 
		 data-woosb_ids="<?php echo $ids; ?>"
		 rel="nofollow">
		 in den warenkorb<img src="/wp-admin/images/spinner.gif" class="spinner">
	</a>
</div>



<?php
$html = ob_get_contents(); //get your content
ob_end_clean(); //clean echoed html code


return $html;
});


// plugin updates
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/webdevs-pro/ms-woo-product-bundle',
	__FILE__,
	'ms-woo-product-bundle'
);
<?php
/*
Plugin Name: MS WPC PBfW addon
Plugin URI: https://www.magnific-soft.com/
Description: This is addon for WPC Product Bundles for WooCommerce
Version: 1.8
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
define( 'MSWPB_URI', plugin_dir_url( __FILE__ ) );

// init class
add_action( 'plugins_loaded', function() {
	include_once 'includes/class-add-to-cart.php';
	MSwpbpAddon::instance();
}, 200, 20 );


// enqueue script
add_action('wp_enqueue_scripts', function() {
	if (function_exists('is_product') && (is_product() || is_page())) {
		wp_enqueue_script('woo-ajax-add-to-cart');
	}
}, 200);


// plugin updates
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/webdevs-pro/ms-woo-product-bundle',
	__FILE__,
	'ms-woo-product-bundle'
);


// allow more than 3 attributeі in variable product type
add_filter( 'woocommerce_product_variation_title_include_attributes', '__return_true' );


// add quantity before bundled item title
add_filter('woosb_item_name', function($name, $_product, $product, $count){
	if ( $items = $product->get_items() ) {
		$name = $items[$count - 1]['qty'] . ' × ' . $name;
	}
	return $name;
}, 20, 4);


// keep this option always enable to prevent echo defaul qty
add_action( 'woocommerce_update_product', 'ms_product_save', 10, 1 );
function ms_product_save( $product_id ) {
	  update_post_meta( $product_id, 'woosb_optional_products', 'on' );
}


// hide unnecessary checkboxes on bundled product screen
add_action('admin_head', 'ms_custom_admin_styles');
function ms_custom_admin_styles() {
  echo '<style>
  	.woosb_tr_space:not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(3)) {
		display: none !important;
	}
  </style>';
}
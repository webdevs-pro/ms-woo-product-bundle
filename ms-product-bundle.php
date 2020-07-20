<?php
/*
Plugin Name: MS WPC PBfW addon
Plugin URI: https://www.magnific-soft.com/
Description: This is addon for WPC Product Bundles for WooCommerce
Version: 1.6
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

add_action( 'plugins_loaded', function() {
	include_once 'includes/class-add-to-cart.php';
	MSwpbpAddon::instance();
}, 200, 20 );

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


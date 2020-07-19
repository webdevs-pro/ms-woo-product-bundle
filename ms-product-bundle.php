<?php
/*
Plugin Name: MS WPC PBfW addon
Plugin URI: https://www.magnific-soft.com/
Description: This is addon for WPC Product Bundles for WooCommerce
Version: 1.4.1
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




// plugin updates
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/webdevs-pro/ms-woo-product-bundle',
	__FILE__,
	'ms-woo-product-bundle'
);



if ( ! function_exists( 'mswpbpaddon_init' ) ) {
	add_action( 'plugins_loaded', 'mswpbpaddon_init', 200, 20 );

	function mswpbpaddon_init() {


		// if ( ! function_exists( 'WC' ) || ! version_compare( WC()->version, '3.0.0', '>=' ) ) {
		// 	return;
		// }

		include_once 'includes/class-add-to-cart.php';


		// start
		MSwpbpAddon::instance();

	}
}








// $pluginExample = new PluginExample();
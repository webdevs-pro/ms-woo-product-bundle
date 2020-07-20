<?php
class MSwpbpAddon {

   protected static $_instance = null;


   public static function instance() {
      if ( is_null( self::$_instance ) ) {
         self::$_instance = new self();
      }

      return self::$_instance;
   }


	function __construct() {		
      add_action('woosb_before_item_name', array($this, 'mswpb_add_checkbox'));
      add_action( 'wp_enqueue_scripts', array( $this, 'mswpb_wp_enqueue_scripts' ) );
	}
   
   
	function mswpb_add_checkbox($_product) {	

		$id = $_product->get_id();

		if ( $_product->is_in_stock() ) {
			echo '<input type="checkbox" class="woosb_item_checkbox" id="woosb_item_checkbox_' . $id . '" checked>';
		} else {
			echo '<input type="checkbox" id="optional_' . $id . '" disabled>';
		}
   }	


   function mswpb_wp_enqueue_scripts() {
      wp_enqueue_script( 'wmswpb-frontend', MSWPB_URI . 'assets/frontend.js', array( 'jquery' ), '', true );
   }
   
}


// class MSwpbpADTC extends QLWCAJAX {

//    function add_product_js() {

//       echo "BOOM";

//       // wp_register_script('woo-ajax-add-to-cart', plugin_dir_url(__FILE__) . 'assets/woo-ajax-add-to-cart.min.js', array('jquery', 'wc-add-to-cart'), QLWCAJAX_PLUGIN_VERSION, true);
//       wp_register_script('woo-ajax-add-to-cart', plugin_dir_url(__FILE__) . 'assets/woo-ajax-add-to-cart.js', array('jquery', 'wc-add-to-cart'), QLWCAJAX_PLUGIN_VERSION, true);


//       // if (function_exists('is_product') && (is_product() || is_page())) {
//         wp_enqueue_script('woo-ajax-add-to-cart');
//       // }
//     }
   
// }
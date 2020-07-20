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

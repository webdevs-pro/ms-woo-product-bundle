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
		add_shortcode('ms_ajax_add_to_cart', array($this, 'mswpb_ajax_add_to_cart'));
      add_action('woosb_before_item_name', array($this, 'mswpb_add_checkbox'));
      add_action( 'wp_enqueue_scripts', array( $this, 'mswpb_wp_enqueue_scripts' ) );
	}
   
   
	function mswpb_ajax_add_to_cart() {	

      global $product;
      
		$id = $product ? $product->get_id() : 0;
		
		$product = new WC_Product_Woosb( $id );

		$ids = $product->get_ids();
	
      ob_start() //start buffering
      
		?>
      <div class="mswpb_woosb_addon">

         <style>
            /* .mswpb_woosb_addon form.cart,
            .mswpb_woosb_addon .woosb-qty {
               display: none;
            } */
         </style>
      
         <?php echo do_shortcode('[woosb_form]'); ?>

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

      </div>
	
		<?php
		$html = ob_get_contents(); //get your content
		ob_end_clean(); //clean echoed html code
	
		return $html;
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

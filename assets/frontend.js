'use strict';

// trigger bundle price calculation after jetsmartfilters ajax loaded
jQuery(document).on('jet-filter-content-rendered', function($provider,provider,queryId) {

// detect add to cart button class changes after jetsmartfilters ajax loaded
  // mut.observe(document.querySelector(".mswpb_woosb_addon button.single_add_to_cart_button"),{
  //   'attributes': true
  // });

  // jet-smart-filters ajax filter fix
  jQuery.getScript("/wp-content/plugins/woocommerce/assets/js/frontend/add-to-cart-variation.min.js");
  jQuery.getScript("/wp-content/plugins/woocommerce/assets/js/frontend/add-to-cart-variation.js");

  jQuery.getScript("/wp-content/plugins/woo-ajax-add-to-cart/assets/woo-ajax-add-to-cart.min.js");


  // jet-smart-filters ajax woosb fix
  jQuery('.woosb-wrap').each(function() {
    woosb_init(jQuery(this));
  });

});



jQuery(document).ready(function($){
    
  $('body').on('click touch', '.woosb_item_checkbox', function() {

    var $product = $($(this).closest('.woosb-product'));
    
    var product_qty_val = $product.attr('data-qty');

    // set reserved original qty value
    var product_origin_qty_val = $product.attr('data-origin-qty');
    if(!product_origin_qty_val) {
      $product.attr('data-origin-qty', product_qty_val);
      product_origin_qty_val = product_qty_val;
    } 

    if($(this).prop("checked") == true) {
      $product.find('.input-text.qty.text').val(product_origin_qty_val);
      $product.find('.input-text.qty.text').trigger('change');
    } else {
      $product.find('.input-text.qty.text').val('0');
      $product.find('.input-text.qty.text').trigger('change');
    }
    
    var product_id = $product.closest('.woosb-bundled.woosb-wrap ').attr('data-id');

    var ids = $('#woosb_ids-' + product_id).val();

    $('.add_to_cart_item_' + product_id + ' a').attr('data-woosb_ids', ids);

    if($('.add_to_cart_item_' + product_id + ' a').attr('data-woosb_ids') == "") {
      $('.add_to_cart_item_' + product_id + ' a').addClass('disabled');
    } else {
      $('.add_to_cart_item_' + product_id + ' a').removeClass('disabled');
    }
    
  });
  
  
});




// detect add to cart button class changes
// var mut = new MutationObserver(function(mutations, mut){
//   mutations.forEach(function (mutation) {
//     if (mutation.attributeName === "class") {
//         if(jQuery(mutation.target).hasClass('disabled')) {
//           jQuery(mutation.target).closest('.mswpb_woosb_addon').find('.add_to_cart_button.ajax_add_to_cart').addClass('disabled');
//         } else {
//           jQuery(mutation.target).closest('.mswpb_woosb_addon').find('.add_to_cart_button.ajax_add_to_cart').removeClass('disabled');
//         }
//     }
//   });
// });
// mut.observe(document.querySelector(".mswpb_woosb_addon button.single_add_to_cart_button"),{
//   'attributes': true
// });
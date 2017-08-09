<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $woocommerce, $product;

if ( ! $product->is_purchasable() ) {
	return;
}
?>

<?php
	// Availability
	$availability = $product->get_availability();

	if ($availability['availability']) :
		echo apply_filters( 'woocommerce_stock_html', '<p class="stock '.$availability['class'].'">'.$availability['availability'].'</p>', $availability['availability'] , $product);
    endif;
?>

<?php if ( $product->is_in_stock() && is_shop_enabled() ) : ?>

	<?php do_action('woocommerce_before_add_to_cart_form'); ?>

	<form class="cart" method="post" enctype='multipart/form-data'>

	 	<?php do_action('woocommerce_before_add_to_cart_button'); ?>

	 	<?php

	 		if ( ! $product->is_sold_individually() ) : ?>

	 			<label><?php _e( 'Quantity', 'yit' ) ?></label><?php
	 			
	 			/**
				 * @since 3.0.0.
				 */
				do_action( 'woocommerce_before_add_to_cart_quantity' );

				woocommerce_quantity_input( array(
					'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
					'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
					'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : $product->get_min_purchase_quantity(),
				) );

				/**
				 * @since 3.0.0.
				 */
				do_action( 'woocommerce_after_add_to_cart_quantity' );

			endif;

			$porduct_type = property_exists( 'WC_Product', 'product_type' ) ? $product->product_type : $product->get_type();
            $label = apply_filters( 'single_add_to_cart_text', yit_icl_translate("theme","yit","add_to_cart_text",yit_get_option( 'add-to-cart-text' )) , $porduct_type );
	 	?>

        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />

	 	<button type="submit" class="single_add_to_cart_button button alt"><?php echo $label ?></button>

	 	<?php do_action('woocommerce_after_add_to_cart_button'); ?>

	</form>

    <div class="clear"></div>

	<?php do_action('woocommerce_after_add_to_cart_form'); ?>

<?php endif; ?>

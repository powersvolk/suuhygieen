<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

	<div class="cart__total-item">
		<span class="cart__total-item-title">
			<?php _e('Together','suuhygieen');?>
		</span>
		<span class="cart__total-price">
			<?php echo wc_price( WC()->cart->get_subtotal() ); ?>
		</span>
	</div>
	<div class="cart__total-item">
		<span class="cart__total-item-title">
			<?php _e('VAT','suuhygieen');?>
		</span>
		<span class="cart__total-price">
			<?php
			if ( wc_tax_enabled() && WC()->cart->display_prices_including_tax() ) {
				$tax_string_array = array();
				$cart_tax_totals  = WC()->cart->get_tax_totals();

				if ( get_option( 'woocommerce_tax_total_display' ) === 'itemized' ) {
					foreach ( $cart_tax_totals as $code => $tax ) {
						$tax_string_array[] = sprintf( '%s', $tax->formatted_amount);
					}
				} elseif ( ! empty( $cart_tax_totals ) ) {
					$tax_string_array[] = sprintf( '%s', wc_price( WC()->cart->get_taxes_total( true, true ) ));
				}
				
				if ( ! empty( $tax_string_array ) ) {
					$taxable_address = WC()->customer->get_taxable_address();
					/* translators: %s: country name */
					$estimated_text = WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ? sprintf( ' ' . __( 'estimated for %s', 'woocommerce' ), WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] ) : '';
					/* translators: %s: tax information */
					echo $value = sprintf( __( '%s', 'woocommerce' ), implode( ', ', $tax_string_array ) . $estimated_text );
				}
				
			}
		?>
		</span>
	</div>
	<?php if ( WC()->cart->get_coupons()) { ?>
	<div class="cart__total-item">
		<span class="cart__total-item-title">
			<?php _e('Сoupon','suuhygieen');?>
		</span>
		<span class="cart__total-price">
			<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
				<?php wc_cart_totals_coupon_new( $coupon ); ?>
			<?php endforeach; ?>
		</span>
	</div>
	<?php } ?>
		
	
	<div class="cart__total-item">
		<span class="cart__total-item-title">
			<?php _e('Total','suuhygieen');?>
		</span>
		<span class="cart__total-price">
			<?php wc_cart_totals_order_total_html(); ?>
		</span>
	</div>


	<div class="wc-proceed-to-checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>

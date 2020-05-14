<?php
/**
 * Output a single payment method
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment-method.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

		<label class="wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?>" for="payment_method_<?php echo esc_attr( $gateway->id ); ?>">
			<input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />
			<span class="billing__item-radio">
				<span class="billing__item-radio-image">
					<?php if($gateway->id == 'cheque') { ?>
						<img src="<?php bloginfo('template_url');?>/img/icons/receipt.svg">
					<?php } else if($gateway->id == 'cod') { ?>
						<img src="<?php bloginfo('template_url');?>/img/icons/credit-cart.svg">
					<?php } else if($gateway->id == 'paypal') { ?>
						<img src="<?php bloginfo('template_url');?>/img/icons/icon-pay.svg">
					<?php } ?>	
				</span>
				<?php echo $gateway->get_title(); ?>
			</span>
		</label>


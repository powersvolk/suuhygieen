<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>
	<h1 class="cart__title">
		<?php the_title();?>
	</h1>
	<table class="cart__table" cellspacing="0">
		<thead>
			<tr>
				<th><?php _e('Picture','suuhygieen');?></th>
				<th><?php _e('Producs','suuhygieen');?></th>
				<th><?php _e('Price','suuhygieen');?></th>
				<th><?php _e('Quantity','suuhygieen');?></th>
				<th><?php _e('Amount','suuhygieen');?></th>
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<tr>
						<td>
							<?php
							
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							if ( ! $product_permalink ) {
								echo $thumbnail; // PHPCS: XSS ok.
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
							}
							?>
						</td>

						<td>
							<?php
								if ( ! $product_permalink ) {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
								} else {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s" class="cart-item__title">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
								}

								do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

								// Meta data.
								echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

								// Backorder notification.
								if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
								}
							?>

							<div class="product__code">
								<span><?php _e('product code:','suuhygieen');?></span> <?php echo $_product->get_sku(); ?>
							</div>
							<p class="cart-item__subtitle">
								<?php echo get_the_excerpt($_product->id); ?>
							</p>


						</td>
						<td>
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>

						<td>
						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input(
									array(
										'input_name'   => "cart[{$cart_item_key}][qty]",
										'input_value'  => $cart_item['quantity'],
										'max_value'    => $_product->get_max_purchase_quantity(),
										'min_value'    => '0',
										'product_name' => $_product->get_name(),
									),
									$_product,
									false
								);
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
						?>
						</td>

						<td>
							<span class="cart-item__amount product-subtotal" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
								<?php
									echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
								?>
							</span>
							<div class="product-remove">
								<?php
									echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										'woocommerce_cart_item_remove_link',
										sprintf(
											'<a href="%s" class="remove cart-item__remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">REMOVE FROM CART</a>',
											esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
											esc_html__( 'Remove this item', 'woocommerce' ),
											esc_attr( $product_id ),
											esc_attr( $_product->get_sku() )
										),
										$cart_item_key
									);
								?>
							</div>
						</td>
					</tr>
					<?php
				}
			}
			?>
		</tbody>
	</table>
	
	<div class="cart-item__bottom">
		<?php if ( wc_coupons_enabled() ) { ?>
			<div class="coupon wrap__coupon">
				<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> 
				<button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>">
					<?php esc_attr_e( 'confirm', 'woocommerce' ); ?>
				</button>
				<?php do_action( 'woocommerce_cart_coupon' ); ?>
			</div>
		<?php } ?>
		<div class="cart-collaterals cart__total">
			<?php// do_action( 'woocommerce_cart_collaterals' ); ?>
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

			</div>

			
		</div>

	</div>
	
	

	<!--
	<button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
	-->
</form>





<?php do_action( 'woocommerce_after_cart' ); ?>

<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}


								
if( $product->is_type('variable') ) {
	// Min variation price
	$regularPriceMin = $product->get_variation_regular_price(); // Min regular price
	$salePriceMin    = $product->get_variation_sale_price(); // Min sale price
	$priceMin        = $product->get_variation_price(); // Min price

	// Max variation price
	$regularPriceMax = $product->get_variation_regular_price('max'); // Max regular price
	$salePriceMax    = $product->get_variation_sale_price('max'); // Max sale price
	$priceMax        = $product->get_variation_price('max'); // Max price

	// Multi dimensional array of all variations prices 
	$variationsPrices = $product->get_variation_prices(); 
	
	$tax_rates = WC_Tax::get_rates( $product->get_tax_class() );
	$regularPriceMaxTax = WC_Tax::calc_tax( $regularPriceMax, $tax_rates, false );
	$salePriceMinTax = WC_Tax::calc_tax( $salePriceMin, $tax_rates, false );


	if(!empty($salePriceMin) && !empty($regularPriceMax)) {  
		$price = $regularPriceMax + $regularPriceMaxTax[2];
		$sale = $salePriceMin + $salePriceMinTax[2];
	} else {
		$price = $regularPriceMax + $regularPriceMaxTax[2];  
	}
	if(!empty($salePriceMin) && !empty($regularPriceMax)) {  
		$discount = 'prod-action';
	}	else {
		$discount = '';
	}
} else {
	
	$price = get_post_meta( $post->ID, '_regular_price', true);
	$sale = get_post_meta( $post->ID, '_sale_price', true);	
		if(!empty($sale) && !empty($price)) {  
			$sale = wc_get_price_including_tax( $product );  
			$price = wc_get_sale_price_including_tax( $product, array('price' => $price ) );  
		} else {
			$price = wc_get_sale_price_including_tax( $product, array('price' => $price ) );  
		}

	if(!empty($sale) && !empty($price)) {  
		$discount = 'prod-action';
	}	else {
		$discount = '';
	}	
}

?>


<a href="<?php echo get_the_permalink($post->ID); ?>" class="prod-item <?php echo $discount; ?>" <?php //wc_product_class( '', $product ); ?>>
	<div class="prod-item__image">
		<img src="<?php echo get_the_post_thumbnail_url($post->ID, 'thumbnail' ); ?>" alt="<?php echo get_the_title($post->ID); ?>" title="<?php echo get_the_title($post->ID); ?>">
	</div>
	<h4 class="prod-item__title">
		<?php echo wp_trim_words( get_the_title($post->ID), 5, '' ); ?>
	</h4>

	<div class="prod-item__nav">
		<div class="prod-item__price">
			<?php 
				if(!empty($sale) && !empty($price)) { 
			?>
				<span class="prod-item__new-price">&euro; <?php echo round($sale, 2); ?></span>
				<span class="prod-item__old-price"><?php echo round($price, 2); ?> &euro;</span>
			<?php } else { ?>
				&euro; <?php echo round($price, 2); ?>
			<?php } ?>
		</div>
		<?php if( $product->is_type('variable') ) { ?>
			<div class="prod-item__add-cart">
				<?php if(!empty($sale) && empty($price) || empty($sale) && !empty($price)) { ?>
					<?php _e('Add to Cart','suuhygieen');?>
				<?php } ?>			
				<img src="<?php bloginfo('template_url');?>/img/icons/icon_shop_cart.svg">
			</div>
		<?php } else { ?>
		<button type="button" class="prod-item__add-cart cat_add_cart " data-quantity="1" data-product_id="<?php echo $post->ID;?>" data-product_sku="<?php echo $product->sku;?>">
			<?php if(!empty($sale) && empty($price) || empty($sale) && !empty($price)) { ?>
				<?php _e('Add to Cart','suuhygieen');?>
			<?php } ?>			
			<img src="<?php bloginfo('template_url');?>/img/icons/icon_shop_cart.svg">
		</button>
		<?php } ?>
	</div>
</a>



<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
global $product;
								
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
} else {
	
	$price = get_post_meta( $post->ID, '_regular_price', true);
	$sale = get_post_meta( $post->ID, '_sale_price', true);	
		if(!empty($sale) && !empty($price)) {  
			$sale = wc_get_price_including_tax( $product );  
			$price = wc_get_sale_price_including_tax( $product, array('price' => $price ) );  
		} else {
			$price = wc_get_sale_price_including_tax( $product, array('price' => $price ) );  
		}

}

?>
<style>
	.woocommerce-message{
		display:none;
	}
</style>
<main>
	<section class="main main-page ">
		<div class="container">
			<div class="main__inner">
				<div class="main-menu__wrap">
					<h2 class="main-menu__title">
						<?php _e('PRODUCT GROUPS','suuhygieen');?>
						<span class="main-menu__arr">
							<img src="<?php bloginfo('template_url');?>/img/icons/arr-b.svg">
						</span>
					</h2>
					<?php
						wp_nav_menu(array(  
							  'theme_location'  => 'sidebar_menu',
							  'menu' => 'sidebar_menu', 
							  'container_id' => '',  
							  'container' => false,
							  'menu_class' => 'main-menu',
							  'walker' => new Sidebar_Walker()
						)); 
					?>

				</div>

				<div class="main__content ">
					<div class="product">
						<div class="product__inner">
							<div class="product__image-wrap">
								<a href="<?php echo get_the_post_thumbnail_url($post->ID, 'large' ); ?>" class="product__image"
									style="background: url(<?php echo get_the_post_thumbnail_url($post->ID, 'large' ); ?>) no-repeat center/cover">
									<span class="product__image-icon">
										<img src="<?php bloginfo('template_url');?>/img/icons/zoom.svg" alt="" title="">
									</span>
								</a>
							</div>
						
							<div class="product__content">
								<h1 class="product__title">
									<?php the_title();?>
								</h1>
								<p class="product__subtitle">
									<?php the_excerpt();?>
								</p>
								<div class="product__wrap-price">
							 		<div class="product__wrap-price__inner">
										<?php if ($price && $sale) { ?>
										<div class="product-price__item product-price__new">
											<span class="product-price__title"><?php _e('sale price','suuhygieen');?></span>
											<span class="product-price">
												€ <?php echo round($sale, 2); ?>
											</span>
										</div>
										
										<div class="product-price__item product-price__old">
											<span class="product-price__title"><?php _e('original','suuhygieen');?></span>
											<span class="product-price">
												€ <?php echo round($price, 2); ?>
											</span>
										</div>
										<?php } else if (!empty($price) && empty($sale)) { ?>
											<div class="product-price__item ">
												<span class="product-price__title"><?php _e('original','suuhygieen');?></span>
												<span class="product-price">
													€ <?php echo round($price, 2); ?>
												</span>
											</div>
										<?php } ?>
									</div>
									
									<?php $barand = get_field('z_brand'); 
									if ($barand) {
									?>
									<div class="product__brand">
										<span class="product-price__title"><?php _e('brand','suuhygieen');?></span>
										<img src="<?php echo $barand; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">
									</div>
									<?php } ?>
								</div>
								<div class="product-nav">
									<?php do_action( 'woocommerce_single_product_summary' ); ?>
									
								</div>
								<div class="product__subs">
									<a href="javacript:;" class="product__subs-item">
										<img src="<?php bloginfo('template_url');?>/img/shopping-bag.svg" alt="" title="">
										<?php _e('Available for subscribe','suuhygieen');?>
									</a>
									<div id="fb-root" class="product__share"></div>
									<script>
										(function(d, s, id) {
											var js, fjs = d.getElementsByTagName(s)[0];
											if (d.getElementById(id)) return;
											js = d.createElement(s); js.id = id;
											js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
											fjs.parentNode.insertBefore(js, fjs);
										}(document, 'script', 'facebook-jssdk'));
									</script>

									  <!-- Your share button code -->
									  <div class="fb-share-button" 
										data-href="<?php the_permalink(); ?>" 
										data-layout="button_count">
								  </div>
	
								</div>
							</div>
						</div>
						<div class="product__info">
							<div class="product__info-inner">
								<ul class="nav nav-pills">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="pill" href="#tabs1"><?php _e('Description','suuhygieen');?></a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="pill" href="#tabs2"><?php _e('User Guide','suuhygieen');?></a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="pill" href="#tabs3"><?php _e('Composition','suuhygieen');?></a>
									</li>
								</ul>
								<?php if ($product->get_sku()) { ?>
									<div class="product__code">
										<span><?php _e('product code:','suuhygieen');?></span> <?php echo $product->get_sku(); ?>
									</div>
									<?php } ?>
							</div>

							<div class="tab-content">
								<div class="tab-pane active" id="tabs1">
									<?php the_content(); ?>
								</div>
								<div class="tab-pane fade" id="tabs2">
									<?php the_field('z_user_guide'); ?>
								</div>
								<div class="tab-pane fade" id="tabs3">
									<?php the_field('z_composition'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>


<section class="prod-wrap prod-wrap-product" id="prod">
	<div class="prod">
		<div class="container">
			<div class="prod__wrap-title">
				<h3 class="block-title"><?php _e('SIMILAR PRODUCTS','suuhygieen');?></h3>
				<a href="<?php bloginfo('url');?>/products/" class="prod-more">
					<?php _e('VIEW MORE PRODUCTS','suuhygieen');?>
					<img src="<?php bloginfo('template_url');?>/img/icons/arr-red-r.svg">
				</a>
			</div>
			<div class="prod__inner">
				<?php do_action( 'woocommerce_after_single_product_summary' ); ?>

			</div>

		</div>
	</div>
</section>





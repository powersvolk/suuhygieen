<?php
/*
Template Name: Discount
*/
?>

<?php get_header(); ?>
<main>
		<section class="main main-list-prod">
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
						<div class="category-prod">
							<h1 class="category__title">
								<?php the_title(); ?>
							</h1>

						</div>

					</div>

				</div>
			</div>
		</section>

		<section class="prod-wrap" id="prod">
			<div class="prod prod-list">
				<div class="container">
					<div class="prod__inner">
						
						<?php
							$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
							
							$total_pages = count(get_posts(array(
								'posts_per_page' => -1,
								'post_type'      => 'product',
								'meta_query'     => array(
									'relation' => 'OR',
									array( 
										'key'           => '_sale_price',
										'value'         => 0,
										'compare'       => '>',
										'type'          => 'numeric'
									),
									array(
										'key'           => '_min_variation_sale_price',
										'value'         => 0,
										'compare'       => '>',
										'type'          => 'numeric'
									)
								)
							)));
							
							
							$args = array(
							'post_type'      => 'product',
							'posts_per_page' => 15,
							'paged' => $paged,
							'meta_query'     => array(
								'relation' => 'OR',
								array( 
									'key'           => '_sale_price',
									'value'         => 0,
									'compare'       => '>',
									'type'          => 'numeric'
								),
								array(
									'key'           => '_min_variation_sale_price',
									'value'         => 0,
									'compare'       => '>',
									'type'          => 'numeric'
								)
							)
						);
						$query = new WP_Query( $args );
								if ( $query->have_posts() ) {
									while ( $query->have_posts() ) {
										$query->the_post();
							
							$price = get_post_meta( $post->ID, '_regular_price', true);
							$sale = get_post_meta( $post->ID, '_sale_price', true);	
							
							//$price_excl_tax = wc_get_price_excluding_tax( $product ); 
							//$price_sale_excl_tax = wc_get_sale_price_excluding_tax( $product, array('price' => $price ) ); 
							
							if(!empty($sale) && !empty($price)) {  
								$sale = wc_get_price_including_tax( $product );  
								$price = wc_get_sale_price_including_tax( $product, array('price' => $price ) );  
							} elseif (!empty($sale)) {
								$sale = wc_get_price_including_tax( $product );  
							} else {
								$price = wc_get_sale_price_including_tax( $product, array('price' => $price ) );  
							}
							
							//echo $product->get_price_including_tax(); 
								
							
							if(!empty($sale) && !empty($price)) {  
								$discount = 'prod-action';
							}	else {
								$discount = '';
							}	
						?>
							<a href="<?php echo get_the_permalink($post->ID); ?>" class="prod-item <?php echo $discount; ?>">
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
									<button type="button" class="prod-item__add-cart cat_add_cart " data-quantity="1" data-product_id="<?php echo $post->ID;?>" data-product_sku="<?php echo $product->sku;?>">
										<?php if(!empty($sale) && empty($price) || empty($sale) && !empty($price)) { ?>
											<?php _e('Add to Cart','suuhygieen');?>
										<?php } ?>			
										<img src="<?php bloginfo('template_url');?>/img/icons/icon_shop_cart.svg">
									</button>
								</div>
							</a>
						<?php
							}
						}
						wp_reset_postdata(); ?>
						
						
					</div>
					
					<?php
						$big = 999999999;
						$pagi_args = array(
							'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
							'format' => '?paged=%#%',
							'current' => max(1, get_query_var('paged')),
							'total' => ceil($total_pages / 15),
							'type' => 'plain',
							'prev_next'    => True,
							'prev_text'    => __('<img src="'.get_template_directory_uri().'/img/icons/arr-b.svg">'),
							'next_text'    => __('<img src="'.get_template_directory_uri().'/img/icons/arr-b.svg">'),
						);
						$navigation = paginate_links($pagi_args); 
						if ($navigation) {
					?>
					
					<div class="prod-nav__wrap">
						<div class="prod-nav">
							<div class="prod-nav__inner">
								<?php echo $navigation; ?>
							</div>
						</div>
					</div>
					<?php } ?>
					
					
				</div>
			</div>

		</section>

	</main>
<?php get_footer(); ?>
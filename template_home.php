	<?php
/*
Template Name: Home Page
*/
?>

<?php get_header(); 
global $product;
?>
<main>
		<section class="main main-home">
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
								  'menu_class' => 'main-menu main-menu-less',
								  'walker' => new Sidebar_Walker()
							)); 
						?>
						<a href="#" class="main-menu-more">
							<span class="main-menu-more__icon main-menu-more__icon-1">+</span>
							<span class="main-menu-more__icon main-menu-more__icon-2">-</span>
							<span class="main-menu-more-1"><?php _e('view more categories','suuhygieen');?></span>
							<span class="main-menu-more-2"><?php _e('view less categories','suuhygieen');?></span>
						</a>
					</div>

					<div class="main__content ">
						<div class="home-banner">

							<?php $banners = get_field('b_banner');
								if ($banners) {							
							?>
								<div class="home-banner__inner">
									<?php 
										foreach ($banners as $banner) {
										$banner_ID = $banner['b_image']['ID'];
										$banner_title = $banner['b_image']['title'];
										$banner_url = $banner['b_image']['sizes']['banner'];
									?>	
										<div class="home-banner__item">
											<div class="home-banner__full-image" >
												<img src="<?php echo $banner_url;?>" alt="<?php echo $banner_title; ?>" title="<?php echo $banner_title; ?>">
											</div>
										</div>
									<?php } ?>
								</div>
							<?php
							} ?>
							<div class="home-brands">

								<div class="home-brands__in">
									<h2 class="home-brands__title"><?php the_field('brands_title'); ?></h2>
									<?php $brands = get_field('brands_rep');
										if ($brands) {							
									?>
									<div class="home-brands__inner">
										<?php 
											foreach ($brands as $brand) {
											$brand_ID = $brand['brands_image']['ID'];
											$brand_title = $brand['brands_image']['title'];
											$brand_url = $brand['brands_image']['sizes']['brands'];
										?>
											<img src="<?php echo $brand_url;?>" alt="<?php echo $brand_title; ?>" title="<?php echo $brand_title; ?>">
										<?php } ?>
									</div>
									<?php } ?>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</section>

		<section class="prod-wrap" id="prod">


			<div class="prod">
				<div class="container">
					<div class="prod__wrap-title">
						<h3 class="block-title"><?php _e('Top products','suuhygieen');?></h3>
						<a href="<?php the_field('top_link');?>" class="prod-more"><?php _e('VIEW MORE PRODUCTS','suuhygieen');?>
							<img src="<?php bloginfo('template_url');?>/img/icons/arr-red-r.svg">
						</a>
					</div>
					<div class="prod__inner">
						<?php $tops = get_field('top_products'); 
							$WC_Product_Variable = new WC_Product_Variable();
							if ($tops) {
								foreach($tops as $top) {
									$product = wc_get_product( $top->ID );

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
										
										$price = get_post_meta( $top->ID, '_regular_price', true);
										$sale = get_post_meta( $top->ID, '_sale_price', true);	
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
						<a href="<?php echo get_the_permalink($top->ID); ?>" class="prod-item <?php echo $discount; ?>">
							<div class="prod-item__image">
								<img src="<?php echo get_the_post_thumbnail_url($top->ID, 'thumbnail' ); ?>" alt="<?php echo get_the_title($post->ID); ?>" title="<?php echo get_the_title($post->ID); ?>">
							</div>
							<h4 class="prod-item__title">
								<?php echo wp_trim_words( $top->post_title, 5, '' ); ?>
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
								<button type="button" class="prod-item__add-cart cat_add_cart " data-quantity="1" data-product_id="<?php echo $top->ID;?>" data-product_sku="<?php echo $product->sku;?>">
									<?php if(!empty($sale) && empty($price) || empty($sale) && !empty($price)) { ?>
										<?php _e('Add to Cart','suuhygieen');?>
									<?php } ?>			
									<img src="<?php bloginfo('template_url');?>/img/icons/icon_shop_cart.svg">
								</button>
								<?php } ?>
							</div>
						</a>
						<?php } } ?>
					</div>

				</div>
			</div>

			<div class="prod ">
				<div class="container">
					<div class="prod__wrap-title">
						<h3 class="block-title"><?php _e('DISCOUNT','suuhygieen');?></h3>
						<a href="<?php the_field('dis_discount_link'); ?>" class="prod-more"><?php _e('VIEW MORE PRODUCTS','suuhygieen');?>
							<img src="<?php bloginfo('template_url');?>/img/icons/arr-red-r.svg">
						</a>
					</div>
					<div class="prod__inner">
						<?php
							$args = array(
							'post_type'      => 'product',
							'posts_per_page' => 5,
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

				</div>
			</div>

			<div class="prod">
				<div class="container">
					<div class="prod__wrap-title">
						<h3 class="block-title"><?php _e('CHILDRENS ORAL HYGIENE','suuhygieen');?></h3>
						<a href="<?php the_field('children_link'); ?>" class="prod-more"><?php _e('VIEW MORE PRODUCTS','suuhygieen');?>
							<img src="<?php bloginfo('template_url');?>/img/icons/arr-red-r.svg">
						</a>
					</div>
					<div class="prod__inner">
						<?php
							$args = array(
							'post_type'      => 'product',
							'posts_per_page' => 5,
							'tax_query' => array(
								array(
								'taxonomy' => 'product_cat',
								'field' => 'slug',
								'terms' => 'childrems-oral-hygiene',
								),
							),
							);
							$query = new WP_Query( $args );
								if ( $query->have_posts() ) {
									while ( $query->have_posts() ) {
										$query->the_post();
							
							$product = wc_get_product( $post->ID );
								
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
									<?php if( $product->is_type('variable') ) { ?>
									<div class="prod-item__add-cart">
											<?php if(!empty($sale) && empty($price) || empty($sale) && !empty($price)) { ?>
												<?php _e('Add to Cart','suuhygieen');?>
											<?php } ?>			
											<img src="<?php bloginfo('template_url');?>/img/icons/icon_shop_cart.svg">
										</div>
									<?php } else { ?>
									<button type="button" class="prod-item__add-cart cat_add_cart " data-quantity="1" data-product_id="<?php echo $top->ID;?>" data-product_sku="<?php echo $product->sku;?>">
										<?php if(!empty($sale) && empty($price) || empty($sale) && !empty($price)) { ?>
											<?php _e('Add to Cart','suuhygieen');?>
										<?php } ?>			
										<img src="<?php bloginfo('template_url');?>/img/icons/icon_shop_cart.svg">
									</button>
									<?php } ?>
								</div>
							</a>
						<?php
							}
						}
						wp_reset_postdata(); ?>
						
						
					</div>

				</div>
			</div>
		</section>
		


		<section class="home-news">
			<div class="container">
				<div class="prod__wrap-title">
					<h3 class="block-title"><?php _e('NEWS','suuhygieen');?></h3>
					<a href="<?php the_field('news_link'); ?>" class="prod-more"><?php _e('VIEW MORE NEWS','suuhygieen');?>
						<img src="<?php bloginfo('template_url');?>/img/icons/arr-red-r.svg">
					</a>
				</div>
				<div class="home-news__inner">
					<?php
						$args = array(
							'post_type' => 'post',
							'order'     => 'DESC',
							'posts_per_page' => '3',
							'suppress_filters' => false,
						);
						$query = new WP_Query( $args );
						if ( $query->have_posts() ) {
							while ( $query->have_posts() ) {
								$query->the_post();
					?>
						<a href="<?php echo get_the_permalink($post->ID); ?>" class="home-news__item">
							<div class="home-news__image" style="background: url(<?php echo get_the_post_thumbnail_url($post->ID, 'news' ); ?>) no-repeat center/cover">

							</div>
							<div class="home-news__content">
								<h4 class="home-news__title">
									<?php echo get_the_title($post->ID); ?>
								</h4>
								<p class="home-news__info"><?php echo get_the_excerpt($post->ID); ?></p>
								<div class="home-news__nav">
									<span class="home-news-more btn-more">
										<?php _e('Read more','suuhygieen');?>
										<img src="<?php bloginfo('template_url');?>/img/icons/arr-dark-r.svg">
									</span>
									<span class="home-news__date ">
										<img src="<?php bloginfo('template_url');?>/img/icons/clock.svg">
										<?php echo get_the_time('d.m.Y',$post->ID); ?>
									</span>
								</div>
							</div>
						</a>
					<?php
						}
					}
					wp_reset_postdata(); ?>

				</div>
			</div>
		</section>


		<section class="subscribe">
			<div class="container">
				<div class="subscribe__inner">
					<div class="subscribe__content">
						<h2 class="subscribe__title">
							<?php the_field('s_title');?>
							<img src="<?php bloginfo('template_url');?>/img/icons/big-arrow.svg">
						</h2>
						<p class="subscribe__info">
							<?php the_field('s_sub_title');?>
						</p>
						<?php $s_link = get_field('s_link');
							if ($s_link) {
						?>
							<a href="<?php the_field('s_link');?>" class="btn-more subscribe__more">
								<?php _e('view products','suuhygieen');?>
								<img src="<?php bloginfo('template_url');?>/img/icons/arr-white-r.svg">
							</a>
						<?php } ?>
					</div>
					<?php $gallerys = get_field('s_gallery');
						if ($gallerys) {
					?>
						<div class="subscribe__gallery">
							<?php foreach ($gallerys as $gallery) { ?>
								<a href="<?php echo $gallery['url']; ?>" style="background: url(<?php echo $gallery['url']; ?>) no-repeat center/cover">
									<img src="<?php echo $gallery['url']; ?>">
								</a>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</section>
		
		<section class="partner">
			<div class="container">
				<div class="partner-in">
					<h2 class="partner__title"><?php the_field('partners_title');?></h2>
					<p class="partner__subtitle">
						<?php the_field('partners_sub_title');?>
					</p>
					<?php $partners = get_field('partners_partners'); 
						if ($partners) {
					?>
					<ul class="partner__inner">
						<?php foreach($partners as $partner) { 
							$partner_title = $partner['partners_title_in'];
							$partner_url = $partner['partners_link'];
						?>
							<li class="partner__item">
								<a href="<?php echo $partner_url; ?>" class="partner__link">
									<?php echo $partner_title; ?>
								</a>
							</li>
						<?php } ?>
					</ul>
					<?php } ?>
				</div>
			</div>
		</section>


	</main>
<?php get_footer(); ?>
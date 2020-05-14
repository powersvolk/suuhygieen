<?php get_header(); ?>
<main>
		<section class="main main-page">
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
<?php if ( have_posts() ){ 
	while ( have_posts() ){
		the_post();?>
					<div class="main__content ">
						<div class="news">

							<div class="main__content-inner">
								<h1 class="news__title">
									<?php the_title();?>
								</h1>
								<div class="news__subinfo">
									<span class="news-date">
										<img src="<?php bloginfo('template_url');?>/img/icons/clock.svg">
										<?php the_time('d.m.Y');?>
									</span>
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
								<div class="news__content">
									<?php the_content(); ?>
								</div>
							</div>

						</div>

					</div>
<?php } } ?>					
					
				</div>
			</div>
		</section>


	</main>
<?php get_footer(); ?>
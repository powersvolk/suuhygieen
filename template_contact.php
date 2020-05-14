<?php
/*
Template Name: Contact
*/
?>

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

					<div class="main__content ">
						<div class="contact">

							<div class="main__content-inner">
								<div class="contact__wrap-title">
									<h1 class="contact__title">
										<?php the_title(); ?>
									</h1>
									<span class="contact__subtitle">
										<img src="<?php bloginfo('template_url');?>/img/icons/bbp.svg">
										<?php _e('Baltic Business Partners OÜ','suuhygieen');?>
									</span>
								</div>
								<?php echo do_shortcode('[contact-form-7 id="138" title="Contact"]');?>
							</div>

						</div>

					</div>
				</div>
			</div>
		</section>


	</main>
<?php get_footer(); ?>
<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );
global $product;
?>


<main>
		<section class="main main-list-prod">
			<div class="container">
				<div class="main__inner">
					<div class="main__content ">
						<div class="category-prod">
							<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
								<h1 class="category__title"><?php woocommerce_page_title(); ?></h1>
							<?php endif; ?>
							<?php if ( woocommerce_product_loop() ) { 
									do_action( 'woocommerce_before_shop_loop' );
								} 
							?>
							
						</div>
					</div>

				</div>
			</div>
		</section>

<?php
if ( woocommerce_product_loop() ) {
?>
<section class="prod-wrap" id="prod">
	<div class="prod prod-list">
		<div class="container">
			<div class="prod__inner">
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
			<div class="main__content__products ">
<?php
	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();
			do_action( 'woocommerce_shop_loop' );
			wc_get_template_part( 'content', 'product' );
		}
	}
?>
			</div>


			</div>
		</div>
	</div>
</section>

			<?php	
				do_action( 'woocommerce_after_shop_loop' );
			?>
	
<?php	
} 

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );
?>


</main>
<?php
get_footer( 'shop' );

<?php
/*
Template Name: News
*/
?>

<?php get_header(); ?>
<main>
	<section class="home-news">
			<div class="container">
				<div class="prod__wrap-title">
					<h3 class="block-title"><?php the_title();?></h3>
				</div>
				<div class="home-news__inner">
					<?php
						$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

						$total_pages = count(get_posts(array(
							'posts_per_page' => -1,
						)));

						$args = array(
							'post_type' => 'post',
							'order'     => 'DESC',
							'posts_per_page' => '12',
							'suppress_filters' => false,
							'paged' => $paged,
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
				<?php
					$big = 999999999;
					$pagi_args = array(
						'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
						'format' => '?paged=%#%',
						'current' => max(1, get_query_var('paged')),
						'total' => ceil($total_pages / 12),
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
		</section>	

</main>
<?php get_footer(); ?>
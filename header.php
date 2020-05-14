<!DOCTYPE html>
<html>
<head>
	<title><?php bloginfo('name'); ?><?php wp_title('|'); ?></title>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body>

<?php global $woocommerce; ?>
	<div class="preloader">

	</div>

	<header class="">
		<div class="container">
			<div class="header__inner">

				<div class="header__logo__wrap">
					<a href="<?php bloginfo('url');?>" class="header__logo">
						<img src="<?php the_field('h_logo','option'); ?>" alt="Suuhygieen" title="Suuhygieen">
					</a>
				</div>
				<div class="language">
					<?php
					$languages = icl_get_languages('skip_missing=0&orderby=code');
					if(!empty($languages)){
							echo '<select onchange="document.location.href=this.options[this.selectedIndex].value;">';
								foreach($languages as $l){
									$opt_attr = $l['active'] ? 'class="icl_lang_sel_current" selected="selected"' : 'class="menu-item"';
									if ($l['language_code'] == 'et') {
										echo '<option ' . $opt_attr .' value="' . $l['url'] . '">Est</option>';
									} else if ($l['language_code'] == 'en') {
										echo '<option ' . $opt_attr .' value="' . $l['url'] . '">Eng</option>';
									}
								}
							echo '</select>';
						}
					?>
				</div>
				<div class="wrap__menu">
					<?php
						wp_nav_menu(array(  
							  'theme_location'  => 'top_menu',
							  'menu' => 'top_menu', 
							  'container_id' => '',  
							  'container' => false,
							  'menu_class' => 'nav menu',
							  'walker' => new Top_Walker()
						)); 
					?>
				</div>
				<div class="header-nav">
					<?php
						$tax = WC()->cart->get_taxes( );
						$cart_total = WC()->cart->get_subtotal(); 
						
						
						$tax = str_replace(',','.',$tax[2] );
						$cart_total = str_replace(',','.',$cart_total );
						$cat_tax_total = $tax + $cart_total;
					?>
				
					<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="header-nav__item header-cart cart-contents">
						<div class="header-nav__icon">
							<img src="<?php bloginfo('template_url');?>/img/icons/icon_shop_cart2.svg">
							<span class="header-cart__num"><?php echo  WC()->cart->get_cart_contents_count(); ?></span>
						</div>
						<div class="header-nav__info">
							<h4 class="header-nav__title"><?php _e('Cart','suuhygieen');?></h4>
							<p class="header-nav__subtitle"><?php echo  WC()->cart->get_cart_contents_count(); ?> <?php _e('item(s)','suuhygieen');?> - <?php echo $cat_tax_total; ?>&euro;</p>
						</div>
						
					</a>
					<?php if( !is_user_logged_in() ) {  ?>
						<a href="#" class="header__login header-nav__item">
							<div class="header-nav__icon">
								<img src="<?php bloginfo('template_url');?>/img/icons/person.svg">
							</div>
							
							<div class="header-nav__info">
								<h4 class="header-nav__title"><?php _e('Login','suuhygieen');?></h4>
								<p class="header-nav__subtitle"><?php _e('Or create new account','suuhygieen');?></p>
							</div>
						</a>
					<?php } else { ?>
						<?php $current_user = wp_get_current_user(); ?>
						<a href="<?php bloginfo('url');?>/my-account/" class="header-nav__item">
							<div class="header-nav__icon">
								<img src="<?php bloginfo('template_url');?>/img/icons/person.svg">
							</div>
							<div class="header-nav__info">
								<h4 class="header-nav__title"><?php _e('Welcome','suuhygieen');?></h4>
								<p class="header-nav__subtitle"><?php echo $current_user->display_name; ?></p>
							</div>
						</a>
					<?php } ?>
					
					<div class="header-search">
						<div class="header-search__btn">
							<img src="<?php bloginfo('template_url');?>/img/icons/search.svg">
							<span class="header-search__subtitle">
								<?php _e('Search','suuhygieen');?>
							</span>
						</div>
						<?php  get_search_form(); ?>
						

					</div>
				</div>
				<div class="wrap__burger">
					<div class="burger">
						<div class="burger__inner"></div>
					</div>
				</div>
			</div>
		</div>
	</header>

<?php
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}


add_theme_support( 'post-thumbnails' );

if( function_exists('acf_add_options_page') ) {
  acf_add_options_page('Seaded');
}

register_nav_menus(array(
	'header_menu' => 'Header',
));


function print_v($args){
	echo '<pre>';
	print_r($args);
	echo '</pre>';
	
	
	return $print;
}

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'banner', 1680, 525, true );
	add_image_size( 'brands', 110, 40, true );
	add_image_size( 'news', 875, 465, true );
	
	
	add_image_size( 'gallery', 1200, 1200, true );
	add_image_size( 'team', 488, 370, true );
	add_image_size( 'product', 750, 350, true );
	add_image_size( 'product-gallery', 810, 1200, true );
}


add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
function theme_name_scripts() {

	wp_enqueue_style( 'my-font', 'https://fonts.googleapis.com/css?family=Barlow:400,500,600,700,800,900&display=swap');
	wp_enqueue_style( 'my-style', get_template_directory_uri() . '/css/style.css');
	wp_enqueue_style( 'my-lightgallery', get_template_directory_uri() . '/css/lightgallery.css');
	wp_enqueue_style( 'my-owl', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css');
	wp_enqueue_style( 'my-select', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css');
	wp_enqueue_style( 'my-bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css');
	
	wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-3.2.1.min.js', array(), '1.0.0', true );
	wp_enqueue_script( 'js-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array(), '1.0.0', true );
	wp_enqueue_script( 'js-select', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.js', array(), '1.0.0', true );
	wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', array(), '1.0.0', true );
	wp_enqueue_script( 'js-lightgallery', get_template_directory_uri() . '/js/lightgallery.min.js', array(), '1.0.0', true );
	
	
    wp_enqueue_script('woocommerce-ajax-add-to-cart', get_template_directory_uri() . '/js/ajax-add-to-cart.js', array('jquery'), '', true);
   
   
	
   
	
	wp_enqueue_script( 'my-script', get_template_directory_uri() . '/js/script.js', array(), '1.0.0', true );

	wp_localize_script( 'my-script', 'MyAjax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'security' => wp_create_nonce( 'my-special-string' ),
		'redirecturl' => home_url(),
		'loadingmessage' => __('Sending user info, please wait...'),
	));
	
}

if(class_exists('acf')) {
	require get_template_directory() . '/lib/acf-nav-menu-selector/nav-menu-v5.php';
}



function my_myme_types($mime_types){
    $mime_types['svg'] = 'image/svg+xml';
	$mime_types['pdf'] = 'application/pdf';
	$mime_types['doc'] = 'application/msword';
	$mime_types['docx'] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';

    return $mime_types;
}
add_filter('upload_mimes', 'my_myme_types', 1, 1);


class Top_Walker extends Walker {

  var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

  function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class='nav submenu'>\n";
  }

  function end_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "$indent</ul>\n";
  }

  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

  
    global $wp_query;
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    $class_names = $value = '';        
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
	
    /* Add active class */
    if(in_array('current-menu-item', $classes)) {
      $classes[] = 'menu__item-current';
      unset($classes['current-menu-item']);
    }

    /* Check for children */
    $children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
    if (!empty($children)) {
      $classes[] = 'has-sub';
    }

    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . ' menu__item menu__current_item "' : '';

    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
    $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

    $output .= $indent . '<li' . $id . $value . $class_names .' >';

    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .' class="menu__link">';
    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
	$item_output .= '</a>';
    $item_output .= $args->after;
	
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }

  function end_el( &$output, $item, $depth = 0, $args = array() ) {
    $output .= "</li>\n";
  }
}


class Sidebar_Walker extends Walker {

  var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

  function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class='main-submenu'>\n";
  }

  function end_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "$indent</ul>\n";
  }

  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

  
    global $wp_query;
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    $class_names = $value = '';        
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
	
    /* Add active class */
    if(in_array('current-menu-item', $classes)) {
      $classes[] = 'menu__item-current';
      unset($classes['current-menu-item']);
    }

    /* Check for children */
    $children = get_posts(array('post_type' => 'nav_menu_item', 'nopaging' => true, 'numberposts' => 1, 'meta_key' => '_menu_item_menu_item_parent', 'meta_value' => $item->ID));
    if (!empty($children)) {
      $classes[] = 'has-sub';
    }

	if ($depth > 0) {
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . ' main-submenu__item "' : '';
	} else {
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . ' main-menu__item "' : '';
	}


    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
    $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

    $output .= $indent . '<li' . $id . $value . $class_names .' >';

    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

    $item_output = $args->before;
    
	if ($depth > 0) {
		$item_output .= '<a'. $attributes .' class="main-submenu__link">';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
	} else {
		$item_output .= '<a'. $attributes .' class="main-menu__link">';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		if (!empty($children)) {
			$item_output .= '<span class="main-menu__icon"><img src="'. get_template_directory_uri() .'/img/icons/arr-b.svg"></span>';
		}
		$item_output .= '</a>';
	}
    $item_output .= $args->after;
	
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }

  function end_el( &$output, $item, $depth = 0, $args = array() ) {
    $output .= "</li>\n";
  }
}


add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
  echo '<style>
    .wp-block {
		max-width:100%;
	}
	.adminbar-button{
		display:none !important;
	}
  </style>';
}

add_filter( 'allowed_block_types', 'misha_allowed_block_types' );
 
function misha_allowed_block_types( $allowed_blocks) {
	global $post;
	$page_template_slug = get_post_meta( $post->ID, '_wp_page_template', true );
	if ($post->post_type == 'post') {
		return array(
			'acf/news-content',
		);
	} 
	
}

function be_register_blocks() {
    if( ! function_exists('acf_register_block') )
        return;
    acf_register_block( array(
        'name'			=> 'news-content',
        'title'			=> __( 'News text', 'text' ),
        'render_template'	=> 'block_template/news-text.php',
        'category'		=> 'formatting',
        'icon'			=> 'admin-users',
        'mode'			=> 'edit',
        'keywords'		=> array('text')
    ));

}
add_action('acf/init', 'be_register_blocks' );


add_filter( 'use_block_editor_for_post', 'disable_gutenberg_for_post', 10, 2 );
function disable_gutenberg_for_post( $use, $post ){
	$page_template_slug = get_post_meta( $post->ID, '_wp_page_template', true );
	
	if( $post->post_type == 'page') { 
		return false;
	}
	if( $post->post_type == 'post') { 
		return false;
	}
	return $use;
}


add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
        
function woocommerce_ajax_add_to_cart() {

	$product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
	$quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
	$variation_id = absint($_POST['variation_id']);
	$passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
	$product_status = get_post_status($product_id);

	if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

		do_action('woocommerce_ajax_added_to_cart', $product_id);

		if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
			wc_add_to_cart_message(array($product_id => $quantity), true);
		}

		WC_AJAX :: get_refreshed_fragments();
	} else {

		$data = array(
			'error' => true,
			'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

		echo wp_send_json($data);
	}

	wp_die();
}



add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	$tax = $woocommerce->cart->get_taxes( );
	$cart_total = $woocommerce->cart->get_subtotal(); 
			
	$tax = str_replace(',','.',$tax[2] );
	$cart_total = str_replace(',','.',$cart_total );
	$cat_tax_total = $tax + $cart_total; 
	?>
	<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="header-nav__item header-cart cart-contents">
		<div class="header-nav__icon">
			<img src="<?php bloginfo('template_url');?>/img/icons/icon_shop_cart2.svg">
			<span class="header-cart__num"><?php echo sprintf (_n( '%d', '%d', WC()->cart->cart_contents_count ), WC()->cart->cart_contents_count ); ?></span>
		</div>
		<div class="header-nav__info">
			<h4 class="header-nav__title"><?php _e('Cart','suuhygieen');?></h4>
			<p class="header-nav__subtitle"><?php echo sprintf (_n( '%d', '%d', WC()->cart->cart_contents_count ), WC()->cart->cart_contents_count ); ?> <?php _e('item(s)','suuhygieen');?> - <?php echo $cat_tax_total; ?> &euro;</p>
		</div>
		
	</a>
	<?php
	
	$fragments['a.cart-contents'] = ob_get_clean();
	
	return $fragments;
}


remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);


remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);


add_filter( 'woocommerce_cart_item_thumbnail', 'change_image_size_in_cart', 10, 2 );

function change_image_size_in_cart( $product_image, $cart_item ) {

	if( is_cart() ) {
		$product = $cart_item['data'];

		$product_image = $product->get_image( 'thumbnail' );
	}

	return $product_image;
}


function wc_cart_totals_coupon_new( $coupon ) {
	if ( is_string( $coupon ) ) {
		$coupon = new WC_Coupon( $coupon );
	}

	$discount_amount_html = '';

	$amount               = WC()->cart->get_coupon_discount_amount( $coupon->get_code(), WC()->cart->display_cart_ex_tax );
	$discount_amount_html = wc_price( $amount );

	if ( $coupon->get_free_shipping() && empty( $amount ) ) {
		$discount_amount_html = __( 'Free shipping coupon', 'woocommerce' );
	}

	$discount_amount_html = apply_filters( 'woocommerce_coupon_discount_amount_html', $discount_amount_html, $coupon );
	$coupon_html          = $discount_amount_html . ' <a href="' . esc_url( add_query_arg( 'remove_coupon', rawurlencode( $coupon->get_code() ), defined( 'WOOCOMMERCE_CHECKOUT' ) ? wc_get_checkout_url() : wc_get_cart_url() ) ) . '" class="woocommerce-remove-coupon" data-coupon="' . esc_attr( $coupon->get_code() ) . '">' . __( 'Remove', 'woocommerce' ) . '</a>';

	echo wp_kses( apply_filters( 'woocommerce_cart_totals_coupon_html', $coupon_html, $coupon, $discount_amount_html ), array_replace_recursive( wp_kses_allowed_html( 'post' ), array( 'a' => array( 'data-coupon' => true ) ) ) ); // phpcs:ignore PHPCompatibility.PHP.NewFunctions.array_replace_recursiveFound
}

//add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );



function wc_get_sale_price_excluding_tax( $product, $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'qty'   => '',
			'price' => '',
		)
	);

	$price = '' !== $args['price'] ? max( 0.0, (float) $args['price'] ) : $product->get_price();
	$qty   = '' !== $args['qty'] ? max( 0.0, (float) $args['qty'] ) : 1;

	if ( '' === $price ) {
		return '';
	} elseif ( empty( $qty ) ) {
		return 0.0;
	}

	$line_price = $price * $qty;

	if ( $product->is_taxable() && wc_prices_include_tax() ) {
		$tax_rates      = WC_Tax::get_rates( $product->get_tax_class() );
		$base_tax_rates = WC_Tax::get_base_tax_rates( $product->get_tax_class( 'unfiltered' ) );
		$remove_taxes   = apply_filters( 'woocommerce_adjust_non_base_location_prices', true ) ? WC_Tax::calc_tax( $line_price, $base_tax_rates, true ) : WC_Tax::calc_tax( $line_price, $tax_rates, true );
		$return_price   = $line_price - array_sum( $remove_taxes ); // Unrounded since we're dealing with tax inclusive prices. Matches logic in cart-totals class. @see adjust_non_base_location_price.
	} else {
		$return_price = $line_price;
	}

	return apply_filters( 'woocommerce_get_price_excluding_tax', $return_price, $qty, $product );
}


function wc_get_sale_price_including_tax( $product, $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'qty'   => '',
			'price' => '',
		)
	);

	$price = '' !== $args['price'] ? max( 0.0, (float) $args['price'] ) : $product->get_price();
	$qty   = '' !== $args['qty'] ? max( 0.0, (float) $args['qty'] ) : 1;

	if ( '' === $price ) {
		return '';
	} elseif ( empty( $qty ) ) {
		return 0.0;
	}

	$line_price   = $price * $qty;
	$return_price = $line_price;

	if ( $product->is_taxable() ) {
		if ( ! wc_prices_include_tax() ) {
			$tax_rates = WC_Tax::get_rates( $product->get_tax_class() );
			$taxes     = WC_Tax::calc_tax( $line_price, $tax_rates, false );

			if ( 'yes' === get_option( 'woocommerce_tax_round_at_subtotal' ) ) {
				$taxes_total = array_sum( $taxes );
			} else {
				$taxes_total = array_sum( array_map( 'wc_round_tax_total', $taxes ) );
			}

			$return_price = round( $line_price + $taxes_total, wc_get_price_decimals() );
		} else {
			$tax_rates      = WC_Tax::get_rates( $product->get_tax_class() );
			$base_tax_rates = WC_Tax::get_base_tax_rates( $product->get_tax_class( 'unfiltered' ) );

			/**
			 * If the customer is excempt from VAT, remove the taxes here.
			 * Either remove the base or the user taxes depending on woocommerce_adjust_non_base_location_prices setting.
			 */
			if ( ! empty( WC()->customer ) && WC()->customer->get_is_vat_exempt() ) { // @codingStandardsIgnoreLine.
				$remove_taxes = apply_filters( 'woocommerce_adjust_non_base_location_prices', true ) ? WC_Tax::calc_tax( $line_price, $base_tax_rates, true ) : WC_Tax::calc_tax( $line_price, $tax_rates, true );

				if ( 'yes' === get_option( 'woocommerce_tax_round_at_subtotal' ) ) {
					$remove_taxes_total = array_sum( $remove_taxes );
				} else {
					$remove_taxes_total = array_sum( array_map( 'wc_round_tax_total', $remove_taxes ) );
				}

				$return_price = round( $line_price - $remove_taxes_total, wc_get_price_decimals() );

				/**
			 * The woocommerce_adjust_non_base_location_prices filter can stop base taxes being taken off when dealing with out of base locations.
			 * e.g. If a product costs 10 including tax, all users will pay 10 regardless of location and taxes.
			 * This feature is experimental @since 2.4.7 and may change in the future. Use at your risk.
			 */
			} elseif ( $tax_rates !== $base_tax_rates && apply_filters( 'woocommerce_adjust_non_base_location_prices', true ) ) {
				$base_taxes   = WC_Tax::calc_tax( $line_price, $base_tax_rates, true );
				$modded_taxes = WC_Tax::calc_tax( $line_price - array_sum( $base_taxes ), $tax_rates, false );

				if ( 'yes' === get_option( 'woocommerce_tax_round_at_subtotal' ) ) {
					$base_taxes_total   = array_sum( $base_taxes );
					$modded_taxes_total = array_sum( $modded_taxes );
				} else {
					$base_taxes_total   = array_sum( array_map( 'wc_round_tax_total', $base_taxes ) );
					$modded_taxes_total = array_sum( array_map( 'wc_round_tax_total', $modded_taxes ) );
				}

				$return_price = round( $line_price - $base_taxes_total + $modded_taxes_total, wc_get_price_decimals() );
			}
		}
	}
	return apply_filters( 'woocommerce_get_price_including_tax', $return_price, $qty, $product );
}







/**
 * New User registration
 *
 */
function vb_reg_new_user() {
 
  // Verify nonce
  if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'vb_new_user' ) )
    die( 'Ooops, something went wrong, please try again later.' );

  // Post values
	$first = $_POST['first'];
	$last = $_POST['last'];
	$mail    = $_POST['mail'];
	$phone     = $_POST['phone'];
	$nick     = $_POST['nick'];
 	$pass     = $_POST['pass'];
	$company     = $_POST['company'];
	$regcode     = $_POST['regcode'];
	
	
 	/**
 	 * IMPORTANT: You should make server side validation here!
 	 *
 	 */

	$userdata = array(
		'first_name' 	=> 	$first,
		'last_name' 	=> 	$last,
		'user_email' 	=> 	$mail,
		'billing_phone' =>	$phone,
		'user_login'	=> 	$nick,
		'nickname' 		=> 	$nick,
		'user_pass' 	=> 	$pass,
		'billing_company' => $company,
	);

	$user_id = wp_insert_user( $userdata ) ;

	//On success
	if( !is_wp_error($user_id) ) {
		echo '1';
		update_user_meta($user_id, 'reg_code', $regcode );
		update_user_meta($user_id, 'billing_company', $company );
		update_user_meta($user_id, 'billing_phone', $phone );
	} else {
		echo $user_id->get_error_message();
	} 
  die();
	
}
 
add_action('wp_ajax_register_user', 'vb_reg_new_user');
add_action('wp_ajax_nopriv_register_user', 'vb_reg_new_user');



if (!is_user_logged_in()) {
	add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
}

function ajax_login(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.','suuhygieen')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...','suuhygieen')));
    }

    die();
}



function ajax_forgotPassword(){
	 
	// First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-forgot-nonce', 'security' );
	
	global $wpdb;
	
	$account = $_POST['user_login'];
	
	if( empty( $account ) ) {
		$error = 'Enter an username or e-mail address.';
	} else {
		if(is_email( $account )) {
			if( email_exists($account) ) 
				$get_by = 'email';
			else	
				$error = _e('There is no user registered with that email address.','suuhygieen');			
		}
		else if (validate_username( $account )) {
			if( username_exists($account) ) 
				$get_by = 'login';
			else	
				$error = __('There is no user registered with that username.','suuhygieen');				
		}
		else
			$error = __('Invalid username or e-mail address.','suuhygieen');		
	}	
	
	if(empty ($error)) {
		// lets generate our new password
		//$random_password = wp_generate_password( 12, false );
		$random_password = wp_generate_password();

			
		// Get user data by field and data, fields are id, slug, email and login
		$user = get_user_by( $get_by, $account );
			
		$update_user = wp_update_user( array ( 'ID' => $user->ID, 'user_pass' => $random_password ) );
			
		// if  update user return true then lets send user an email containing the new password
		if( $update_user ) {
			
			$from = 'WRITE SENDER EMAIL ADDRESS HERE'; // Set whatever you want like mail@yourdomain.com
			
			if(!(isset($from) && is_email($from))) {		
				$sitename = strtolower( $_SERVER['SERVER_NAME'] );
				if ( substr( $sitename, 0, 4 ) == 'www.' ) {
					$sitename = substr( $sitename, 4 );					
				}
				$from = 'admin@'.$sitename; 
			}
			
			$to = $user->user_email;
			$subject = 'Your new password';
			$sender = 'From: '.get_option('name').' <'.$from.'>' . "\r\n";
			
			$message = 'Your new password is: '.$random_password;
				
			$headers[] = 'MIME-Version: 1.0' . "\r\n";
			$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers[] = "X-Mailer: PHP \r\n";
			$headers[] = $sender;
				
			$mail = wp_mail( $to, $subject, $message, $headers );
			if( $mail ) 
				$success = __('Check your email address for you new password.','suuhygieen');
			else
				$error = __('System is unable to send you mail containg your new password.','suuhygieen');						
		} else {
			$error = __('Oops! Something went wrong while updaing your account.','suuhygieen');
		}
	}
	
	if( ! empty( $error ) )
		//echo '<div class="error_login"><strong>ERROR:</strong> '. $error .'</div>';
		echo json_encode(array('loggedin'=>false, 'message'=>__($error)));
			
	if( ! empty( $success ) )
		//echo '<div class="updated"> '. $success .'</div>';
		echo json_encode(array('loggedin'=>false, 'message'=>__($success)));
				
	die();
}
add_action( 'wp_ajax_ajax_forgotPassword', 'ajax_forgotPassword' );
add_action( 'wp_ajax_nopriv_ajaxforgotpassword', 'ajax_forgotPassword' );

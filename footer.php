<footer>
		<div class="container">
			<div class="footer__inner">
				<div class="footer__item">
					<h3 class="block-title footer__title">
						<?php the_field('f_title_1','option'); ?>
					</h3>
					<?php
						wp_nav_menu(array(  
							  'theme_location'  => 'footer_menu_col1',
							  'menu' => 'footer_menu_col1', 
							  'container_id' => '',  
							  'container' => false,
							  'menu_class' => '',
						)); 
					?>
				</div>
				<div class="footer__item">
					<h3 class="block-title footer__title">
						<?php the_field('f_title_2','option'); ?>
					</h3>
					<?php
						wp_nav_menu(array(  
							  'theme_location'  => 'footer_menu_col2',
							  'menu' => 'footer_menu_col2', 
							  'container_id' => '',  
							  'container' => false,
							  'menu_class' => '',
						)); 
					?>
				</div>
				<div class="footer__item">
					<h3 class="block-title footer__title">
						<?php the_field('f_title_3','option'); ?>
					</h3>
					<?php if( !is_user_logged_in() ) {  ?>
					<ul>
						<li><a href=""><?php _e('My account','suuhygieen');?></a></li>
						<li><a href=""><?php _e('Order history','suuhygieen');?></a></li>
					</ul>
					<?php } else { 
						wp_nav_menu(array(  
							  'theme_location'  => 'footer_menu_col3',
							  'menu' => 'footer_menu_col3', 
							  'container_id' => '',  
							  'container' => false,
							  'menu_class' => '',
						)); 
					}
					?>
					
				</div>
				<div class="footer__item footer-socio">
					<div class="footer-socio__item">
						<div class="footer-socio__icon">
							<img src="<?php bloginfo('template_url');?>/img/icons/location.svg">
						</div>
						<div class="footer-socio__content">
							<h4 class="footer-socio__title">
								<?php the_field('f_adress_1','option'); ?>
							</h4>
							<p class="footer-socio__subtitle">
								<?php the_field('f_adress_2','option'); ?>
							</p>
						</div>
					</div>
					<div class="footer-socio__item">
						<div class="footer-socio__icon">
							<img src="<?php bloginfo('template_url');?>/img/icons/icon-phone.svg">
						</div>
						<div class="footer-socio__content">
							<p class="footer-socio__subtitle">
								<?php the_field('f_phone_1','option'); ?>
							</p>
							<a href="tel:<?php the_field('f_phone_2','option'); ?>" class="footer-socio__title">
								<?php the_field('f_phone_2','option'); ?>
							</a>

						</div>
					</div>
					<div class="footer-socio__item">
						<div class="footer-socio__icon">
							<img src="<?php bloginfo('template_url');?>/img/icons/mail.svg">
						</div>
						<div class="footer-socio__content">
							<p class="footer-socio__subtitle">
								<?php the_field('e_email_1','option'); ?>
							</p>
							<a href="mailto:<?php the_field('e_email_2','option'); ?>" class="footer-socio__title">
								<?php the_field('e_email_2','option'); ?>
							</a>

						</div>
					</div>
				</div>

			</div>
			<div class="footer__bottom">
				<div class="footer__bottom-left">
					<p class="footer__copy">
						<?php the_field('f_copyright','option'); ?>
					</p>
					<a href="<?php the_field('f_facebook','option'); ?>" class="footer-facebook">
						<img src="<?php bloginfo('template_url');?>/img/icons/icon-facebook.svg">
						<?php _e('Follow Us','suuhygieen');?>
					</a>
				</div>
				<div class="footer__bottom-right">
					<?php _e('Made by','suuhygieen');?> <a href="http://camo.ee/" target="_blank">CAMO</a>
				</div>
			</div>
		</div>
	</footer>


	<div class="popup-wrap">

	</div>
	<div class="popup">

		<div class="popup__inner" id="popLogin">
			<a type="button" class="popup-close">
				<img src="<?php bloginfo('template_url');?>/img/icons/close.svg">
			</a>
			<div class="popup-tab">
				<ul class="nav nav-pills popup-tab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="pill" href="#tab1"><?php _e('LOGIN','suuhygieen');?></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="pill" href="#tab2"><?php _e('CREATE ACCOUNT','suuhygieen');?></a>
					</li>
				</ul>
			</div>
			<div class="tab-content">
				<div id="tab1" class="tab-pane active">
					<form id="login" action="login" method="post">
						<input id="username" type="text" name="username" placeholder="<?php _e('Username','suuhygieen');?>">
						<div class="wrap-password">
							<input type="password" name="password" id="password" placeholder="<?php _e('Password','suuhygieen');?>">
							<a href="#" class="forgot-password">
								<?php _e('forgot password','suuhygieen');?>
							</a>
						</div>
						<input class="submit_button" type="submit" value="<?php _e('Sign in','suuhygieen');?>" name="submit">
						<?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
					</form>

				</div>
				<div id="tab2" class="tab-pane fade">
					
					<div class="vb-registration-form">
					  <form class="form-horizontal registraion-form" role="form">
							<label class="form__checkbox-person">
								<input type="checkbox">
								<span class="form__checkbox-person__inner">
									<?php _e('Ettevõte','suuhygieen');?>
								</span>
							</label>
							
							<input id="vb_first" type="text" placeholder="<?php _e('First name','suuhygieen');?>">
							<input id="vb_last" type="text" placeholder="<?php _e('Last name','suuhygieen');?>">
							<input id="vb_email" type="email" placeholder="<?php _e('Email','suuhygieen');?>">
							<input id="vb_phone" type="phone" placeholder="<?php _e('Phone','suuhygieen');?>">
							<input id="vb_nick" type="text" value="" placeholder="<?php _e('Login','suuhygieen');?>"/>
							<div class="form-company" style="display:none">
								<input id="vb_company" type="text" placeholder="<?php _e('Company','suuhygieen');?>">
								<input id="vb_regcode" type="text" placeholder="<?php _e('Reg code','suuhygieen');?>">
							</div>
							
							<input type="password" id="vb_pass" placeholder="<?php _e('Choose Password','suuhygieen');?>">
						 
							
			
							<label class="form__checkbox">
								<input type="checkbox" class="reg_cheackbox">
								<span class="form__checkbox__inner">
									<?php _e('Choose Password','suuhygieen');?> <a href="#"> <?php _e('Privacy Police','suuhygieen');?></a>
								</span>
							</label>

						<?php wp_nonce_field('vb_new_user','vb_new_user_nonce', true, true ); ?>

						<input type="submit" id="btn-new-user" value="Sign up">
					  </form>

						<div class="indicator"></div>
						<div class="alert result-message"></div>
					</div>
					
					
				</div>
			</div>
		</div>
		<div class="popup__inner" id="popForgot">
			<a type="button" class="popup-close">
				<img src="<?php bloginfo('template_url');?>/img/icons/close.svg">
			</a>
			<h4 class="forgot__title">
				<?php _e('Forgot your password?','suuhygieen');?>
			</h4>
			<p class="forgot__subtitle">
				<?php _e('To update your password, please fill in the fields below with your username and email address, and we will provide you with instructions to change your password to your email address.','suuhygieen');?>
			</p>
			
			<form id="forgot_password"  class="ajax-auth" action="forgot_password" method="post">    
				<p class="status"></p>  
				<?php wp_nonce_field('ajax-forgot-nonce', 'forgotsecurity'); ?>  
				<input id="user_login" type="text" class="required" name="user_login" placeholder="<?php _e('Username or E-mail','suuhygieen');?>">
				<input  class="submit_button" type="submit" value="<?php _e('SEND','suuhygieen');?>">
  
			</form>


		</div>
	</div>



<?php wp_footer(); ?>

</body>
</html>

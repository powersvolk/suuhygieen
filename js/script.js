jQuery(document).ready(function ($) {

    $('header .burger').click(function () {
        $('.wrap__menu').toggleClass('active');
        $('header').toggleClass('active');
        $('body').toggleClass('open-menu');
    });


    $('.language select').niceSelect();

    if ($('.category__sort').length) {
        $('.category__sort select').niceSelect();
    }
    if ($('.cart').length) {
        $('.cart select').niceSelect();
    }

    $('.prod__item-more').click(function (e) {
        var target = e.target;

        var element = $(target).closest('.prod__item');
        element.toggleClass('active');
        element.find('.prod-in').toggle();
    });
    $('button.prod-item__add-cart').click(function (e) {
        e.preventDefault();
    });


    $('.header-search').click(function () {
        $(this).addClass('active')
    });

    $(document).mouseup(function (e) {
        var div = $(".header-search");
        if (!div.is(e.target)
            && div.has(e.target).length === 0) {
            $('.header-search').removeClass('active');
        }
    });


    if ($('.home-banner__inner').length) {
        $('.home-banner__inner').owlCarousel({
            loop: true,
            items: 1,
            autoplay: false,
            dots: false,
            nav: true,
            navText: ["<img src='http://camo.ee/projektid/suuhygieen/wp/wp-content/themes/suuhygieen/img/icons/arr-r-dark.svg'>", "<img src='http://camo.ee/projektid/suuhygieen/wp/wp-content/themes/suuhygieen/img/icons/arr-r-dark.svg'>"],
            smartSpeed: 2000
        });
    }

    if ($('.subscribe__gallery').length) {
        $('.subscribe__gallery').lightGallery();
    }
    if ($('.product__image-wrap').length) {
        $('.product__image-wrap').lightGallery();
    }

    jQuery(".preloader").delay(200).fadeOut("slow").delay(200, function () {
        jQuery(this).remove();
    });


    $(".home-banner__bottom").on("click", "a", function (event) {
        var id = $(this).attr('href'),
            top = $(id).offset().top;
        $('body,html').animate({ scrollTop: top }, 1500);
    });




    $('.main-menu__icon').click(function (e) {
        e.preventDefault();
        $(this).toggleClass('active');
        var menuItem = $(this).closest('.main-menu__item');
        $(menuItem).find('.main-submenu').toggle('slow');
    });

    $('.header__login').click(function (e) {
        e.preventDefault();
        $('.popup-wrap').show();
        $('.popup').show();
        $('.wrap__menu').removeClass('active');
        $('header').removeClass('active');
        $('body').removeClass('open-menu');
    });
    $('.popup-close, .popup-wrap').click(function (e) {
        e.preventDefault();
        $('.popup-wrap').hide();
        $('.popup').hide();
        $('#popLogin').show();
        $('#popForgot').hide();
    });
    $('.forgot-password').click(function (e) {
        e.preventDefault();
        $('#popLogin').hide();
        $('#popForgot').show();
    });

    $('.main-home .main-menu__title, .main-page .main-menu__title, .prod-wrap .main-menu__title').click(function () {
        if ($(window).width() > 992) {

        } else {
            $('.main-menu').toggle('slow');
            $('.main-menu__arr').toggleClass('active');
        }

    });
	
	

    $('.main-list-prod .main-menu__title').click(function (e) {
        e.preventDefault();

        $('.main-menu').toggle('slow');
        $('.main-menu__arr').toggleClass('active');
        $('.main-menu__title').toggleClass('active');

    });

    $('.main-menu-more').click(function (e) {
        e.preventDefault();
        $('.main-menu').toggleClass('main-menu-less');
        $(this).toggleClass('active');
    });

    if ($('.wrap-quant').length) {
        var value = $('.wrap-quant input').val();

        $('.quant-minus').click(function () {
            if (value == 1) return;
            value--;
            $('.wrap-quant input').val(value);
        });

        $('.quant-plus').click(function () {
            value++;
            $('.wrap-quant input').val(value);

        });
    }

    $('.form__checkbox-person input').change(function(){
        if($('.form__checkbox-person input').is(":checked")) {
            $('.form-company').show();
			$(this).addClass('active');
        } else {
            $('.form-company').hide();
			$(this).removeClass('active');
        }
    });

	

// register
	$('#btn-new-user').click( function() {

    if (event.preventDefault) {
        event.preventDefault();
    } else {
        event.returnValue = false;
    }

    
    $('.indicator').show();

   
    $('.result-message').hide();

    
    var reg_nonce = $('#vb_new_user_nonce').val();
    var reg_first  = $('#vb_first').val();
    var reg_last  = $('#vb_last').val();
    var reg_email  = $('#vb_email').val();
    var reg_phone  = $('#vb_phone').val();
    var reg_nick  = $('#vb_nick').val();
	var reg_pass  = $('#vb_pass').val();
	var reg_company  = $('#vb_company').val();
	var reg_regcode  = $('#vb_regcode').val();
	
	
	
	
	if(reg_first == ''){
		$('#vb_first').css('border','1px solid red');
	} else if(reg_last ==''){
		$('#vb_last').css('border','1px solid red');
	} else if(reg_email ==''){
		$('#vb_email').css('border','1px solid red');
	} else if(reg_phone ==''){
		$('#vb_phone').css('border','1px solid red');
	} else if(reg_nick ==''){	
		$('#vb_nick').css('border','1px solid red');
	} else if(reg_pass ==''){		
		$('#vb_pass').css('border','1px solid red');
	} else if ($('.form__checkbox-person input').hasClass('active')) {
		if(reg_company ==''){		
			$('#vb_company').css('border','1px solid red');
		} else if(reg_regcode ==''){
			$('#vb_regcode').css('border','1px solid red');	
		}
	} else if(!$('.reg_cheackbox').is(':checked')){	
		$('.form__checkbox').addClass('cheack_active');
	} else {




    var ajax_url = MyAjax.ajaxurl;

   
    data = {
      action: 'register_user',
      nonce: reg_nonce,
      first: reg_first,
      last: reg_last,
      mail: reg_email,
      phone: reg_phone,
	  nick: reg_nick,
      pass: reg_pass,
	  company: reg_company,
	  regcode: reg_regcode,
    };

    
		$.post( ajax_url, data, function(response) {

		  if( response ) {
			$('.indicator').hide();

			if( response === '1' ) {
			  
			  $('.result-message').html('Your submission is complete.');
			  $('.result-message').addClass('alert-success'); 
			  $('.result-message').show();
			  
				$('#vb_new_user_nonce').val('');
				$('#vb_first').val('');
				$('#vb_last').val('');
				$('#vb_email').val('');
				$('#vb_phone').val('');
				$('#vb_nick').val('');
				$('#vb_pass').val('');
				$('#vb_company').val('');
				$('#vb_regcode').val('');
				$('.form__checkbox__inner').removeClass('cheack_active');
			  
			} else {
			  $('.result-message').html( response ); 
			  $('.result-message').addClass('alert-danger'); 
			  $('.result-message').show(); 
			}
		  }
		});
	}
    
  });


// login

	$('form#login').on('submit', function(e){
		
		var name = $('form#login #username').val();
		var pass = $('form#login #password').val();
		if (name == '') {
			$('form#login #username').css('border','1px solid red');	
		} else if(pass == '') {
			$('form#login #password').css('border','1px solid red');	
		} else {
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: MyAjax.ajaxurl,
				data: { 
					'action': 'ajaxlogin', 
					'username': name, 
					'password': pass, 
					'security': $('form#login #security').val() },
				success: function(data){
					$('form#login p.status').text(data.message);
					if (data.loggedin == true){
						document.location.href = MyAjax.redirecturl;
					}
				}
			});
		}
        e.preventDefault();
    });





// forgot password

$('form#forgot_password').on('submit', function(e){
		$('p.status', this).show().text(MyAjax.loadingmessage);
		ctrl = $(this);
		$.ajax({
			type: 'POST',
				dataType: 'json',
				url: MyAjax.ajaxurl,
			data: { 
				'action': 'ajaxforgotpassword', 
				'user_login': $('#user_login').val(), 
				'security': $('#forgotsecurity').val(), 
			},
			success: function(data){ 
				$('p.status',ctrl).text(data.message); 
			}
		});
	e.preventDefault();
	
});

 
});

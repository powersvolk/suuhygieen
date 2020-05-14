jQuery(document).ready(function ($) {
	
	$(document).on('click', '.cat_add_cart', function (e) {
        e.preventDefault();

        var $thisbutton = $(this);
				
				product_sku = $(this).data('product_sku');
                product_qty = $(this).data('quantity');
                product_id = $(this).data('product_id');
                variation_id = 0;

        var data = {
            action: 'woocommerce_ajax_add_to_cart',
            product_id: product_id,
            product_sku: product_sku,
            quantity: product_qty,
            variation_id: variation_id,
        };

        $(document.body).trigger('adding_to_cart', [$thisbutton, data]);

        $.ajax({
            type: 'post',
            url: wc_add_to_cart_params.ajax_url,
            data: data,
            beforeSend: function (response) {
              $thisbutton.removeClass('added').addClass('loading');
            },
            complete: function (response) {
                $thisbutton.addClass('added').removeClass('loading');
            },
            success: function (response) {

                if (response.error & response.product_url) {
                    window.location = response.product_url;
                    return;
                } else {
                    $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
					$('html, body').animate({scrollTop: 0},500);		
                }
            },
        });

        return false;
    });

});



jQuery(document).ready(function ($) {
	
	$(document).on('click', '.single_add_to_cart_button', function (e) {
        e.preventDefault();

        var $thisbutton = $(this);
				
				product_sku = $(this).data('product_sku');
                product_qty = $('.qty').val();
                product_id = $(this).data('product_id');
                variation_id = $('#variation_id').val();

        var data = {
            action: 'woocommerce_ajax_add_to_cart',
            product_id: product_id,
            product_sku: product_sku,
            quantity: product_qty,
            variation_id: variation_id,
        };

        $(document.body).trigger('adding_to_cart', [$thisbutton, data]);

        $.ajax({
            type: 'post',
            url: wc_add_to_cart_params.ajax_url,
            data: data,
            beforeSend: function (response) {
              $thisbutton.removeClass('added').addClass('loading');
            },
            complete: function (response) {
                $thisbutton.addClass('added').removeClass('loading');
            },
            success: function (response) {

                if (response.error & response.product_url) {
                    window.location = response.product_url;
                    return;
                } else {
                    $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
					$('html, body').animate({scrollTop: 0},500);		
                }
            },
        });

        return false;
    });

});



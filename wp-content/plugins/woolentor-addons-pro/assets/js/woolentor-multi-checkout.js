;(function($){
"use strict";

    var woolentorCheckout = function woolentorCheckout( $scope, $ ) {

        var woolentor_msc_checkout = $scope.find(".woolentor-msc-checkout").eq(0);
        var require_message = woolentor_msc_checkout.data('message');

        if ( woolentor_msc_checkout.length > 0 ) {

            $( "form.woocommerce-checkout .validate-required :input").attr("required", "required");
            $( "form.woocommerce-checkout .validate-email .input-text").addClass("email");

             // Back to the cart page
            $( '#woolentor-msc-back-to-cart' ).on( 'click', function() {
                window.location.href = $( this ).data( 'url' ); 
            });

            var button_prev = $('#woolentor-msc-prev'),
                button_next = $('#woolentor-msc-next,#woolentor-msc-skip-login'),
                first_step = getItemId( $('.woolentor-msc-tab-item.first') ),
                last_step = getItemId( $('.woolentor-msc-tab-item.last') ),
                active_step = 1,
                tabs = $('.woolentor-msc-tabs-menu ul'),
                tabs_content = $('.woolentor-msc-steps-wrapper'),
                coupon_form = $( '#checkout_coupon' );

            function getItemId( $item ) {
                var id = $item.attr( 'id' );
                return id.replace( 'woolentor-step-', '' );
            }

            function scrollToTop(){
                var different = $( '.woolentor-msc-tabs-menu' ).offset().top - $( window ).scrollTop();
                var scroll_offset = 70;
                if ( typeof 120 !== 'undefined' ) {
                    scroll_offset = 120;
                }
                if ( different < -40 ) {
                    $( 'html, body' ).animate({
                        scrollTop: $( '.woolentor-msc-tabs-menu' ).offset().top - scroll_offset, 
                    }, 1000 );
                }
            }

            switchTab( active_step, false );

            button_prev.on( 'click', function () {
                var step_number = active_step - 1;
                if ( step_number >= first_step ) {
                    switchTab( step_number, false );
                    scrollToTop();
                }
            });

            button_next.on( 'click', function () {
                var step_number = active_step + 1;
                if ( step_number <= last_step ) {
                    var valid_form = validateCheckoutForm();
                    if( valid_form === true ){
                        switchTab( step_number, false );
                        scrollToTop();
                    }
                }
            });

            function switchTab( step_number, step ) {

                if ( !step ) {
                    step = tabs.find('#woolentor-step-' + step_number);
                }
                tabs.find('li').removeClass('current');

                button_prev.addClass('current');
                button_next.addClass('current');

                coupon_form.hide();

                // Hide the skip login button
                if ( 1 < step_number ) {
                    $( '#woolentor-msc-skip-login').removeClass( 'current' );
                }
                if ( 1 == step_number && last_step == 5 ) {
                    $( '#woolentor-msc-next').removeClass( 'current' );
                }

                tabs_content.find('div.woolentor-msc-step-item').removeClass('current');
                $( '#woolentor-msc-step-item-' + step_number ).addClass('current');

                if ( !step.hasClass("current") ) {
                    step.addClass("current");
                }
                active_step = step_number;

                if ( active_step == first_step ) {
                    button_prev.removeClass('current');
                }if ( active_step == last_step ) {
                    button_next.removeClass('current');
                }

                // Show the Coupon form
                if ( $( '.woolentor-msc-step-review.current' ).length > 0 ) {
                    coupon_form.show();
                }

            }

            function validateCheckoutForm(){

                var form_valid = true;
                var found_element = false;

                $('.woolentor-msc-steps-wrapper .woolentor-msc-step-item.current :input').each(function () {
                    if (found_element === true)
                        return false;

                    if ( $(this).attr("required") && $(this).is(":visible") ) {
                        if ($.trim($(this).val()) === '') {
                            found_element = true;
                            form_valid = false;
                            var scrool_to_element = $(this).attr("id");

                            if( !$("#"+scrool_to_element).hasClass("woolentor-error") ){
                                $("#"+scrool_to_element).addClass("woolentor-error");
                                $("#"+scrool_to_element).closest('p').append('<span class="woolentor-error-class">' + require_message + '</span>');
                            }

                            $('html, body').animate({
                                scrollTop: $("#" + scrool_to_element).offset().top - 40
                            }, 1000, function () {
                                $("#" + scrool_to_element).focus();
                            });

                            return false;
                        }
                    }

                });
                return form_valid;
            }



        }
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/wl-checkout-multi-step-form.default', woolentorCheckout );
    });

})(jQuery);
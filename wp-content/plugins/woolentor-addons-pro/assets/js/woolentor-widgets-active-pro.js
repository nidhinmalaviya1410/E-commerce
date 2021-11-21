;(function($){
"use strict";

    
    var WidgetThumbnailsSliderHandler = function ($scope, $) {

        var slider_elem = $scope.find('.wl-thumbnails-slider').eq(0);

        if ( slider_elem.length > 0 ) {

            var settings = slider_elem.data('settings');
            var arrows = settings['arrows'];
            var dots = settings['dots'];
            var autoplay = settings['autoplay'];
            var rtl = settings['rtl'];
            var autoplay_speed = parseInt(settings['autoplay_speed']) || 3000;
            var animation_speed = parseInt(settings['animation_speed']) || 300;
            var fade = settings['fade'];
            var pause_on_hover = settings['pause_on_hover'];
            var display_columns = parseInt(settings['product_items']) || 4;
            var scroll_columns = parseInt(settings['scroll_columns']) || 4;
            var tablet_width = parseInt(settings['tablet_width']) || 800;
            var tablet_display_columns = parseInt(settings['tablet_display_columns']) || 2;
            var tablet_scroll_columns = parseInt(settings['tablet_scroll_columns']) || 2;
            var mobile_width = parseInt(settings['mobile_width']) || 480;
            var mobile_display_columns = parseInt(settings['mobile_display_columns']) || 1;
            var mobile_scroll_columns = parseInt(settings['mobile_scroll_columns']) || 1;

            slider_elem.slick({
                arrows: arrows,
                prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
                dots: dots,
                infinite: true,
                autoplay: autoplay,
                autoplaySpeed: autoplay_speed,
                speed: animation_speed,
                fade: false,
                pauseOnHover: pause_on_hover,
                slidesToShow: display_columns,
                slidesToScroll: scroll_columns,
                rtl: rtl,
                responsive: [
                    {
                        breakpoint: tablet_width,
                        settings: {
                            slidesToShow: tablet_display_columns,
                            slidesToScroll: tablet_scroll_columns
                        }
                    },
                    {
                        breakpoint: mobile_width,
                        settings: {
                            slidesToShow: mobile_display_columns,
                            slidesToScroll: mobile_scroll_columns
                        }
                    }
                ]
            });
        };
    }

    // Product thumbnais varition with tab
    function woolentor_thumbnails_tab_with_variation( $thumbnais ){
        $thumbnais.on('click', 'li', function(e){
            e.preventDefault();
            var $this = $(this),
                $image = $this.data('wlimage');
            $( '.woocommerce-product-gallery__image .wp-post-image' ).attr( "src", $image );
            $( '.woocommerce-product-gallery__image .wp-post-image' ).attr( "srcset", $image );
        });
    }
    var WidgetThumbnaisImagesHandlerPro = function woolentorthumbnailspro(){
        woolentor_thumbnails_tab_with_variation( $(".woolentor-thumbanis-image") );
    }


    //Tool-tips
    function woolentor_tool_tips_pro(element, content) {
        if (content == 'html') {
            var tipText = element.html();
        } else {
            var tipText = element.attr('title');
        }
        element.on('mouseover', function() {
            if ($('.woolentor-tip').length == 0) {
                element.before('<span class="woolentor-tip">' + tipText + '</span>');
                $('.woolentor-tip').css('transition', 'all 0.5s ease 0s');
                $('.woolentor-tip').css('margin-left', 0);
            }
        });
        element.on('mouseleave', function() {
            $('.woolentor-tip').remove();
        });
    }

    // Custom Tab
    function woolentor_tabs_pro( $tabmenus, $tabpane ){
        $tabmenus.on('click', 'a', function(e){
            e.preventDefault();
            var $this = $(this),
                $target = $this.attr('href');
            $this.addClass('htactive').parent().siblings().children('a').removeClass('htactive');
            $( $tabpane + $target ).addClass('htactive').siblings().removeClass('htactive');

            // slick refresh
            var $id = $this.attr('href');
            $($id).find('.slick-slider').slick('refresh');

        });
    }

    //Tooltip
    var WidgetWoolentorTooltipHandlerpro = function woolentor_tool_tip_pro(){
        $('a.woolentor-compare').each(function() {
            woolentor_tool_tips_pro($(this), 'title');
        });
        $('.woolentor-cart a.add_to_cart_button,.woolentor-cart a.added_to_cart,.woolentor-cart a.button').each(function() {
            woolentor_tool_tips_pro($(this), 'html');
        });
    }

    // image handler
    var WidgetThumbnaisShopHandlerPro = function thumbnailsimagescontrollerpro(){
        woolentor_tabs_pro( $(".ht-product-cus-tab-links"), '.ht-product-cus-tab-pane' );
        woolentor_tabs_pro( $(".ht-tab-menus"), '.ht-tab-pane' );

        // Countdown
        var finalTime, daysTime, hours, minutes, second;
        $('.ht-product-countdown').each(function() {
            var $this = $(this), finalDate = $(this).data('countdown');
            var customlavel = $(this).data('customlavel');
            $this.countdown(finalDate, function(event) {
                $this.html(event.strftime('<div class="cd-single"><div class="cd-single-inner"><h3>%D</h3><p>'+customlavel.daytxt+'</p></div></div><div class="cd-single"><div class="cd-single-inner"><h3>%H</h3><p>'+customlavel.hourtxt+'</p></div></div><div class="cd-single"><div class="cd-single-inner"><h3>%M</h3><p>'+customlavel.minutestxt+'</p></div></div><div class="cd-single"><div class="cd-single-inner"><h3>%S</h3><p>'+customlavel.secondstxt+'</p></div></div>'));
            });
        });

    }

     /**
     * [WooLentorIsotope]
     * @param {[string]} $scope
     */
    var WooLentorIsotope = function ( $scope, $ ) {

        var isotopeGrid = $scope.find('.woolentor-filter-grid').eq(0);
        
        if ( isotopeGrid.length > 0 ){
            
            var $grid = isotopeGrid,
                $gridId = $grid.attr('id'),
                $gridActive = $grid.data('active-item'),
                $isotopeFilter = $('[data-target="#' + $gridId + '"]').parent('.woolentor-filter-menu');
                $isotopeFilter.find('li[data-filter="' + $gridActive + '"]').addClass('active').siblings().removeClass('active');
            
            $isotopeFilter.on('click', '[data-filter]', function() {
                var $this = $(this),
                    $filterValue = $this.attr('data-filter'),
                    $targetIsotop = $this.parent().data('target');
                $this.addClass('active').siblings().removeClass('active');

                $( $targetIsotop ).isotope({
                    filter: $filterValue,
                    itemSelector: '.woolentor_filter_grid__item',
                    masonry: {
                        columnWidth: '.woolentor_filter_grid__item__sizer'
                    },
                    transitionDuration: '0.6s'
                });

            });
            
            $grid.imagesLoaded(function() {
                $grid.isotope({
                    itemSelector: '.woolentor_filter_grid__item',
                    masonry: {
                        columnWidth: '.woolentor_filter_grid__item__sizer'
                    },
                    transitionDuration: '0.6s'
                });
            });

        }
    }
    
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/wl-product-thumbnails-image.default', WidgetThumbnaisImagesHandlerPro);
        elementorFrontend.hooks.addAction( 'frontend/element_ready/wl-product-thumbnails-image.default', WidgetThumbnailsSliderHandler);
        elementorFrontend.hooks.addAction( 'frontend/element_ready/woolentor-custom-product-archive.default', WidgetThumbnaisShopHandlerPro);
        elementorFrontend.hooks.addAction( 'frontend/element_ready/wl-product-sale-schedule.default', WidgetThumbnaisShopHandlerPro);
        elementorFrontend.hooks.addAction( 'frontend/element_ready/woolentor-custom-product-archive.default', WidgetWoolentorTooltipHandlerpro);
        elementorFrontend.hooks.addAction( 'frontend/element_ready/woolentor-filtarable-grid-product.default', WooLentorIsotope );
    });

})(jQuery);
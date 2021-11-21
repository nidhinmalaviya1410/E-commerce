<?php

namespace WooLentorPro;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
* Widgets Control
*/
class Widgets_Control{
    
    private static $instance = null;
    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function __construct(){
        $this->init();
    }

    public function init() {

        // Register custom category
        add_action( 'elementor/elements/categories_registered', [ $this, 'add_category' ] );

        // Init Widgets
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

    }

    // Add custom category.
    public function add_category( $elements_manager ) {
        $elements_manager->add_category(
            'woolentor-addons-pro',
            [
               'title'  => __( 'Woolentor Pro','woolentor-pro'),
                'icon' => 'font',
            ]
        );
    }

    // Widgets Register
    public function init_widgets(){

        $wl_element_manager = array(
            'universal_product',
            'wl_category',
            'wl_brand',
            'wl_product_grid',
            'wl_product_expanding_grid',
            'wl_product_filterable_grid',
            'wb_customer_review',
            'wl_testimonial'
        );
        if( woolentor_get_option_pro( 'ajaxsearch', 'woolentor_others_tabs', 'off' ) == 'on' ){
            $wl_element_manager[] = 'ajax_search_form';
        }

        // WooCommerce Builder
        if( woolentor_get_option_pro( 'enablecustomlayout', 'woolentor_woo_template_tabs', 'on' ) == 'on' ){
            $wlb_element  = array(
                'wl_custom_archive_layout',
                'wl_cart_table',
                'wl_cart_total',
                'wl_cartempty_message',
                'wl_cartempty_shopredirect',
                'wl_cross_sell',
                'wl_checkout_additional_form',
                'wl_checkout_billing',
                'wl_checkout_shipping_form',
                'wl_checkout_payment',
                'wl_checkout_coupon_form',
                'wl_checkout_login_form',
                'wl_order_review',
                'wl_myaccount_account',
                'wl_myaccount_dashboard',
                'wl_myaccount_download',
                'wl_myaccount_edit_account',
                'wl_myaccount_address',
                'wl_myaccount_login_form',
                'wl_myaccount_register_form',
                'wl_myaccount_logout',
                'wl_myaccount_order',
                'wl_thankyou_order',
                'wl_thankyou_customer_address_details',
                'wl_thankyou_order_details',
                'wl_product_advance_thumbnails',
                'wl_product_advance_thumbnails_zoom',
                'wl_social_shere',
                'wl_stock_progress_bar',
                'wl_single_product_sale_schedule',
                'wl_related_product',
                'wl_product_upsell_custom',
                'wl_cross_sell_custom',
                'wl_quickview_product_image',
                'wl_template_selector',
                'wl_mini_cart',
            );
        }else{ $wlb_element  = array(); }

        if( woolentor_get_option_pro( 'multi_step_checkout', 'woolentor_others_tabs', 'off' ) == 'on' ){
            $wlb_element[] = 'wl_checkout_multi_step';
        }

        $wl_element_manager = array_merge( $wl_element_manager, $wlb_element );

        foreach ( $wl_element_manager as $element ){
            if (  ( woolentor_get_option_pro( $element, 'woolentor_elements_tabs', 'on' ) === 'on' ) && file_exists( WOOLENTOR_ADDONS_PL_PATH_PRO.'includes/addons/'.$element.'.php' ) ){
                require_once ( WOOLENTOR_ADDONS_PL_PATH_PRO.'includes/addons/'.$element.'.php' );
            }
        }
        
    }


}

Widgets_Control::instance();
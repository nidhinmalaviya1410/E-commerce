<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

class Woolentor_Admin_Settings_Pro {

    private $settings_api;

    function __construct() {
        
        $this->settings_api = new Woolentor_Settings_API();
        
        add_action( 'admin_init', array( $this, 'admin_init' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu' ), 220 );
        add_action( 'wsa_form_bottom_woolentor_general_tabs', array( $this, 'woolentor_html_general_tabs' ) );
        add_action( 'wsa_form_bottom_woolentor_themes_library_tabs', array( $this, 'woolentor_html_themes_library_tabs' ) );
        add_action( 'wsa_form_top_woolentor_elements_tabs', array( $this, 'html_element_toogle_button' ) );
        add_action( 'wsa_form_top_woolentor_style_tabs', array( $this, 'style_tab_html' ) );
        add_action( 'wsa_form_bottom_woolentor_style_tabs', array( $this, 'style_tab_bottom_html' ) );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->woolentor_admin_get_settings_sections() );
        $this->settings_api->set_fields( $this->woolentor_admin_fields_settings() );

        //initialize settings
        $this->settings_api->admin_init();

    }

    // Plugins menu Register
    function admin_menu() {

        $menu = 'add_menu_' . 'page';
        $menu(
            'woolentor_panel',
            esc_html__( 'WooLentor', 'woolentor-pro' ),
            esc_html__( 'WooLentor', 'woolentor-pro' ),
            'woolentor_page',
            NULL,
            WOOLENTOR_ADDONS_PL_URL.'includes/admin/assets/images/menu-icon.png',
            100
        );
        
        add_submenu_page(
            'woolentor_page', 
            esc_html__( 'Settings', 'woolentor-pro' ),
            esc_html__( 'Settings', 'woolentor-pro' ), 
            'manage_options', 
            'woolentor', 
            array ( $this, 'plugin_page' ) 
        );


    }

    // Options page Section register
    function woolentor_admin_get_settings_sections() {
        $sections = array(
            
            array(
                'id'    => 'woolentor_general_tabs',
                'title' => esc_html__( 'General', 'woolentor-pro' )
            ),

            array(
                'id'    => 'woolentor_woo_template_tabs',
                'title' => esc_html__( 'WooCommerce Template', 'woolentor-pro' )
            ),

            array(
                'id'    => 'woolentor_elements_tabs',
                'title' => esc_html__( 'Elements', 'woolentor-pro' )
            ),

            array(
                'id'    => 'woolentor_themes_library_tabs',
                'title' => esc_html__( 'Theme Library', 'woolentor-pro' )
            ),

            array(
                'id'    => 'woolentor_rename_label_tabs',
                'title' => esc_html__( 'Rename Label', 'woolentor-pro' )
            ),

            array(
                'id'    => 'woolentor_sales_notification_tabs',
                'title' => esc_html__( 'Sales Notification', 'woolentor-pro' )
            ),
            
            array(
                'id'    => 'woolentor_others_tabs',
                'title' => esc_html__( 'Other', 'woolentor-pro' )
            ),

            array(
                'id'    => 'woolentor_style_tabs',
                'title' => esc_html__( 'Style', 'woolentor-pro' )
            ),

        );
        return $sections;
    }

    // Options page field register
    protected function woolentor_admin_fields_settings() {

        $settings_fields = array(

            'woolentor_general_tabs' => array(),

            'woolentor_woo_template_tabs'=>array(

                array(
                    'name'  => 'enablecustomlayout',
                    'label'  => esc_html__( 'Enable / Disable Template Builder', 'woolentor-pro' ),
                    'desc'  => esc_html__( 'Enable', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'shoppageproductlimit',
                    'label' => esc_html__( 'Product Limit', 'woolentor-pro' ),
                    'desc' => wp_kses_post( 'You can handle the product limit for the Shop page limit', 'woolentor-pro' ),
                    'min'               => 1,
                    'max'               => 100,
                    'step'              => '1',
                    'type'              => 'number',
                    'std'               => '10',
                    'sanitize_callback' => 'floatval'
                ),

                array(
                    'name'    => 'singleproductpage',
                    'label'   => esc_html__( 'Single Product Template', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'You can select a custom template for the product details page layout', 'woolentor-pro' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => woolentor_elementor_template()
                ),

                array(
                    'name'    => 'productarchivepage',
                    'label'   => esc_html__( 'Product Archive Page Template', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'You can select a custom template for the Shop page layout', 'woolentor-pro' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => woolentor_elementor_template()
                ),

                array(
                    'name'    => 'productcartpage',
                    'label'   => esc_html__( 'Cart Page Template', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'You can select a template for the Cart page layout', 'woolentor-pro' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => woolentor_elementor_template()
                ),

                array(
                    'name'    => 'productemptycartpage',
                    'label'   => esc_html__( 'Empty Cart Page Template', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'You can select Custom empty cart page layout', 'woolentor-pro' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => woolentor_elementor_template()
                ),

                array(
                    'name'    => 'productcheckoutpage',
                    'label'   => esc_html__( 'Checkout Page Template', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'You can select a template for the Checkout page layout', 'woolentor-pro' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => woolentor_elementor_template()
                ),

                array(
                    'name'    => 'productcheckouttoppage',
                    'label'   => esc_html__( 'Checkout Page Top Content', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'You can checkout top content(E.g: Coupon form, login form etc)', 'woolentor-pro' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => woolentor_elementor_template()
                ),

                array(
                    'name'    => 'productthankyoupage',
                    'label'   => esc_html__( 'Thank You Page Template', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'Select a template for the Thank you page layout', 'woolentor-pro' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => woolentor_elementor_template()
                ),

                array(
                    'name'    => 'productmyaccountpage',
                    'label'   => esc_html__( 'My Account Page Template', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'Select a template for the My Account page layout', 'woolentor-pro' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => woolentor_elementor_template()
                ),

                array(
                    'name'    => 'productmyaccountloginpage',
                    'label'   => esc_html__( 'My Account Login page Template', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'Select a template for the Login page layout', 'woolentor-pro' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => woolentor_elementor_template()
                ),

                array(
                    'name'    => 'productquickview',
                    'label'   => esc_html__( 'Product Quick View Template', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'Select a template for the product\'s quick view layout', 'woolentor-pro' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => woolentor_elementor_template()
                ),

                array(
                    'name'    => 'mini_cart_layout',
                    'label'   => esc_html__( 'Mini Cart Template', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'Select a template for the mini cart layout', 'woolentor-pro' ),
                    'type'    => 'select',
                    'default' => '0',
                    'options' => woolentor_elementor_template()
                ),

            ),

            'woolentor_elements_tabs' => array(

                array(
                    'name'  => 'product_tabs',
                    'label'  => esc_html__( 'Product Tab', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'universal_product',
                    'label'  => esc_html__( 'Universal Product', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'add_banner',
                    'label'  => esc_html__( 'Ads Banner', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'special_day_offer',
                    'label'  => esc_html__( 'Special Day Offer', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_customer_review',
                    'label'  => __( 'Customer Review', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_image_marker',
                    'label'  => __( 'Image Marker', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_category',
                    'label'  => esc_html__( 'Category List', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_category_grid',
                    'label'  => __( 'Category Grid', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_onepage_slider',
                    'label'  => __( 'One page slider', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_testimonial',
                    'label'  => __( 'Testimonial', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_product_grid',
                    'label'  => __( 'Product Grid', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_product_expanding_grid',
                    'label'  => __( 'Product Expanding Grid', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_product_filterable_grid',
                    'label'  => __( 'Product Filterable Grid', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_store_features',
                    'label'  => __( 'Store Features', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_faq',
                    'label'  => __( 'Faq', 'woolentor' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_brand',
                    'label'  => esc_html__( 'Brand Logo', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_archive_product',
                    'label'  => esc_html__( 'Product Archive', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_product_filter',
                    'label'  => __( 'Product Filter', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_product_horizontal_filter',
                    'label'  => __( 'Product Horizontal Filter', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_title',
                    'label'  => esc_html__( 'Product Title', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_related',
                    'label'  => esc_html__( 'Related Product', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_add_to_cart',
                    'label'  => esc_html__( 'Add to Cart Button', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_additional_information',
                    'label'  => esc_html__( 'Additional Information', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_data_tab',
                    'label'  => esc_html__( 'Product data Tab', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_description',
                    'label'  => esc_html__( 'Product Description', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_short_description',
                    'label'  => esc_html__( 'Product Short Description', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_price',
                    'label'  => esc_html__( 'Product Price', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_rating',
                    'label'  => esc_html__( 'Product Rating', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_reviews',
                    'label'  => esc_html__( 'Product Reviews', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_image',
                    'label'  => esc_html__( 'Product Image', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_product_video_gallery',
                    'label'  => esc_html__( 'Product Video Gallery', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_upsell',
                    'label'  => esc_html__( 'Product Upsell', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_stock',
                    'label'  => esc_html__( 'Product Stock Status', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_meta',
                    'label'  => esc_html__( 'Product Meta Info', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_call_for_price',
                    'label'  => esc_html__( 'Call for Price', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_suggest_price',
                    'label'  => esc_html__( 'Suggest Price', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wb_product_qr_code',
                    'label'  => esc_html__( 'QR Code', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_custom_archive_layout',
                    'label'  => esc_html__( 'Product Archive Layout', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_cart_table',
                    'label'  => esc_html__( 'Product Cart Table', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_cart_total',
                    'label'  => esc_html__( 'Product Cart Total', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_cartempty_message',
                    'label'  => esc_html__( 'Empty Cart Message', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_cartempty_shopredirect',
                    'label'  => esc_html__( 'Empty Cart Redirect Button', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_cross_sell',
                    'label'  => esc_html__( 'Product Cross Sell', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_cross_sell_custom',
                    'label'  => esc_html__( 'Cross Sell Product..( Custom )', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_checkout_additional_form',
                    'label'  => esc_html__( 'Checkout Additional..', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_checkout_billing',
                    'label'  => esc_html__( 'Checkout Billing Form', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_checkout_shipping_form',
                    'label'  => esc_html__( 'Checkout Shipping Form', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_checkout_payment',
                    'label'  => esc_html__( 'Checkout Payment', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_checkout_coupon_form',
                    'label'  => esc_html__( 'Checkout Coupon Form', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_checkout_login_form',
                    'label'  => esc_html__( 'Checkout Login Form', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_order_review',
                    'label'  => esc_html__( 'Checkout Order Review', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_myaccount_account',
                    'label'  => esc_html__( 'My Account', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_myaccount_dashboard',
                    'label'  => esc_html__( 'My Account Dashboard', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_myaccount_download',
                    'label'  => esc_html__( 'My Account Download', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_myaccount_edit_account',
                    'label'  => esc_html__( 'My Account Edit', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_myaccount_address',
                    'label'  => esc_html__( 'My Account Address', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'  => 'wl_myaccount_login_form',
                    'label'  => esc_html__( 'Login Form', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_myaccount_register_form',
                    'label'  => esc_html__( 'Registration Form', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_myaccount_logout',
                    'label'  => esc_html__( 'My Account Logout', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_myaccount_order',
                    'label'  => esc_html__( 'My Account Order', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_thankyou_order',
                    'label'  => esc_html__( 'Thank You Order', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_thankyou_customer_address_details',
                    'label'  => esc_html__( 'Thank You Cus.. Address', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_thankyou_order_details',
                    'label'  => esc_html__( 'Thank You Order Details', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_product_advance_thumbnails',
                    'label'  => __( 'Advance Product Image', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),
                
                array(
                    'name'  => 'wl_product_advance_thumbnails_zoom',
                    'label'  => __( 'Product Image With Zoom', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_social_shere',
                    'label'  => esc_html__( 'Product Social Share', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_stock_progress_bar',
                    'label'  => esc_html__( 'Stock Progressbar', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_single_product_sale_schedule',
                    'label'  => esc_html__( 'Product Sale Schedule', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_related_product',
                    'label'  => esc_html__( 'Related Product..( Custom )', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_product_upsell_custom',
                    'label'  => esc_html__( 'Upsell Product..( Custom )', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_quickview_product_image',
                    'label'  => esc_html__( 'Quick view .. image', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),
                
                array(
                    'name'  => 'wl_template_selector',
                    'label'  => esc_html__( 'Template Selector', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

                array(
                    'name'  => 'wl_mini_cart',
                    'label'  => esc_html__( 'Mini Cart', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'on',
                    'class'=>'woolentor_table_row pro',
                ),

            ),

            'woolentor_themes_library_tabs'=>array(),

            'woolentor_rename_label_tabs' => array(

                array(
                    'name'  => 'enablerenamelabel',
                    'label'  => esc_html__( 'Enable / Disable Rename Label', 'woolentor-pro' ),
                    'desc'  => esc_html__( 'Enable', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'      => 'shop_page_heading',
                    'headding'  => esc_html__( 'Shop Page', 'woolentor-pro' ),
                    'type'      => 'title',
                ),

                array(
                    'name'        => 'wl_shop_add_to_cart_txt',
                    'label'       => esc_html__( 'Add to Cart Button Text', 'woolentor-pro' ),
                    'desc'        => esc_html__( 'Change the Add to Cart button text for the Shop page.', 'woolentor-pro' ),
                    'type'        => 'text',
                    'placeholder' => esc_html__( 'Add to Cart', 'woolentor-pro' )
                ),

                array(
                    'name'      => 'product_details_page_heading',
                    'headding'  => esc_html__( 'Product Details Page', 'woolentor-pro' ),
                    'type'      => 'title',
                ),

                array(
                    'name'        => 'wl_add_to_cart_txt',
                    'label'       => esc_html__( 'Add to Cart Button Text', 'woolentor-pro' ),
                    'desc'        => esc_html__( 'Change the Add to Cart button text for the Product details page.', 'woolentor-pro' ),
                    'type'        => 'text',
                    'placeholder' => esc_html__( 'Add to Cart', 'woolentor-pro' )
                ),
                
                array(
                    'name'        => 'wl_description_tab_menu_title',
                    'label'       => esc_html__( 'Description', 'woolentor-pro' ),
                    'desc'        => esc_html__( 'Change the tab title for the product description.', 'woolentor-pro' ),
                    'type'        => 'text',
                    'placeholder' => esc_html__( 'Description', 'woolentor-pro' )
                ),
                
                array(
                    'name'        => 'wl_additional_information_tab_menu_title',
                    'label'       => esc_html__( 'Additional Information', 'woolentor-pro' ),
                    'desc'        => esc_html__( 'Change the tab title for the procut additional information.', 'woolentor-pro' ),
                    'type'        => 'text',
                    'placeholder' => esc_html__( 'Additiona information', 'woolentor-pro' )
                ),
                
                array(
                    'name'        => 'wl_reviews_tab_menu_title',
                    'label'       => esc_html__( 'Reviews', 'woolentor-pro' ),
                    'desc'        => esc_html__( 'Change the tab title for the product review.', 'woolentor-pro' ),
                    'type'        => 'text',
                    'placeholder' => esc_html__( 'Reviews', 'woolentor-pro' )
                ),

                array(
                    'name'      => 'checkout_page_heading',
                    'headding'  => esc_html__( 'Checkout Page', 'woolentor-pro' ),
                    'type'      => 'title',
                ),
                
                array(
                    'name'        => 'wl_checkout_placeorder_btn_txt',
                    'label'       => esc_html__( 'Place order', 'woolentor-pro' ),
                    'desc'        => esc_html__( 'You can change the Place order field label.', 'woolentor-pro' ),
                    'type'        => 'text',
                    'placeholder' => esc_html__( 'Place order', 'woolentor-pro' )
                ),

            ),

            'woolentor_sales_notification_tabs'=>array(

                array(
                    'name'  => 'enableresalenotification',
                    'label'  => esc_html__( 'Enable / Disable Sales Notification', 'woolentor-pro' ),
                    'desc'  => esc_html__( 'Enable', 'woolentor-pro' ),
                    'type'  => 'checkbox',
                    'default' => 'off',
                    'class'=>'woolentor_table_row',
                ),

                array(
                    'name'    => 'notification_content_type',
                    'label'   => esc_html__( 'Notification Content Type', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'Select Content Type', 'woolentor-pro' ),
                    'type'    => 'radio',
                    'default' => 'actual',
                    'options' => array(
                        'actual' => esc_html__('Real','woolentor-pro'),
                        'fakes'  => esc_html__('Fakes','woolentor-pro'),
                    )
                ),

                array(
                    'name'    => 'noification_fake_data',
                    'label'   => esc_html__( 'Choose Template', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'Choose Template for fakes notification.', 'woolentor-pro' ),
                    'type'    => 'multiselect',
                    'default' => '',
                    'options' => woolentor_elementor_template(),
                    'class'       => 'notification_fake',
                ),

                array(
                    'name'    => 'notification_pos',
                    'label'   => esc_html__( 'Position', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'Set the position of the Sales Notification Position on frontend.', 'woolentor-pro' ),
                    'type'    => 'select',
                    'default' => 'bottomleft',
                    'options' => array(
                        'topleft'       => esc_html__( 'Top Left','woolentor-pro' ),
                        'topright'      => esc_html__( 'Top Right','woolentor-pro' ),
                        'bottomleft'    => esc_html__( 'Bottom Left','woolentor-pro' ),
                        'bottomright'   => esc_html__( 'Bottom Right','woolentor-pro' ),
                    ),
                ),

                array(
                    'name'    => 'notification_layout',
                    'label'   => esc_html__( 'Image Position', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'Set the image position of the notification.', 'woolentor-pro' ),
                    'type'    => 'select',
                    'default' => 'imageleft',
                    'options' => array(
                        'imageleft'       => esc_html__( 'Image Left','woolentor-pro' ),
                        'imageright'      => esc_html__( 'Image Right','woolentor-pro' ),
                    ),
                    'class'       => 'notification_real'
                ),

                array(
                    'name'    => 'notification_loadduration',
                    'label'   => esc_html__( 'Loading Time', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'Set the time duration to load the notifications.', 'woolentor-pro' ),
                    'type'    => 'select',
                    'default' => '3',
                    'options' => array(
                        '2'     => esc_html__( '2 seconds','woolentor-pro' ),
                        '3'     => esc_html__( '3 seconds','woolentor-pro' ),
                        '4'     => esc_html__( '4 seconds','woolentor-pro' ),
                        '5'     => esc_html__( '5 seconds','woolentor-pro' ),
                        '6'     => esc_html__( '6 seconds','woolentor-pro' ),
                        '7'     => esc_html__( '7 seconds','woolentor-pro' ),
                        '8'     => esc_html__( '8 seconds','woolentor-pro' ),
                        '9'     => esc_html__( '9 seconds','woolentor-pro' ),
                        '10'    => esc_html__( '10 seconds','woolentor-pro' ),
                        '20'    => esc_html__( '20 seconds','woolentor-pro' ),
                        '30'    => esc_html__( '30 seconds','woolentor-pro' ),
                        '40'    => esc_html__( '40 seconds','woolentor-pro' ),
                        '50'    => esc_html__( '50 seconds','woolentor-pro' ),
                        '60'    => esc_html__( '1 minute','woolentor-pro' ),
                        '90'    => esc_html__( '1.5 minutes','woolentor-pro' ),
                        '120'   => esc_html__( '2 minutes','woolentor-pro' ),
                    ),
                ),

                array(
                    'name'    => 'notification_time_int',
                    'label'   => esc_html__( 'Time Interval', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'Set the interval time between notifications.', 'woolentor-pro' ),
                    'type'    => 'select',
                    'default' => '4',
                    'options' => array(
                        '2'     =>esc_html__( '2 seconds','woolentor-pro' ),
                        '4'     =>esc_html__( '4 seconds','woolentor-pro' ),
                        '5'     =>esc_html__( '5 seconds','woolentor-pro' ),
                        '6'     =>esc_html__( '6 seconds','woolentor-pro' ),
                        '7'     =>esc_html__( '7 seconds','woolentor-pro' ),
                        '8'     =>esc_html__( '8 seconds','woolentor-pro' ),
                        '9'     =>esc_html__( '9 seconds','woolentor-pro' ),
                        '10'    =>esc_html__( '10 seconds','woolentor-pro' ),
                        '20'    =>esc_html__( '20 seconds','woolentor-pro' ),
                        '30'    =>esc_html__( '30 seconds','woolentor-pro' ),
                        '40'    =>esc_html__( '40 seconds','woolentor-pro' ),
                        '50'    =>esc_html__( '50 seconds','woolentor-pro' ),
                        '60'    =>esc_html__( '1 minute','woolentor-pro' ),
                        '90'    =>esc_html__( '1.5 minutes','woolentor-pro' ),
                        '120'   =>esc_html__( '2 minutes','woolentor-pro' ),
                    ),
                ),

                array(
                    'name'              => 'notification_limit',
                    'label'             => esc_html__( 'Limit', 'woolentor-pro' ),
                    'desc'              => esc_html__( 'Order Limit for notification.', 'woolentor-pro' ),
                    'min'               => 1,
                    'max'               => 100,
                    'default'           => '5',
                    'step'              => '1',
                    'type'              => 'number',
                    'sanitize_callback' => 'number',
                    'class'       => 'notification_real',
                ),

                array(
                    'name'    => 'notification_uptodate',
                    'label'   => esc_html__( 'Order Upto', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'Do not show purchases older than.', 'woolentor-pro' ),
                    'type'    => 'select',
                    'default' => '7',
                    'options' => array(
                        '1'   => esc_html__( '1 day','woolentor-pro' ),
                        '2'   => esc_html__( '2 days','woolentor-pro' ),
                        '3'   => esc_html__( '3 days','woolentor-pro' ),
                        '4'   => esc_html__( '4 days','woolentor-pro' ),
                        '5'   => esc_html__( '5 days','woolentor-pro' ),
                        '6'   => esc_html__( '6 days','woolentor-pro' ),
                        '7'   => esc_html__( '1 week','woolentor-pro' ),
                        '10'  => esc_html__( '10 days','woolentor-pro' ),
                        '14'  => esc_html__( '2 weeks','woolentor-pro' ),
                        '21'  => esc_html__( '3 weeks','woolentor-pro' ),
                        '28'  => esc_html__( '4 weeks','woolentor-pro' ),
                        '35'  => esc_html__( '5 weeks','woolentor-pro' ),
                        '42'  => esc_html__( '6 weeks','woolentor-pro' ),
                        '49'  => esc_html__( '7 weeks','woolentor-pro' ),
                        '56'  => esc_html__( '8 weeks','woolentor-pro' ),
                    ),
                    'class'       => 'notification_real',
                ),

                array(
                    'name'    => 'notification_inanimation',
                    'label'   => esc_html__( 'Animation In', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'Choose entrance animation.', 'woolentor-pro' ),
                    'type'    => 'select',
                    'default' => 'fadeInLeft',
                    'options' => array(
                        'bounce'            => esc_html__( 'bounce','woolentor-pro' ),
                        'flash'             => esc_html__( 'flash','woolentor-pro' ),
                        'pulse'             => esc_html__( 'pulse','woolentor-pro' ),
                        'rubberBand'        => esc_html__( 'rubberBand','woolentor-pro' ),
                        'shake'             => esc_html__( 'shake','woolentor-pro' ),
                        'swing'             => esc_html__( 'swing','woolentor-pro' ),
                        'tada'              => esc_html__( 'tada','woolentor-pro' ),
                        'wobble'            => esc_html__( 'wobble','woolentor-pro' ),
                        'jello'             => esc_html__( 'jello','woolentor-pro' ),
                        'heartBeat'         => esc_html__( 'heartBeat','woolentor-pro' ),
                        'bounceIn'          => esc_html__( 'bounceIn','woolentor-pro' ),
                        'bounceInDown'      => esc_html__( 'bounceInDown','woolentor-pro' ),
                        'bounceInLeft'      => esc_html__( 'bounceInLeft','woolentor-pro' ),
                        'bounceInRight'     => esc_html__( 'bounceInRight','woolentor-pro' ),
                        'bounceInUp'        => esc_html__( 'bounceInUp','woolentor-pro' ),
                        'fadeIn'            => esc_html__( 'fadeIn','woolentor-pro' ),
                        'fadeInDown'        => esc_html__( 'fadeInDown','woolentor-pro' ),
                        'fadeInDownBig'     => esc_html__( 'fadeInDownBig','woolentor-pro' ),
                        'fadeInLeft'        => esc_html__( 'fadeInLeft','woolentor-pro' ),
                        'fadeInLeftBig'     => esc_html__( 'fadeInLeftBig','woolentor-pro' ),
                        'fadeInRight'       => esc_html__( 'fadeInRight','woolentor-pro' ),
                        'fadeInRightBig'    => esc_html__( 'fadeInRightBig','woolentor-pro' ),
                        'fadeInUp'          => esc_html__( 'fadeInUp','woolentor-pro' ),
                        'fadeInUpBig'       => esc_html__( 'fadeInUpBig','woolentor-pro' ),
                        'flip'              => esc_html__( 'flip','woolentor-pro' ),
                        'flipInX'           => esc_html__( 'flipInX','woolentor-pro' ),
                        'flipInY'           => esc_html__( 'flipInY','woolentor-pro' ),
                        'lightSpeedIn'      => esc_html__( 'lightSpeedIn','woolentor-pro' ),
                        'rotateIn'          => esc_html__( 'rotateIn','woolentor-pro' ),
                        'rotateInDownLeft'  => esc_html__( 'rotateInDownLeft','woolentor-pro' ),
                        'rotateInDownRight' => esc_html__( 'rotateInDownRight','woolentor-pro' ),
                        'rotateInUpLeft'    => esc_html__( 'rotateInUpLeft','woolentor-pro' ),
                        'rotateInUpRight'   => esc_html__( 'rotateInUpRight','woolentor-pro' ),
                        'slideInUp'         => esc_html__( 'slideInUp','woolentor-pro' ),
                        'slideInDown'       => esc_html__( 'slideInDown','woolentor-pro' ),
                        'slideInLeft'       => esc_html__( 'slideInLeft','woolentor-pro' ),
                        'slideInRight'      => esc_html__( 'slideInRight','woolentor-pro' ),
                        'zoomIn'            => esc_html__( 'zoomIn','woolentor-pro' ),
                        'zoomInDown'        => esc_html__( 'zoomInDown','woolentor-pro' ),
                        'zoomInLeft'        => esc_html__( 'zoomInLeft','woolentor-pro' ),
                        'zoomInRight'       => esc_html__( 'zoomInRight','woolentor-pro' ),
                        'zoomInUp'          => esc_html__( 'zoomInUp','woolentor-pro' ),
                        'hinge'             => esc_html__( 'hinge','woolentor-pro' ),
                        'jackInTheBox'      => esc_html__( 'jackInTheBox','woolentor-pro' ),
                        'rollIn'            => esc_html__( 'rollIn','woolentor-pro' ),
                        'rollOut'           => esc_html__( 'rollOut','woolentor-pro' ),
                    ),
                ),

                array(
                    'name'    => 'notification_outanimation',
                    'label'   => esc_html__( 'Animation Out', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'Choose exit animation.', 'woolentor-pro' ),
                    'type'    => 'select',
                    'default' => 'fadeOutRight',
                    'options' => array(
                        'bounce'             => esc_html__( 'bounce','woolentor-pro' ),
                        'flash'              => esc_html__( 'flash','woolentor-pro' ),
                        'pulse'              => esc_html__( 'pulse','woolentor-pro' ),
                        'rubberBand'         => esc_html__( 'rubberBand','woolentor-pro' ),
                        'shake'              => esc_html__( 'shake','woolentor-pro' ),
                        'swing'              => esc_html__( 'swing','woolentor-pro' ),
                        'tada'               => esc_html__( 'tada','woolentor-pro' ),
                        'wobble'             => esc_html__( 'wobble','woolentor-pro' ),
                        'jello'              => esc_html__( 'jello','woolentor-pro' ),
                        'heartBeat'          => esc_html__( 'heartBeat','woolentor-pro' ),
                        'bounceOut'          => esc_html__( 'bounceOut','woolentor-pro' ),
                        'bounceOutDown'      => esc_html__( 'bounceOutDown','woolentor-pro' ),
                        'bounceOutLeft'      => esc_html__( 'bounceOutLeft','woolentor-pro' ),
                        'bounceOutRight'     => esc_html__( 'bounceOutRight','woolentor-pro' ),
                        'bounceOutUp'        => esc_html__( 'bounceOutUp','woolentor-pro' ),
                        'fadeOut'            => esc_html__( 'fadeOut','woolentor-pro' ),
                        'fadeOutDown'        => esc_html__( 'fadeOutDown','woolentor-pro' ),
                        'fadeOutDownBig'     => esc_html__( 'fadeOutDownBig','woolentor-pro' ),
                        'fadeOutLeft'        => esc_html__( 'fadeOutLeft','woolentor-pro' ),
                        'fadeOutLeftBig'     => esc_html__( 'fadeOutLeftBig','woolentor-pro' ),
                        'fadeOutRight'       => esc_html__( 'fadeOutRight','woolentor-pro' ),
                        'fadeOutRightBig'    => esc_html__( 'fadeOutRightBig','woolentor-pro' ),
                        'fadeOutUp'          => esc_html__( 'fadeOutUp','woolentor-pro' ),
                        'fadeOutUpBig'       => esc_html__( 'fadeOutUpBig','woolentor-pro' ),
                        'flip'               => esc_html__( 'flip','woolentor-pro' ),
                        'flipOutX'           => esc_html__( 'flipOutX','woolentor-pro' ),
                        'flipOutY'           => esc_html__( 'flipOutY','woolentor-pro' ),
                        'lightSpeedOut'      => esc_html__( 'lightSpeedOut','woolentor-pro' ),
                        'rotateOut'          => esc_html__( 'rotateOut','woolentor-pro' ),
                        'rotateOutDownLeft'  => esc_html__( 'rotateOutDownLeft','woolentor-pro' ),
                        'rotateOutDownRight' => esc_html__( 'rotateOutDownRight','woolentor-pro' ),
                        'rotateOutUpLeft'    => esc_html__( 'rotateOutUpLeft','woolentor-pro' ),
                        'rotateOutUpRight'   => esc_html__( 'rotateOutUpRight','woolentor-pro' ),
                        'slideOutUp'         => esc_html__( 'slideOutUp','woolentor-pro' ),
                        'slideOutDown'       => esc_html__( 'slideOutDown','woolentor-pro' ),
                        'slideOutLeft'       => esc_html__( 'slideOutLeft','woolentor-pro' ),
                        'slideOutRight'      => esc_html__( 'slideOutRight','woolentor-pro' ),
                        'zoomOut'            => esc_html__( 'zoomOut','woolentor-pro' ),
                        'zoomOutDown'        => esc_html__( 'zoomOutDown','woolentor-pro' ),
                        'zoomOutLeft'        => esc_html__( 'zoomOutLeft','woolentor-pro' ),
                        'zoomOutRight'       => esc_html__( 'zoomOutRight','woolentor-pro' ),
                        'zoomOutUp'          => esc_html__( 'zoomOutUp','woolentor-pro' ),
                        'hinge'              => esc_html__( 'hinge','woolentor-pro' ),
                    ),
                ),
                
                array(
                    'name'  => 'background_color',
                    'label' => esc_html__( 'Background Color', 'woolentor-pro' ),
                    'desc'  => wp_kses_post( 'Set the background color of the notification.', 'woolentor-pro' ),
                    'type'  => 'color',
                    'class' => 'notification_real',
                ),

                array(
                    'name'  => 'heading_color',
                    'label' => esc_html__( 'Heading Color', 'woolentor-pro' ),
                    'desc'  => wp_kses_post( 'Set the heading color of the notification.', 'woolentor-pro' ),
                    'type'  => 'color',
                    'class' => 'notification_real',
                ),

                array(
                    'name'  => 'content_color',
                    'label' => esc_html__( 'Content Color', 'woolentor-pro' ),
                    'desc'  => wp_kses_post( 'Set the content color of the notification.', 'woolentor-pro' ),
                    'type'  => 'color',
                    'class' => 'notification_real',
                ),

                array(
                    'name'  => 'cross_color',
                    'label' => esc_html__( 'Cross Icon Color', 'woolentor-pro' ),
                    'desc'  => wp_kses_post( 'Set the cross icon color of the notification.', 'woolentor-pro' ),
                    'type'  => 'color'
                ),

            ),

            'woolentor_others_tabs'=>array(

                array(
                    'name'  => 'loadproductlimit',
                    'label' => esc_html__( 'Load Products in Elementor Widget', 'woolentor-pro' ),
                    'desc'  => wp_kses_post( 'Set the number of products to load in Elementor Widgets.', 'woolentor-pro' ),
                    'min'               => 1,
                    'max'               => 100,
                    'step'              => '1',
                    'type'              => 'number',
                    'default'           => '20',
                    'sanitize_callback' => 'floatval'
                ),
                
                array(
                    'name'   => 'ajaxsearch',
                    'label'  => esc_html__( 'Ajax Search Widget', 'woolentor-pro' ),
                    'desc'  => wp_kses_post( 'AJAX Search Widget', 'woolentor-pro' ),
                    'type'   => 'checkbox',
                    'default'=> 'off',
                    'class'  =>'woolentor_table_row',
                ),

                array(
                    'name'   => 'ajaxcart_singleproduct',
                    'label'  => esc_html__( 'Single Product Ajax Add To Cart', 'woolentor-pro' ),
                    'desc'  => wp_kses_post( 'AJAX Add to Cart on Single Product page', 'woolentor-pro' ),
                    'type'   => 'checkbox',
                    'default'=> 'off',
                    'class'  =>'woolentor_table_row',
                ),

                array(
                    'name'   => 'single_product_sticky_add_to_cart',
                    'label'  => esc_html__( 'Single Product Sticky Add To Cart', 'woolentor-pro' ),
                    'desc'  => wp_kses_post( 'Sticky Add to Cart on Single Product page', 'woolentor-pro' ),
                    'type'   => 'checkbox',
                    'default'=> 'off',
                    'class'  =>'woolentor_table_row',
                ),

                array(
                    'name'   => 'mini_side_cart',
                    'label'  => esc_html__( 'Side Mini Cart', 'woolentor-pro' ),
                    'type'   => 'checkbox',
                    'default'=> 'off',
                    'class'  =>'woolentor_table_row',
                ),

                array(
                    'name'    => 'mini_cart_position',
                    'label'   => esc_html__( 'Mini Cart Position', 'woolentor-pro' ),
                    'desc'    => esc_html__( 'Set the position of the Mini Cart .', 'woolentor-pro' ),
                    'type'    => 'select',
                    'default' => 'left',
                    'options' => array(
                        'left'   => esc_html__( 'Left','woolentor-pro' ),
                        'right'  => esc_html__( 'Right','woolentor-pro' ),
                    ),
                ),

                array(
                    'name'   => 'redirect_add_to_cart',
                    'label'  => esc_html__( 'Redirect to Checkout on Add to Cart', 'woolentor-pro' ),
                    'type'   => 'checkbox',
                    'default'=> 'off',
                    'class'  =>'woolentor_table_row',
                ),

                array(
                    'name'   => 'multi_step_checkout',
                    'label'  => esc_html__( 'Multi Step Checkout', 'woolentor-pro' ),
                    'type'   => 'checkbox',
                    'default'=> 'off',
                    'class'  =>'woolentor_table_row',
                ),

            ),

            'woolentor_style_tabs' => array(

                array(
                    'name'  => 'content_area_bg',
                    'label' => __( 'Content area background', 'woolentor' ),
                    'desc' => wp_kses_post( 'Default Color for universal layout.', 'woolentor' ),
                    'type' => 'color',
                    'default'=>'#ffffff',
                ),

                array(
                    'name'      => 'section_title_heading',
                    'type'      => 'title',
                    'headding'  => esc_html__( 'Title', 'woolentor' ),
                    'size'      => 'woolentor_style_seperator',
                ),
                array(
                    'name'  => 'title_color',
                    'label' => __( 'Title color', 'woolentor' ),
                    'desc' => wp_kses_post( 'Default Color for universal layout.', 'woolentor' ),
                    'type' => 'color',
                    'default'=>'#444444',
                ),
                array(
                    'name'  => 'title_hover_color',
                    'label' => __( 'Title hover color', 'woolentor' ),
                    'desc' => wp_kses_post( 'Default Color for universal layout.', 'woolentor' ),
                    'type' => 'color',
                    'default'=>'#dc9a0e',
                ),

                array(
                    'name'      => 'section_price_heading',
                    'type'      => 'title',
                    'headding'  => esc_html__( 'Price', 'woolentor' ),
                    'size'      => 'woolentor_style_seperator',
                ),
                array(
                    'name'  => 'sale_price_color',
                    'label' => __( 'Sale price color', 'woolentor' ),
                    'desc' => wp_kses_post( 'Default Color for universal layout.', 'woolentor' ),
                    'type' => 'color',
                    'default'=>'#444444',
                ),
                array(
                    'name'  => 'regular_price_color',
                    'label' => __( 'Regular price color', 'woolentor' ),
                    'desc' => wp_kses_post( 'Default Color for universal layout.', 'woolentor' ),
                    'type' => 'color',
                    'default'=>'#444444',
                ),

                array(
                    'name'      => 'section_category_heading',
                    'type'      => 'title',
                    'headding'  => esc_html__( 'Category', 'woolentor' ),
                    'size'      => 'woolentor_style_seperator',
                ),
                array(
                    'name'  => 'category_color',
                    'label' => __( 'Category color', 'woolentor' ),
                    'desc' => wp_kses_post( 'Default Color for universal layout.', 'woolentor' ),
                    'type' => 'color',
                    'default'=>'#444444',
                ),
                array(
                    'name'  => 'category_hover_color',
                    'label' => __( 'Category hover color', 'woolentor' ),
                    'desc' => wp_kses_post( 'Default Color for universal layout.', 'woolentor' ),
                    'type' => 'color',
                    'default'=>'#dc9a0e',
                ),

                array(
                    'name'      => 'section_short_description_heading',
                    'type'      => 'title',
                    'headding'  => esc_html__( 'Short Description', 'woolentor' ),
                    'size'      => 'woolentor_style_seperator',
                ),
                array(
                    'name'  => 'desc_color',
                    'label' => __( 'Description color', 'woolentor' ),
                    'desc' => wp_kses_post( 'Default Color for universal layout.', 'woolentor' ),
                    'type' => 'color',
                    'default'=>'#444444',
                ),

                array(
                    'name'      => 'section_rating_heading',
                    'type'      => 'title',
                    'headding'  => esc_html__( 'Rating', 'woolentor' ),
                    'size'      => 'woolentor_style_seperator',
                ),
                array(
                    'name'  => 'empty_rating_color',
                    'label' => __( 'Empty rating color', 'woolentor' ),
                    'desc' => wp_kses_post( 'Default Color for universal layout.', 'woolentor' ),
                    'type' => 'color',
                    'default'=>'#aaaaaa',
                ),
                array(
                    'name'  => 'rating_color',
                    'label' => __( 'Rating color', 'woolentor' ),
                    'desc' => wp_kses_post( 'Default Color for universal layout.', 'woolentor' ),
                    'type' => 'color',
                    'default'=>'#dc9a0e',
                ),

                array(
                    'name'      => 'section_badge_heading',
                    'type'      => 'title',
                    'headding'  => esc_html__( 'Product Badge', 'woolentor' ),
                    'size'      => 'woolentor_style_seperator',
                ),
                array(
                    'name'  => 'badge_color',
                    'label' => __( 'Badge color', 'woolentor' ),
                    'desc' => wp_kses_post( 'Default Color for universal layout.', 'woolentor' ),
                    'type' => 'color',
                    'default'=>'#444444',
                ),

                array(
                    'name'      => 'section_action_btn_heading',
                    'type'      => 'title',
                    'headding'  => esc_html__( 'Quick Action Button', 'woolentor' ),
                    'size'      => 'woolentor_style_seperator',
                ),
                array(
                    'name'  => 'tooltip_color',
                    'label' => __( 'Tool tip color', 'woolentor' ),
                    'desc' => wp_kses_post( 'Default Color for universal layout.', 'woolentor' ),
                    'type' => 'color',
                    'default'=>'#ffffff',
                ),
                array(
                    'name'  => 'btn_color',
                    'label' => __( 'Button color', 'woolentor' ),
                    'desc' => wp_kses_post( 'Default Color for universal layout.', 'woolentor' ),
                    'type' => 'color',
                    'default'=>'#000000',
                ),
                array(
                    'name'  => 'btn_hover_color',
                    'label' => __( 'Button hover color', 'woolentor' ),
                    'desc' => wp_kses_post( 'Default Color for universal layout.', 'woolentor' ),
                    'type' => 'color',
                    'default'=>'#dc9a0e',
                ),

                array(
                    'name'      => 'section_action_list_btn_heading',
                    'type'      => 'title',
                    'headding'  => esc_html__( 'List View Action Button', 'woolentor-pro' ),
                    'size'      => 'woolentor_style_seperator',
                ),
                array(
                    'name'  => 'list_btn_color',
                    'label' => __( 'List View Button color', 'woolentor' ),
                    'desc' => wp_kses_post( 'Default Color for universal layout.', 'woolentor' ),
                    'type' => 'color',
                    'default'=>'#000000',
                ),
                array(
                    'name'  => 'list_btn_hover_color',
                    'label' => __( 'List View Button Hover color', 'woolentor' ),
                    'desc' => wp_kses_post( 'Default Color for universal layout.', 'woolentor' ),
                    'type' => 'color',
                    'default'=>'#dc9a0e',
                ),
                array(
                    'name'  => 'list_btn_bg_color',
                    'label' => __( 'List View Button background color', 'woolentor' ),
                    'desc' => wp_kses_post( 'Default Color for universal layout.', 'woolentor' ),
                    'type' => 'color',
                    'default'=>'#ffffff',
                ),
                array(
                    'name'  => 'list_btn_hover_bg_color',
                    'label' => __( 'List View Button hover background color', 'woolentor' ),
                    'desc' => wp_kses_post( 'Default Color for universal layout.', 'woolentor' ),
                    'type' => 'color',
                    'default'=>'#ff3535',
                ),

                array(
                    'name'      => 'section_counter_timer_heading',
                    'type'      => 'title',
                    'headding'  => esc_html__( 'Counter Timer', 'woolentor' ),
                    'size'      => 'woolentor_style_seperator',
                ),
                array(
                    'name'  => 'counter_color',
                    'label' => __( 'Counter timer color', 'woolentor' ),
                    'desc' => wp_kses_post( 'Default Color for universal layout.', 'woolentor' ),
                    'type' => 'color',
                    'default'=>'#ffffff',
                ),

            ),

        );

        // Post Duplicator Condition
        if( !is_plugin_active('ht-mega-for-elementor/htmega_addons_elementor.php') ){
            $settings_fields['woolentor_others_tabs'][] = [
                'name'  => 'postduplicator',
                'label'  => esc_html__( 'Post Duplicator', 'woolentor-pro' ),
                'type'  => 'checkbox',
                'default'=>'off',
                'class'=>'woolentor_table_row',
            ];

            if( woolentor_get_option_pro( 'postduplicator', 'woolentor_others_tabs', 'off' ) === 'on' ){
                $post_types = woolentor_get_post_types( array('defaultadd'=>'all') );
                if ( did_action( 'elementor/loaded' ) && defined( 'ELEMENTOR_VERSION' ) ) {
                    $post_types['elementor_library'] = esc_html__( 'Templates', 'woolentor' );
                }
                $settings_fields['woolentor_others_tabs'][] = [
                    'name'    => 'postduplicate_condition',
                    'label'   => __( 'Post Duplicator Condition', 'woolentor' ),
                    'desc'    => __( 'You can enable duplicator for individual post.', 'woolentor' ),
                    'type'    => 'multiselect',
                    'default' => '',
                    'options' => $post_types,
                ];
            }
        }

        // Wishsuite Addons
        if( is_plugin_active('wishsuite/wishsuite.php') ){
            $settings_fields['woolentor_elements_tabs'][] = [
                'name'   => 'wb_wishsuite_table',
                'label'  => __( 'WishSuite Table', 'woolentor' ),
                'type'   => 'checkbox',
                'default' => 'on',
                'class'   => 'woolentor_table_row',
            ];
        }

        // Ever Compare Addons
        if( is_plugin_active('ever-compare/ever-compare.php') ){
            $settings_fields['woolentor_elements_tabs'][] = [
                'name'   => 'wb_ever_compare_table',
                'label'  => __( 'Ever Compare', 'woolentor' ),
                'type'   => 'checkbox',
                'default' => 'on',
                'class'   => 'woolentor_table_row',
            ];
        }

        // JustTable Addons
        if( is_plugin_active('just-tables/just-tables.php') || is_plugin_active('just-tables-pro/just-tables-pro.php') ){
            $settings_fields['woolentor_elements_tabs'][] = [
                'name'   => 'wb_just_table',
                'label'  => __( 'JustTable', 'woolentor' ),
                'type'   => 'checkbox',
                'default' => 'on',
                'class'   => 'woolentor_table_row',
            ];
        }

        // whols Addons
        if( is_plugin_active('whols/whols.php') || is_plugin_active('whols-pro/whols-pro.php') ){
            $settings_fields['woolentor_elements_tabs'][] = [
                'name'   => 'wb_whols',
                'label'  => __( 'Whols', 'woolentor' ),
                'type'   => 'checkbox',
                'default' => 'on',
                'class'   => 'woolentor_table_row',
            ];
        }

        // Multicurrency Addons
        if( is_plugin_active('wc-multi-currency/wcmilticurrency.php') || is_plugin_active('multicurrencypro/multicurrencypro.php') ){
            $settings_fields['woolentor_elements_tabs'][] = [
                'name'   => 'wb_wc_multicurrency',
                'label'  => __( 'Multi Currency', 'woolentor' ),
                'type'   => 'checkbox',
                'default' => 'on',
                'class'   => 'woolentor_table_row',
            ];
        }

        // Extra Addons
        if( woolentor_get_option( 'ajaxsearch', 'woolentor_others_tabs', 'off' ) == 'on' ){
            $settings_fields['woolentor_elements_tabs'][] = [
                'name'    => 'ajax_search_form',
                'label'   => __( 'Ajax Product Search Form', 'woolentor-pro' ),
                'type'    => 'checkbox',
                'default' => "on",
                'class'   => 'woolentor_table_row',
            ];
        }
        
        return array_merge( $settings_fields );
    }


    function plugin_page() {

        echo '<div class="wrap woolentor-setting-area">';
            echo '<div class="woolentor-opt-heading"><h2>'.esc_html__( 'WooLentor Settings','woolentor-pro' ).'</h2></div>';
            $this->save_message();
            $this->settings_api->show_navigation();
            $this->settings_api->show_forms();
        echo '</div>';

    }

    function save_message() {
        if( isset($_GET['settings-updated']) ) { ?>
            <div class="updated notice is-dismissible"> 
                <p><strong><?php esc_html_e('Successfully Settings Saved.', 'woolentor-pro') ?></strong></p>
            </div>
            <?php
        }
    }
    // Custom Markup
    
    // HTML Style tab Section
    function style_tab_html(){
        ob_start();
        ?>
        <div class="woolentor-style-tab-title">
            <h3><?php esc_html_e( 'Universal layout style options', 'woolentor-pro' );?></h3>
        </div>
        <?php
        echo ob_get_clean();
    }
    
    // HTML Style tab bottom Section
    function style_tab_bottom_html(){
        ob_start();
        ?>
        <div class="woolentor-style-tab-bottom">
            <h3><?php echo esc_html__( 'Helping Screenshot:', 'woolentor' ); ?></h3>
            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/universal-layout-screen.png" alt="<?php echo esc_attr__( 'Universal layout', 'woolentor' ); ?>">
        </div>
        <?php
        echo ob_get_clean();
    }

    // General tab
    function woolentor_html_general_tabs(){
        ob_start();
        ?>
            <div class="woolentor-general-tabs">

                <div class="woolentor-document-section">
                    <div class="woolentor-column">
                        <a href="https://www.youtube.com/watch?v=_MOgvsZJ6uA&list=PLk25BQFrj7wH9zCECMNCtEvvUKkpV5TYA" target="_blank">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/video-tutorial.jpg" alt="<?php esc_attr_e( 'Video Tutorial', 'woolentor-pro' ); ?>">
                        </a>
                    </div>
                    <div class="woolentor-column">
                        <a href="https://demo.hasthemes.com/doc/woolentor/index.html" target="_blank">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/online-documentation.jpg" alt="<?php esc_attr_e( 'Online Documentation', 'woolentor-pro' ); ?>">
                        </a>
                    </div>
                    <div class="woolentor-column">
                        <a href="https://hasthemes.com/contact-us/" target="_blank">
                            <img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/genral-contact-us.jpg" alt="<?php esc_attr_e( 'Contact Us', 'woolentor-pro' ); ?>">
                        </a>
                    </div>
                </div>

            </div>
        <?php
        echo ob_get_clean();
    }

    // Element Toogle Button
    function html_element_toogle_button(){
        ob_start();
        ?>
            <span class="wlopen-element-toggle"><?php esc_html_e( 'Toggle All', 'woolentor-pro' );?></span>
            <script type="text/javascript">
                (function($){
                    $(function() {
                        $('.wlopen-element-toggle').on('click', function() {
                          var inputCheckbox = $('#woolentor_elements_tabs').find('.woolentor_table_row input[type="checkbox"]');
                          if(inputCheckbox.prop("checked") === true){
                            inputCheckbox.prop('checked', false)
                          } else {
                            inputCheckbox.prop('checked', true)
                          }
                        });
                    });
                } )( jQuery );
            </script>
        <?php
        echo ob_get_clean();
    }

    // Theme Library
    function woolentor_html_themes_library_tabs() {
        ob_start();
        ?>
        <div class="woolentor-themes-laibrary woolentor-pro">
            <p><?php echo esc_html__( 'Use Our WooCommerce Theme for your online Store.', 'woolentor-pro' ); ?></p>
            <div class="woolentor-themes-area">
                <div class="woolentor-themes-row">

                    <div class="woolentor-single-theme"><img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/99fy.png" alt="">
                        <div class="woolentor-theme-content">
                            <h3><?php echo esc_html__( '99Fy - Free', 'woolentor' ); ?></h3>
                            <p><?php echo esc_html__( '99fy is a free WooCommerce theme. 99 demos for 24 niche categories are included in this theme.', 'woolentor' ); ?></p>
                            <a href="https://demo.hasthemes.com/99fy-preview/index.html" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            <a href="https://hasthemes.com/download-99fy" class="woolentor-button"><?php echo esc_html__( 'Download', 'woolentor' ); ?></a>
                        </div>
                    </div>

                    <div class="woolentor-single-theme"><img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/parlo.png" alt="">
                        <div class="woolentor-theme-content">
                            <h3><?php echo esc_html__( 'Parlo - Free', 'woolentor' ); ?></h3>
                            <p><?php echo esc_html__( 'Parlo is a free WooCommerce theme developed by our team. You can use this for your store.', 'woolentor' );?></p>
                            <a href="http://demo.hasthemes.com/wp/parlo-preview.html" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            <a href="https://freethemescloud.com/item/parlo-free-woocommerce-theme/" class="woolentor-button"><?php echo esc_html__( 'Download', 'woolentor' ); ?></a>
                        </div>
                    </div>

                    <div class="woolentor-single-theme"><img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/99fy-pro.png" alt="">
                        <div class="woolentor-theme-content">
                            <h3><?php echo esc_html__( '99Fy Pro - included in WooLentor Pro', 'woolentor' ); ?></h3>
                            <p><?php echo esc_html__( 'Pro version of 99fy is included in WooLentor pro. It will save money for the WooLentor pro users.', 'woolentor' ); ?></p>
                            <a href="https://demo.hasthemes.com/99fy-preview/index.html" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            <a href="https://clientportal.hasthemes.com/woolentor/" class="woolentor-button"><?php echo esc_html__( 'Download', 'woolentor' ); ?></a>
                        </div>
                    </div>

                    <div class="woolentor-single-theme"><img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/flone.png" alt="">
                        <div class="woolentor-theme-content">
                            <h3><?php echo esc_html__( 'Flone - included in WooLentor Pro', 'woolentor' ); ?></h3>
                            <p><?php echo esc_html__( 'Flone is one of our most popular WooComemrce Themes using by 1000+ stores.', 'wooLentor' );?></p>
                            <a href="https://demo.hasthemes.com/flone-woo-preview/index.html" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            <a href="https://clientportal.hasthemes.com/woolentor/" class="woolentor-button"><?php echo esc_html__( 'Download', 'woolentor' ); ?></a>
                        </div>
                    </div>

                    <div class="woolentor-single-theme"><img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/parlo.png" alt="">
                        <div class="woolentor-theme-content">
                            <h3><?php echo esc_html__( 'Parlo Pro - included in WooLentor Pro', 'woolentor' ); ?></h3>
                            <p><?php echo esc_html__( 'Pro version of Parlo is included in WooLentor pro. It will save money for the WooLentor pro users.', 'wooLentor' );?></p>
                            <a href="http://demo.hasthemes.com/wp/parlo-preview.html" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            <a href="https://clientportal.hasthemes.com/woolentor/" class="woolentor-button"><?php echo esc_html__( 'Download', 'woolentor' ); ?></a>
                        </div>
                    </div>

                    <div class="woolentor-single-theme"><img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/holmes.png" alt="">
                        <div class="woolentor-theme-content">
                            <h3><?php echo esc_html__( 'Holmes - included in WooLentor Pro', 'woolentor' ); ?></h3>
                            <p><?php echo esc_html__( 'Holmes is a preimum woocommerce theme included in WooLentor pro. It will save money for the WooLentor pro users.', 'woolentor' );?></p>
                            <a href="http://demo.hasthemes.com/wp/holmes-preview.html" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            <a href="https://clientportal.hasthemes.com/woolentor/" class="woolentor-button"><?php echo esc_html__( 'Download', 'woolentor' ); ?></a>
                        </div>
                    </div>
                    
                    <div class="woolentor-single-theme"><img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/daniel-home-1.png" alt="">
                        <div class="woolentor-theme-content">
                            <h3><?php echo esc_html__( 'Daniel - included in WooLentor Pro', 'woolentor' ); ?></h3>
                            <p><?php echo esc_html__( 'Daniel is a preimum woocommerce theme included in WooLentor pro. It will save money for the WooLentor pro users.', 'woolentor' ); ?></p>
                            <a href="http://demo.hasthemes.com/wp/daniel-preview.html" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            <a href="https://clientportal.hasthemes.com/woolentor/" class="woolentor-button"><?php echo esc_html__( 'Download', 'woolentor' ); ?></a>
                        </div>
                    </div>
                    
                    <div class="woolentor-single-theme"><img src="<?php echo WOOLENTOR_ADDONS_PL_URL; ?>/includes/admin/assets/images/hurst-home-1.png" alt="">
                        <div class="woolentor-theme-content">
                            <h3><?php echo esc_html__( 'Hurst - included in WooLentor Pro', 'woolentor' ); ?></h3>
                            <p><?php echo esc_html__( 'Hurst is a preimum woocommerce theme included in WooLentor pro. It will save money for the WooLentor pro users.', 'woolentor' ); ?></p>
                            <a href="http://demo.hasthemes.com/wp/hurst-preview.html" class="woolentor-button" target="_blank"><?php echo esc_html__( 'Preview', 'woolentor' ); ?></a>
                            <a href="https://clientportal.hasthemes.com/woolentor/" class="woolentor-button"><?php echo esc_html__( 'Download', 'woolentor' ); ?></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php
        echo ob_get_clean();
    }

}

new Woolentor_Admin_Settings_Pro();
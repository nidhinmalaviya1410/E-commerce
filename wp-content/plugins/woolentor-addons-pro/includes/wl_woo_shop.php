<?php

/*
*  Woolentor Pro Manage WooCommerce Builder Page.
*/
class Woolentor_Woo_Custom_Template_Layout_Pro{

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function __construct(){

        add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'woolentor_init_cart' ) );
        add_action('init', array( $this, 'init' ) );

        if ( ! empty( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] && is_admin() ) {
            add_action( 'init', array( $this, 'register_wc_hooks' ), 5 );
        }

    }

    public function init(){

        add_filter( 'wc_get_template', array( $this, 'woolentor_page_template' ), 50, 3 );
        
        // Cart
        add_action( 'woolentor_cart_content_build', array( $this, 'woolentor_cart_content' ) );
        add_action( 'woolentor_cartempty_content_build', array( $this, 'woolentor_emptycart_content' ) );
        
        // Checkout
        add_action( 'woolentor_checkout_content', array( $this, 'woolentor_checkout_content' ) );
        add_action( 'woolentor_checkout_top_content', array( $this, 'woolentor_checkout_top_content' ) );

        // Thank you Page
        add_action( 'woolentor_thankyou_content', array( $this, 'woolentor_thankyou_content' ) );

        // MyAccount
        add_action( 'woolentor_woocommerce_account_content', array( $this, 'woolentor_account_content' ) );
        add_action( 'woolentor_woocommerce_account_content_form_login', array( $this, 'woolentor_account_login_content' ) );

        // Quick View Content
        add_action( 'woolentor_quick_view_content', array( $this, 'woolentor_quick_view_content' ) );

        add_filter( 'template_include', array( $this, 'woolentor_woocommerce_page_template' ), 999);
    }

    /**
     *  Include WC fontend.
     */
    public function register_wc_hooks() {
        wc()->frontend_includes();
    }
    public function woolentor_init_cart() {
        $has_cart = is_a( WC()->cart, 'WC_Cart' );
        if ( ! $has_cart ) {
            $session_class = apply_filters( 'woocommerce_session_handler', 'WC_Session_Handler' );
            WC()->session = new $session_class();
            WC()->session->init();
            WC()->cart = new \WC_Cart();
            WC()->customer = new \WC_Customer( get_current_user_id(), true );
        }
    }

    public function woolentor_page_template( $template, $slug, $args ){

        if( $slug === 'cart/cart-empty.php'){
            $wlemptycart_page_id = woolentor_get_option_pro( 'productemptycartpage', 'woolentor_woo_template_tabs', '0' );
            if( !empty( $wlemptycart_page_id ) ) {
                $template = WOOLENTOR_ADDONS_PL_PATH_PRO . 'wl-woo-templates/cart-empty-elementor.php';
            }
        }
        elseif( $slug === 'cart/cart.php' ){
            $wlcart_page_id = woolentor_get_option_pro( 'productcartpage', 'woolentor_woo_template_tabs', '0' );
            if( !empty( $wlcart_page_id ) ) {
                $template = WOOLENTOR_ADDONS_PL_PATH_PRO . 'wl-woo-templates/cart-elementor.php';
            }
        }elseif( $slug === 'checkout/form-checkout.php' ){
            $wlcheckout_page_id = woolentor_get_option_pro( 'productcheckoutpage', 'woolentor_woo_template_tabs', '0' );
            if( !empty( $wlcheckout_page_id ) ) {
                $template = WOOLENTOR_ADDONS_PL_PATH_PRO . 'wl-woo-templates/form-checkout.php';
            }
        }elseif( $slug === 'checkout/thankyou.php' ){
            $wlthankyou_page_id = woolentor_get_option_pro( 'productthankyoupage', 'woolentor_woo_template_tabs', '0' );
            if( !empty( $wlthankyou_page_id ) ) {
                $template = WOOLENTOR_ADDONS_PL_PATH_PRO . 'wl-woo-templates/thankyou.php';
            }
        }elseif( $slug === 'myaccount/my-account.php' ){
            $wlmyaccount_page_id = woolentor_get_option_pro( 'productmyaccountpage', 'woolentor_woo_template_tabs', '0' );
            if( !empty( $wlmyaccount_page_id ) ) {
                $template = WOOLENTOR_ADDONS_PL_PATH_PRO . 'wl-woo-templates/my-account.php';
            }
        }elseif( $slug === 'myaccount/form-login.php' ){
            $wlmyaccount_login_page_id = woolentor_get_option_pro( 'productmyaccountloginpage', 'woolentor_woo_template_tabs', '0' );
            if( !empty( $wlmyaccount_login_page_id ) ) {
                $template = WOOLENTOR_ADDONS_PL_PATH_PRO . 'wl-woo-templates/form-login.php';
            }
        }

        return $template;
    }

    public function woolentor_emptycart_content(){
        $elementor_page_id = woolentor_get_option_pro( 'productemptycartpage', 'woolentor_woo_template_tabs', '0' );
        if( !empty( $elementor_page_id ) ){
            echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $elementor_page_id );
        }
    }

    public function woolentor_cart_content(){
        $elementor_page_id = woolentor_get_option_pro( 'productcartpage', 'woolentor_woo_template_tabs', '0' );
        if( !empty( $elementor_page_id ) ){
            echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $elementor_page_id );
        }
    }

    public function woolentor_checkout_content(){
        $elementor_page_id = woolentor_get_option_pro( 'productcheckoutpage', 'woolentor_woo_template_tabs', '0' );
        if( !empty( $elementor_page_id ) ){
            echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $elementor_page_id );
        }else{ the_content(); }
    }

    public function woolentor_checkout_top_content(){
        $elementor_page_id = woolentor_get_option_pro( 'productcheckouttoppage', 'woolentor_woo_template_tabs', '0' );
        if( !empty( $elementor_page_id ) ){
            echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $elementor_page_id );
        }
    }

    public function woolentor_thankyou_content(){
        $elementor_page_id = woolentor_get_option_pro( 'productthankyoupage', 'woolentor_woo_template_tabs', '0' );
        if( !empty( $elementor_page_id ) ){
            echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $elementor_page_id );
        }else{ the_content(); }
    }

    public function woolentor_account_content(){
        $elementor_page_id = woolentor_get_option_pro( 'productmyaccountpage', 'woolentor_woo_template_tabs', '0' );
        if ( is_user_logged_in() && !empty($elementor_page_id) ){
            echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $elementor_page_id );
        }else{ the_content(); }
    }

    public function woolentor_account_login_content(){
        $elementor_page_id = woolentor_get_option_pro( 'productmyaccountloginpage', 'woolentor_woo_template_tabs', '0' );
        if ( !empty($elementor_page_id) ){
            echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $elementor_page_id );
        }else{ the_content(); }
    }

    public function woolentor_quick_view_content(){
        $elementor_page_id = woolentor_get_option_pro( 'productquickview', 'woolentor_woo_template_tabs', '0' );
        if( !empty( $elementor_page_id ) ){
            echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $elementor_page_id );
        }
    }

    public function woolentor_get_page_template_path( $page_template ) {
        $template_path = '';
        if( $page_template === 'elementor_header_footer' ){
            $template_path = WOOLENTOR_ADDONS_PL_PATH_PRO . 'wl-woo-templates/page/header-footer.php';
        }elseif( $page_template === 'elementor_canvas' ){
            $template_path = WOOLENTOR_ADDONS_PL_PATH_PRO . 'wl-woo-templates/page/canvas.php';
        }
        return $template_path;
    }

    public function woolentor_woocommerce_page_template( $template ){

        $elementor_page_slug = 0;

        if( is_cart() ){
            $cart_page_id = woolentor_get_option_pro( 'productcartpage', 'woolentor_woo_template_tabs', '0' );
            if( !empty( $cart_page_id ) ){
                $elementor_page_slug = get_page_template_slug( $cart_page_id );
            }
        }elseif ( is_checkout() ){
            $wl_checkout_page_id = woolentor_get_option_pro( 'productcheckoutpage', 'woolentor_woo_template_tabs', '0' );
            if( !empty($wl_checkout_page_id) ){
                $elementor_page_slug = get_page_template_slug( $wl_checkout_page_id );
            }
            
        }elseif ( is_account_page() && is_user_logged_in() ){
            $wl_myaccount_page_id = woolentor_get_option_pro( 'productmyaccountpage', 'woolentor_woo_template_tabs', '0' );
            if( !empty($wl_myaccount_page_id) ){
                $elementor_page_slug = get_page_template_slug( $wl_myaccount_page_id );
            }
        }
        
        if( !empty($elementor_page_slug) ){
            $template_path = $this->woolentor_get_page_template_path( $elementor_page_slug );
            if ( $template_path ) {
                $template = $template_path;
            }
        }
        
        return $template;
    }

}

Woolentor_Woo_Custom_Template_Layout_Pro::instance();
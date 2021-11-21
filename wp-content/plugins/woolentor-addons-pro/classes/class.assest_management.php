<?php

namespace WooLentorPro;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
* Assest Management
*/
class Assets_Management{
    
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

        // Register Scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'register_assets' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'register_assets' ] );

    }

    /**
     * All available styles
     *
     * @return array
     */
    public function get_styles() {
        return [
            'woolentor-widgets-pro' => [
                'src'     => WOOLENTOR_ADDONS_PL_URL_PRO . 'assets/css/woolentor-widgets-pro.css',
                'version' => WOOLENTOR_VERSION_PRO
            ],
            'woolentor-animate' => [
                'src'     => WOOLENTOR_ADDONS_PL_URL_PRO . 'assets/css/animate.css',
                'version' => WOOLENTOR_VERSION_PRO
            ],
            'woolentor-mini-cart' => [
                'src'     => WOOLENTOR_ADDONS_PL_URL_PRO . 'assets/css/woolentor-mini-cart.css',
                'version' => WOOLENTOR_VERSION_PRO
            ],
            'woolentor-product-expanding-grid' => [
                'src'     => WOOLENTOR_ADDONS_PL_URL_PRO . 'assets/css/woolentor-product-expanding-grid.css',
                'version' => WOOLENTOR_VERSION_PRO
            ],
            'wlflickity' => [
                'src'     => WOOLENTOR_ADDONS_PL_URL_PRO . 'assets/lib/css/flickity.css',
                'version' => WOOLENTOR_VERSION_PRO
            ],
            'woolentor-filtarable-grid' => [
                'src'     => WOOLENTOR_ADDONS_PL_URL_PRO . 'assets/css/woolentor-filtarable-grid.css',
                'version' => WOOLENTOR_VERSION_PRO,
                'deps'    => [ 'wlflickity' ]
            ],
            'woolentor-multi-steps-checkout' => [
                'src'     => WOOLENTOR_ADDONS_PL_URL_PRO . 'assets/css/woolentor-multi-step-checkout.css',
                'version' => WOOLENTOR_VERSION_PRO,
                'deps'    => [ 'wlflickity' ]
            ],
            
        ];
    }

    /**
     * All available scripts
     *
     * @return array
     */
    public function get_scripts() {
        return [
            'woolentor-easyzoom' => [
                'src'     => WOOLENTOR_ADDONS_PL_URL_PRO . 'assets/js/easyzoom.js',
                'version' => WOOLENTOR_VERSION_PRO,
                'deps'    => [ 'jquery' ]
            ],
            'woolentor-widgets-scripts-pro' => [
                'src'     => WOOLENTOR_ADDONS_PL_URL_PRO . 'assets/js/woolentor-widgets-active-pro.js',
                'version' => WOOLENTOR_VERSION_PRO,
                'deps'    => [ 'jquery' ]
            ],
            'woolentor-main' => [
                'src'     => WOOLENTOR_ADDONS_PL_URL_PRO . 'assets/js/main.js',
                'version' => WOOLENTOR_VERSION_PRO,
                'deps'    => [ 'jquery' ]
            ],
            'woolentor-mini-cart' => [
                'src'     => WOOLENTOR_ADDONS_PL_URL_PRO . 'assets/js/woolentor-mini-cart.js',
                'version' => WOOLENTOR_VERSION_PRO,
                'deps'    => [ 'jquery' ]
            ],
            'wlanime' => [
                'src'     => WOOLENTOR_ADDONS_PL_URL_PRO . 'assets/js/anime.min.js',
                'version' => WOOLENTOR_VERSION_PRO,
                'deps'    => [ 'jquery' ]
            ],
            'wlexpanding-scripts' => [
                'src'     => WOOLENTOR_ADDONS_PL_URL_PRO . 'assets/js/wlexpanding-scripts.js',
                'version' => WOOLENTOR_VERSION_PRO,
                'deps'    => [ 'imagesloaded','wlanime' ]
            ],

            'wlisotope' => [
                'src'     => WOOLENTOR_ADDONS_PL_URL_PRO . 'assets/lib/js/isotope.pkgd.min.js',
                'version' => WOOLENTOR_VERSION_PRO,
                'deps'    => [ 'jquery' ]
            ],

            'woolentor-multi-steps-checkout' => [
                'src'     => WOOLENTOR_ADDONS_PL_URL_PRO . 'assets/js/woolentor-multi-checkout.js',
                'version' => WOOLENTOR_VERSION_PRO,
                'deps'    => [ 'jquery' ]
            ],

        ];
    }

    /**
     * Register scripts and styles
     *
     * @return void
     */
    public function register_assets() {
        $scripts = $this->get_scripts();
        $styles  = $this->get_styles();

        // Register Scripts
        foreach ( $scripts as $handle => $script ) {
            $deps = ( isset( $script['deps'] ) ? $script['deps'] : false );
            wp_register_script( $handle, $script['src'], $deps, $script['version'], true );
        }

        // Register Styles
        foreach ( $styles as $handle => $style ) {
            $deps = ( isset( $style['deps'] ) ? $style['deps'] : false );
            wp_register_style( $handle, $style['src'], $deps, $style['version'] );
        }

        // Empty Cart page 
        if( function_exists('is_cart') ){
            if( is_cart() ){
                $wp_upload_dir = wp_upload_dir();
                $empty_cart_page_id = woolentor_get_option_pro( 'productemptycartpage', 'woolentor_woo_template_tabs', '0' );
                if( !empty( $empty_cart_page_id ) ) {
                    if ( !$wp_upload_dir['error'] ) {
                        $url = $wp_upload_dir['baseurl'].'/elementor/css/post-'.$empty_cart_page_id.'.css';
                        wp_enqueue_style( 'wlb-empty-cart', $url );
                    }
                }
            }
        }

        // Item Add to cart
        if( isset( $_POST['add-to-cart'] ) ){ $addedtocart = true; }else{ $addedtocart = false;}

        $localizedata = array(
            'addedToCart' => $addedtocart,
        );
        wp_localize_script( 'woolentor-mini-cart', 'woolentorMiniCart', $localizedata );
        
    }


}

Assets_Management::instance();
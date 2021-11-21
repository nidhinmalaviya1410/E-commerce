<?php
/**
* Mini Cart Manager
*/
class WooLentor_Mini_Cart {
    /**
     * [$instance]
     * @var null
     */
    private static $instance = null;

    /**
     * [instance] Initializes a singleton instance
     * @return [WooLentor_Mini_Cart]
     */
    public static function instance(){
        if( is_null( self::$instance ) ){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * [__construct] Class Construction
     */
    function __construct(){

        add_action( 'woolentor_cart_content', [ $this, 'get_cart_item' ] );

        add_filter( 'woocommerce_add_to_cart_fragments', [ $this,'wc_add_to_cart_fragment' ], 10, 1 );

    }

    /**
     * [get_cart_item] Render fragment cart item
     * @return [html]
     */
    public function get_cart_item(){

        $cart_data  = WC()->cart->get_cart();
        $args = array();
        ob_start();
        $mini_cart_tmp_id = woolentor_get_option_pro( 'mini_cart_layout', 'woolentor_woo_template_tabs', '0' );
        if( !empty( $mini_cart_tmp_id ) ){
            echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $mini_cart_tmp_id );
        }else{
            wc_get_template( 'tmp-mini_cart_content.php', $args, '', WOOLENTOR_TEMPLATE_PRO );
        }
        return ob_get_clean();

    }

    /**
     * [wc_add_to_cart_fragment] add to cart freagment callable
     * @param  [type] $fragments
     * @return [type] $fragments
     */
    public function wc_add_to_cart_fragment( $fragments ){

        $item_count = WC()->cart->get_cart_contents_count();
        $cart_item = $this->get_cart_item();

        // Cart Item
        $fragments['div.woolentor_cart_content_container'] = '<div class="woolentor_cart_content_container">'.$cart_item.'</div>';

        //Cart Counter
        $fragments['span.woolentor_mini_cart_counter'] = '<span class="woolentor_mini_cart_counter">'.$item_count.'</span>';

        return $fragments;
    }
    

}
WooLentor_Mini_Cart::instance();
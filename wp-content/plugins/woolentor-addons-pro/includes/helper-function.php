<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit();

/**
 * Quick View Content Template
 */
add_filter( 'woolentor_quickview_tmp', 'woolentor_quickview_template', 10, 1 );
function woolentor_quickview_template( $template ){
    $template_id = woolentor_get_option_pro( 'productquickview', 'woolentor_woo_template_tabs', '0' );
    if( !empty( $template_id ) ){
        $template = WOOLENTOR_ADDONS_PL_PATH_PRO.'includes/quickview-content.php';
    }
    return $template;
}

/**
* Options return
*/
function woolentor_get_option_pro( $option, $section, $default = '' ){
    $options = get_option( $section );
    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }
    return $default;
}

function woolentor_get_option_text( $option, $section, $default = '' ){
    $options = get_option( $section );
    if ( isset( $options[$option] ) ) {
        if( !empty($options[$option]) ){
            return $options[$option];
        }
        return $default;
    }
    return $default;
}

/**
* Woocommerce Product last order id return
*/
function woolentor_get_last_order_id(){
    global $wpdb;
    $statuses = array_keys(wc_get_order_statuses());
    $statuses = implode( "','", $statuses );

    // Getting last Order ID (max value)
    $results = $wpdb->get_col( "
        SELECT MAX(ID) FROM {$wpdb->prefix}posts
        WHERE post_type LIKE 'shop_order'
        AND post_status IN ('$statuses')" 
    );
    return reset($results);
}

/**
 * [woolentor_pro_template_endpoint]
 * @return [url]
 */
function woolentor_pro_template_endpoint(){
    return 'https://woolentor.com/library/wp-json/woolentor/v1promnmnsdc/templates';
}

/**
 * [woolentor_pro_template_url]
 * @return [url]
 */
function woolentor_pro_template_url(){
    return 'https://woolentor.com/library/wp-json/woolentor/v1/templates/%s';
}

/**
* Add Inline CSS.
*/
function woolentor_styles_inline() {

    $containerwid = get_option( 'elementor_container_width', '1140' );
    if( $containerwid == 0 ){ $containerwid = '1140'; }

    $emptycartcss = $checkoutpagecss = $noticewrap = '';
    
    if ( class_exists( 'WooCommerce' ) ) {
        if ( is_cart() && WC()->cart->is_empty() ) {
            $emptycartcss = "
                .woolentor-page-template .woocommerce{
                    margin: 0 auto;
                    width: {$containerwid}px;
                }
            ";
        }
        if( is_checkout() ){
            $checkoutpagecss = "
               .woolentor-woocommerce-checkout .woocommerce-NoticeGroup, .woocommerce-error{
                    margin: 0 auto;
                    width: {$containerwid}px;
                } 
            ";
        }
    }

    $noticewrap = "
        .woocommerce-notices-wrapper{
            margin: 0 auto;
            width: {$containerwid}px;
        }
    ";

    $custom_css = "
        $emptycartcss
        $checkoutpagecss
        $noticewrap
        ";
    wp_add_inline_style( 'woolentor-widgets-pro', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'woolentor_styles_inline' );


if( class_exists('WooCommerce') ){
    /**
     * [woolentor_stock_status]
     */
    function woolentor_stock_status_pro( $order_text, $available_text, $product_id ){

        $product_id  = $product_id;
        if ( get_post_meta( $product_id, '_manage_stock', true ) == 'yes' ) {

            $total_stock = get_post_meta( $product_id, 'woolentor_total_stock_quantity', true );

            if ( ! $total_stock ) { echo '<div class="stock-management-progressbar">'.__('Do not set stock amount for progress bar','woolentor-pro').'</div>'; return; }

            $current_stock = round( get_post_meta( $product_id, '_stock', true ) );

            $total_sold = $total_stock > $current_stock ? $total_stock - $current_stock : 0;
            $percentage = $total_sold > 0 ? round( $total_sold / $total_stock * 100 ) : 0;

            if ( $current_stock >= 0 ) {
                echo '<div class="woolentor-stock-progress-bar">';
                    echo '<div class="wlstock-info">';
                        echo '<div class="wltotal-sold">' . __( $order_text, 'woolentor-pro' ) . '<span>' . esc_html( $total_sold ) . '</span></div>';
                        echo '<div class="wlcurrent-stock">' . __( $available_text, 'woolentor-pro' ) . '<span>' . esc_html( $current_stock ) . '</span></div>';
                    echo '</div>';
                    echo '<div class="wlprogress-area" title="' . __( 'Sold', 'woolentor-pro' ) . ' ' . esc_attr( $percentage ) . '%">';
                        echo '<div class="wlprogress-bar"style="width:' . esc_attr( $percentage ) . '%;"></div>';
                    echo '</div>';
                echo '</div>';
            }

        }

    }

    function Woolentor_Control_Sale_Badge( $settings, $id ){
        $product = wc_get_product( $id );

        $discount = '';
        $regurlar_price = get_post_meta( $id, '_regular_price', true);
        $sale_price  = get_post_meta( $id, '_sale_price', true);
        $currency = get_woocommerce_currency_symbol();

        if( $product->is_type('variable') && $product->is_on_sale() ) {
            $regurlar_price = $product->get_variation_regular_price(); // Min regular price
            $sale_price     = $product->get_variation_price(); // Min Sale price
        }

        $sale_badge_after = isset( $settings['product_after_badge_percent'] )?$settings['product_after_badge_percent']:'';
        $sale_badge_before = isset( $settings['product_before_badge_percent'] )?$settings['product_before_badge_percent']:'';

        if( $settings['product_sale_badge_type'] === 'custom' ){
           echo '<span class="ht-product-label ht-product-label-right">'. $settings['product_sale_badge_custom'].'</span>';
        }elseif ($settings['product_sale_badge_type'] === 'dis_percent' ) {
            if($regurlar_price && $sale_price ){
                $price = ( $regurlar_price-$sale_price )/$regurlar_price;
                $discount = round($price *100);
                $discount =  '<span class="ht-product-label ht-product-label-right">'.$sale_badge_before.' '. $discount . __( '%', 'woolentor-pro' ) .' '. $sale_badge_after.'</span>';
            }
            echo wp_kses_post( $discount );
        }elseif ($settings['product_sale_badge_type'] === 'dis_price' ) {
            if($regurlar_price && $sale_price ){
                $price = ( $regurlar_price - $sale_price );
                $discount = $price;
                $discount =  '<span class="ht-product-label ht-product-label-right">'.$sale_badge_before.' '. $discount . $currency .' '.$sale_badge_after.'</span>';
            }
            echo wp_kses_post( $discount );
        }else{
            woolentor_sale_flash();
        }

    }

    
}
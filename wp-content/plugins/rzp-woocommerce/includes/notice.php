<?php

/**
 * The admin-facing functionality of the plugin.
 *
 * @package    Razorpay Payment Links for WooCommerce
 * @subpackage Includes
 * @author     Sayan Datta
 * @license    http://www.gnu.org/licenses/ GNU General Public License
 */

add_action( 'admin_notices', 'rzpwc_rating_admin_notice' );
add_action( 'admin_init', 'rzpwc_dismiss_rating_admin_notice' );

function rzpwc_rating_admin_notice() {
    // Show notice after 168 hours (7 days) from installed time.
    if ( rzpwc_plugin_get_installed_time() > strtotime( '-168 hours' )
        || '1' === get_option( 'rzpwc_plugin_dismiss_rating_notice' )
        || ! current_user_can( 'manage_options' )
        || apply_filters( 'rzpwc_plugin_hide_sticky_notice', false ) ) {
        return;
    }

    $dismiss = wp_nonce_url( add_query_arg( 'rzpwc_rating_notice_action', 'dismiss_rating_true' ), 'rzpwc_dismiss_rating_true' ); 
    $no_thanks = wp_nonce_url( add_query_arg( 'rzpwc_rating_notice_action', 'no_thanks_rating_true' ), 'rzpwc_no_thanks_rating_true' ); ?>
    
    <div class="notice notice-success">
        <p><?php _e( 'Hey, I noticed you\'ve been using Razorpay Payment Links for WooCommerce for more than 1 week – that’s awesome! Could you please do me a BIG favor and give it a <strong>5-star</strong> rating on WordPress? Just to help me spread the word and boost my motivation.', 'rzp-woocommerce' ); ?></p>
        <p><a href="https://wordpress.org/support/plugin/rzp-woocommerce/reviews/?filter=5#new-post" target="_blank" class="button button-secondary"><?php _e( 'Ok, you deserve it', 'rzp-woocommerce' ); ?></a>&nbsp;
        <a href="<?php echo $dismiss; ?>" class="already-did"><strong><?php _e( 'I already did', 'rzp-woocommerce' ); ?></strong></a>&nbsp;<strong>|</strong>
        <a href="<?php echo $no_thanks; ?>" class="later"><strong><?php _e( 'Nope&#44; maybe later', 'rzp-woocommerce' ); ?></strong></a></p>
    </div>
<?php
}

function rzpwc_dismiss_rating_admin_notice() {
    if( get_option( 'rzpwc_plugin_no_thanks_rating_notice' ) === '1' ) {
        if ( get_option( 'rzpwc_plugin_dismissed_time' ) > strtotime( '-360 hours' ) ) {
            return;
        }
        delete_option( 'rzpwc_plugin_dismiss_rating_notice' );
        delete_option( 'rzpwc_plugin_no_thanks_rating_notice' );
    }

    if ( ! isset( $_GET['rzpwc_rating_notice_action'] ) ) {
        return;
    }

    if ( 'dismiss_rating_true' === $_GET['rzpwc_rating_notice_action'] ) {
        check_admin_referer( 'rzpwc_dismiss_rating_true' );
        update_option( 'rzpwc_plugin_dismiss_rating_notice', '1' );
    }

    if ( 'no_thanks_rating_true' === $_GET['rzpwc_rating_notice_action'] ) {
        check_admin_referer( 'rzpwc_no_thanks_rating_true' );
        update_option( 'rzpwc_plugin_no_thanks_rating_notice', '1' );
        update_option( 'rzpwc_plugin_dismiss_rating_notice', '1' );
        update_option( 'rzpwc_plugin_dismissed_time', time() );
    }

    wp_redirect( remove_query_arg( 'rzpwc_rating_notice_action' ) );
    exit;
}

function rzpwc_plugin_get_installed_time() {
    $installed_time = get_option( 'rzpwc_plugin_installed_time' );
    if ( ! $installed_time ) {
        $installed_time = time();
        update_option( 'rzpwc_plugin_installed_time', $installed_time );
    }
    return $installed_time;
}
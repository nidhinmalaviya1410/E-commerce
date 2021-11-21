<?php
/**
 * The admin-facing functionality of the plugin.
 *
 * @package    Razorpay Payment Links for WooCommerce
 * @subpackage Includes
 * @author     Sayan Datta
 * @license    http://www.gnu.org/licenses/ GNU General Public License
 */

// add razorpay Gateway to woocommerce
add_filter( 'woocommerce_payment_gateways', 'rzpwc_payment_add_gateway_class' );

function rzpwc_payment_add_gateway_class( $gateways ) {
	$gateways[] = 'WC_RZP_Woo_Gateway'; // class name
    
    return $gateways;
}

/*
 * The class itself, please note that it is inside plugins_loaded action hook
 */
add_action( 'plugins_loaded', 'rzpwc_payment_gateway_class' );

function rzpwc_payment_gateway_class() {

    // If the WooCommerce payment gateway class is not available nothing will return
	if ( ! class_exists( 'WC_Payment_Gateway' ) ) return;
 
	class WC_RZP_Woo_Gateway extends WC_Payment_Gateway {

        /**
	     * Whether or not logging is enabled
	     *
	     * @var bool
	     */
	    public static $log_enabled = false;
    
	    /**
	     * Logger instance
	     *
	     * @var WC_Logger
	     */
	    public static $log = false;
     
 	    /**
 		 * Class constructor
 		 */
 		public function __construct() {
 
            $this->id = 'wc-razorpay'; // payment gateway plugin ID
            $this->icon = apply_filters( 'rzpwc_custom_gateway_icon', RZPWC_WOO_PLUGIN_DIR . 'includes/images/logo.png' ); // URL of the icon that will be displayed on checkout page near your gateway name
            $this->has_fields = false; // in case need a custom credit card form
            $this->method_title = __( 'Razorpay Payment Gateway', 'rzp-woocommerce' );
            $this->method_description = __( 'Allow customers to securely pay via Razorpay Payment Links using Credit/Debit Cards, NetBanking, UPI, Wallets, QR Codes.', 'rzp-woocommerce' ); // will be displayed on the options page
            $this->order_button_text = __( 'Proceed to Payment', 'rzp-woocommerce' );
            $this->supports = array(
                'products',
				'refunds',
            );

            // Method with all the options fields
            $this->init_form_fields();
         
            // Load the settings.
            $this->init_settings();

            $this->enabled = $this->get_option( 'enabled' );
            $this->title = $this->get_option( 'title' );
            $this->description = $this->get_option( 'description' );
            $this->thank_you = $this->get_option( 'thank_you' );
            $this->api_type = $this->get_option( 'api_type', 'legacy' );
            $this->testmode = 'yes' === $this->get_option( 'testmode' );
            $this->key_id = $this->testmode ? $this->get_option( 'test_key_id' ) : $this->get_option( 'key_id' );
            $this->key_secret = $this->testmode ? $this->get_option( 'test_key_secret' ) : $this->get_option( 'key_secret' );
            $this->webhook_enabled = $this->get_option( 'webhook_enabled' );
            $this->webhook_secret = $this->get_option( 'webhook_secret' );
            $this->sms_notification = $this->get_option( 'sms_notification' );
            $this->email_notification = $this->get_option( 'email_notification' );
            $this->reminder = $this->get_option( 'reminder' );
            $this->link_expire = $this->get_option( 'link_expire' );
            $this->gateway_fee = $this->get_option( 'gateway_fee' );
            $this->instant_refund = $this->get_option( 'instant_refund' );
            $this->debug = 'yes' === $this->get_option( 'debug_mode', 'no' );
            self::$log_enabled = $this->debug;

            if ( $this->testmode ) {
                $this->title .= ' ' . __( '(Test Mode)', 'rzp-woocommerce' );
                /* translators: %s: Link to Razorpay testing guide page */
                $this->description .= ' ' . sprintf( __( 'TESTING MODE ENABLED. You can use Razorpay testing accounts only. See the <a href="%s" target="_blank">Razorpay Testing Guide</a> for more details.', 'rzp-woocommerce' ), 'https://razorpay.com/docs/payment-gateway/test-card-details/' );
                $this->description = trim( $this->description );
            }

            $this->api_mode = 'invoice';
            $this->ref = 'receipt';
            $this->status = 'issued';
            if ( $this->api_type === 'standard' ) {
                $this->api_mode = 'payment_link';
                $this->ref = 'reference_id';
                $this->status = 'created';
            }

            // This action hook saves the settings
            if ( version_compare( WOOCOMMERCE_VERSION, '2.0.0', '>=' ) ) {
                add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
            } else {
                add_action( 'woocommerce_update_options_payment_gateways', array( $this, 'process_admin_options' ) );
            }
            
            // verify payment from redirection
            add_action( 'woocommerce_api_rzp-payment', array( $this, 'capture_payment' ) );

            // verify payment from webhook
            add_action( 'woocommerce_api_rzp-webhook', array( $this, 'process_webhook' ) );

            // cancel invoice if order paid via other payment gateways
            add_action( 'woocommerce_order_status_processing', array( $this, 'cancel_payment_link' ), 10, 1 );
            
            // cancel invoice if order cancelled
            add_action( 'woocommerce_order_status_cancelled', array( $this, 'cancel_payment_link' ), 10, 1 );

            // add custom text on thankyou page
            add_filter( 'woocommerce_thankyou_order_received_text', array( $this, 'order_received_text' ), 10, 2 );

            // change wc payment link if exists razorpay link
            add_filter( 'woocommerce_get_checkout_payment_url', array( $this, 'custom_checkout_url' ), 10, 2 );

            if ( ! $this->is_valid_for_use() ) {
                $this->enabled = 'no';
            }
        }
         
        /**
	     * Logging method.
	     *
	     * @param string $message Log message.
	     * @param string $level Optional. Default 'info'. Possible values:
	     *                      emergency|alert|critical|error|warning|notice|info|debug.
	     */
	    public static function log( $message, $level = 'info' ) {
	    	if ( self::$log_enabled ) {
	    		if ( empty( self::$log ) ) {
	    			self::$log = wc_get_logger();
	    		}
	    		self::$log->log( $level, $message, array( 'source' => 'razorpay' ) );
	    	}
        }
        
        /**
	     * Processes and saves options.
	     * If there is an error thrown, will continue to save and validate fields, but will leave the erroring field out.
	     *
	     * @return bool was anything saved?
	     */
	    public function process_admin_options() {
	    	$saved = parent::process_admin_options();

            // auto enable webhook
            $this->auto_enable_webhook();
            
	    	// Maybe clear logs.
	    	if ( 'yes' !== $this->get_option( 'debug_mode', 'no' ) ) {
	    		if ( empty( self::$log ) ) {
	    			self::$log = wc_get_logger();
	    		}
	    		self::$log->clear( 'razorpay' );
	    	}
    
	    	return $saved;
        }

        /**
	     * Check if this gateway is enabled and available in the user's country.
	     *
	     * @return bool
	     */
	    public function is_valid_for_use() {
	    	return in_array(
	    		get_woocommerce_currency(),
	    		apply_filters(
	    			'rzpwc_gateway_supported_currencies',
	    			array( 'AED', 'ALL', 'AMD', 'ARS', 'AUD', 'AWG', 'BBD', 'BDT', 'BMD', 'BND', 'BOB', 'BSD', 'BWP', 'BZD', 'CAD', 'CHF', 'CNY', 'COP', 'CRC', 'CUP', 'CZK', 'DKK', 'DOP', 'DZD', 'EGP', 'ETB', 'EUR', 'FJD', 'GBP', 'GIP', 'GHS', 'GMD', 'GTQ', 'GYD', 'HKD', 'HNL', 'HRK', 'HTG', 'HUF', 'IDR', 'ILS', 'INR', 'JMD', 'KES', 'KGS', 'KHR', 'KYD', 'KZT', 'LAK', 'LBP', 'LKR', 'LRD', 'LSL', 'MAD', 'MDL', 'MKD', 'MMK', 'MNT', 'MOP', 'MUR', 'MVR', 'MWK', 'MXN', 'MYR', 'NAD', 'NGN', 'NIO', 'NOK', 'NPR', 'NZD', 'PEN', 'PGK', 'PHP', 'PKR', 'QAR', 'RUB', 'SAR', 'SCR', 'SEK', 'SGD', 'SLL', 'SOS', 'SSP', 'SVC', 'SZL', 'THB', 'TTD', 'TZS', 'USD', 'UYU', 'UZS', 'YER', 'ZAR' )
	    		),
	    		true
	    	);
        }
        
        /**
	     * Admin Panel Options.
	     * - Options for bits like 'title' and availability on a country-by-country basis.
	     *
	     * @since 1.0.0
	     */
	    public function admin_options() {
	    	if ( $this->is_valid_for_use() ) {
	    		parent::admin_options();
	    	} else {
	    		?>
	    		<div class="inline error">
	    			<p>
	    				<strong><?php esc_html_e( 'Gateway disabled', 'rzp-woocommerce' ); ?></strong>: <?php 
                        /* translators: %s: Link to Razorpay currency page */
                        echo sprintf( __( 'Razorpay does not support your store currency. Please check the supported currency list from <a href="%s" target="_blank">here</a>.', 'rzp-woocommerce' ), 'https://razorpay.com/docs/international-payments/#supported-currencies' ); ?>
	    			</p>
	    		</div>
	    		<?php
	    	}
        }
    
		/**
	     * Initialise Gateway Settings Form Fields.
	     */
 		public function init_form_fields() {

            $this->form_fields = array(
                'enabled' => array(
                    'title'       => __( 'Enable/Disable:', 'rzp-woocommerce' ),
                    'label'       => __( 'Enable Razorpay Payment Gateway', 'rzp-woocommerce' ),
                    'type'        => 'checkbox',
                    'description' => __( 'Enable Razorpay Payment Gateway for this website.', 'rzp-woocommerce' ),
                    'default'     => 'yes',
                    'desc_tip'    => true,
                ),
                'title' => array(
                    'title'       => __( 'Title:', 'rzp-woocommerce' ),
                    'type'        => 'text',
                    'description' => __( 'This controls the title which the user sees during checkout.', 'rzp-woocommerce' ),
                    'default'     => __( 'Pay with Razorpay', 'rzp-woocommerce' ),
                    'desc_tip'    => true,
                ),
                'description' => array(
                    'title'       => __( 'Description:', 'rzp-woocommerce' ),
                    'type'        => 'textarea',
                    'description' => __( 'This controls the description which the user sees during checkout.', 'rzp-woocommerce' ),
                    'desc_tip'    => true,
                    'default'     => __( 'Pay securely by Credit or Debit card or Internet Banking or UPI or QR Code or Wallets through Razorpay.', 'rzp-woocommerce' ),
                ),
                'thank_you' => array(
                    'title'       => __( 'Thank You Message:', 'rzp-woocommerce' ),
                    'type'        => 'textarea',
                    'description' => __( 'This displays a message to customer after a successful payment is made.', 'rzp-woocommerce' ),
                    'desc_tip'    => true,
                    'default'     => __( 'Thank you for shopping with us. Your account has been charged and your transaction is successful. We will be processing your order soon.', 'rzp-woocommerce' ),
                ),
                'api_details' => array(
                    'title'       => __( 'API Credentials', 'rzp-woocommerce' ),
                    'type'        => 'title',
                    'description' => '',
                ),
                'api_type' => array(
                    'title'       => __( 'Razorpay API Type:', 'rzp-woocommerce' ),
                    'type'        => 'select',
					'description' =>  __( 'Select the Razorpay API Type from here. Legacy API will be officially deprecated by Razorpay on March 31, 2021.', 'rzp-woocommerce' ),
					'desc_tip'    => true,
                    'default'     => 'legacy',
                    'options'     => array(
						'standard'  => __( 'Standard API', 'rzp-woocommerce' ),
						'legacy'  => __( 'Legacy API', 'rzp-woocommerce' )
                    )
                ),
                'key_id' => array(
                    'title'       => __( 'Live Client API Key:', 'rzp-woocommerce' ),
                    'type'        => 'text',
                    'description' => __( 'The key Id can be generated from "API Keys" section of Razorpay Dashboard. Use live key for live mode.', 'rzp-woocommerce' ),
                    'desc_tip'    => true,
                ),
                'key_secret' => array(
                    'title'       => __( 'Live Client Secret Key:', 'rzp-woocommerce' ),
                    'type'        => 'password',
                    'description' => __( 'The key secret can be generated from "API Keys" section of Razorpay Dashboard. Use live secret for live mode.', 'rzp-woocommerce' ),
                    'desc_tip'    => true,
                ),
                'testmode' => array(
                    'title'       => __( 'Test Mode:', 'rzp-woocommerce' ),
                    'label'       => __( 'Enable Test Mode', 'rzp-woocommerce' ),
                    'type'        => 'checkbox',
                    'description' => __( 'Run the Razorpay Payment Gateway in test mode.', 'rzp-woocommerce' ),
                    'default'     => 'yes',
                    'desc_tip'    => true,
                ),
                'test_key_id' => array(
                    'title'       => __( 'Test Client API Key:', 'rzp-woocommerce' ),
                    'type'        => 'text',
                    'description' => __( 'The key Id can be generated from "API Keys" section of Razorpay Dashboard. Use test key for test mode.', 'rzp-woocommerce' ),
                    'desc_tip'    => true,
                ),
                'test_key_secret' => array(
                    'title'       => __( 'Test Client Secret Key:', 'rzp-woocommerce' ),
                    'type'        => 'password',
                    'description' => __( 'The key secret can be generated from "API Keys" section of Razorpay Dashboard. Use test secret for test mode.', 'rzp-woocommerce' ),
                    'desc_tip'    => true,
                ),
                'webhook_details' => array(
                    'title'       => __( 'Razorpay Webhook', 'rzp-woocommerce' ),
                    'type'        => 'title',
                    'description' => sprintf( __( 'Webhook URL: %1$sOnly "%2$s" and "%3$s" action events are supported.' ), '<span style="color: #0073aa;">' . get_home_url() . '/wc-api/rzp-webhook/</span><br>', 'payment.authorized', 'refund.created' ),
                ),
                'webhook_enabled' => array(
                    'title'       => __( 'Razorpay Webhook:', 'rzp-woocommerce' ),
                    'label'       => __( 'Enable Razorpay Webhook', 'rzp-woocommerce' ),
                    'type'        => 'checkbox',
                    'description' => __( 'Use the above webhook URL in Razorpaay "Settings > Webhooks".', 'rzp-woocommerce' ),
                    'default'     => 'no',
                    'desc_tip'    => true,
                ),
                'webhook_secret' => array(
                    'title'       => __( 'Webhook Secret Key:', 'rzp-woocommerce' ),
                    'type'        => 'password',
                    'description' => __( 'The webhook secret can be generated from "Webhooks" section of Razorpay Dashboard.', 'rzp-woocommerce' ),
                    'desc_tip'    => true,
                ),
                'configure' => array(
                    'title'       => __( 'Razorpay Settings', 'rzp-woocommerce' ),
                    'type'        => 'title',
                    'description' => '',
                ),
                'sms_notification' => array(
                    'title'       => __( 'SMS Notification:', 'rzp-woocommerce' ),
                    'label'       => __( 'Enable/Disable', 'rzp-woocommerce' ),
                    'type'        => 'checkbox',
                    'description' => __( 'Enable this option to send payment links to your customer\'s Mobile Number as a SMS.', 'rzp-woocommerce' ),
                    'default'     => 'no',
                    'desc_tip'    => true,
                ),
                'email_notification' => array(
                    'title'       => __( 'Email Notification:', 'rzp-woocommerce' ),
                    'label'       => __( 'Enable/Disable', 'rzp-woocommerce' ),
                    'type'        => 'checkbox',
                    'description' => __( 'Enable this option to send payment links to your customer\'s Email Address as a Email.', 'rzp-woocommerce' ),
                    'default'     => 'no',
                    'desc_tip'    => true,
                ),
                'reminder' => array(
                    'title'       => __( 'Payment Reminder:', 'rzp-woocommerce' ),
                    'label'       => __( 'Enable/Disable', 'rzp-woocommerce' ),
                    'type'        => 'checkbox',
                    'description' => __( 'Enable this option to send payment reminder alerts to your customers if they do not completed their payment yet. It only works when you will enable Payment Reminder from your Razorpay Account.', 'rzp-woocommerce' ),
                    'default'     => 'no',
                    'desc_tip'    => true,
                ),
                'link_expire' => array(
                    'title'       => __( 'Payment Link Auto Expire:', 'rzp-woocommerce' ),
                    'label'       => __( 'Enable/Disable', 'rzp-woocommerce' ),
                    'type'        => 'checkbox',
                    'description' => __( 'Enable this option to auto expire payment links depending on hold stock duration. It will work only when Stock Management is enabled in WooCommerce Settings.', 'rzp-woocommerce' ),
                    'default'     => 'no',
                    'desc_tip'    => true,
                ),
                'gateway_fee' => array(
                    'title'       => __( 'Payment Gateway Fees:', 'rzp-woocommerce' ),
                    'label'       => __( 'Collect Gateway Fees from Customer', 'rzp-woocommerce' ),
                    'type'        => 'checkbox',
                    'description' => __( 'Enable this option to collect the Razorpay Gateway Fee from your customers for the payments they make. Gateway fees will be automatically excluded if a refund is made from WordPress dashboard.', 'rzp-woocommerce' ),
                    'default'     => 'no',
                    'desc_tip'    => true,
                ),
                'instant_refund' => array(
                    'title'       => __( 'Instant Refund:', 'rzp-woocommerce' ),
                    'label'       => __( 'Enable/Disable', 'rzp-woocommerce' ),
                    'type'        => 'checkbox',
                    'description' => __( 'Enable this option to refund instantly. It will only work if Instant Refund is enabled on your Razorpay account.', 'rzp-woocommerce' ),
                    'default'     => 'no',
                    'desc_tip'    => true,
                ),
                'debug_mode' => array(
                    'title'       => __( 'Debug Mode:', 'rzp-woocommerce' ),
                    'label'       => __( 'Enable/Disable', 'rzp-woocommerce' ),
                    'type'        => 'checkbox',
                    'description' => __( 'Enable this option to view the detailed communication between the Gateway API and WooCommerce in a WooCommerce log file.', 'rzp-woocommerce' ),
                    'default'     => 'no',
                    'desc_tip'    => true,
                ),
            );
 
        }
         
		/*
		 * Processing the payments
		 */
		public function process_payment( $order_id ) {
            $this->log( "Creating Razorpay Payment Link for Order ID: $order_id" );
            
            // we need it to get any order details
            $order = wc_get_order( $order_id );

            $amount = $order->get_total();
            if ( $this->gateway_fee === 'yes' ) {
                $amount = apply_filters( 'rzpwc_charge_custom_tax_amount', ( $amount / 97.64 ) * 100, $amount, $order );
            }

            /**
              * Array with parameters for API interaction
             */
            $args = array(
                'type' => 'link',
                'view_less' => 1,
                'amount' => (int) round( $amount * 100 ),
                'currency' => $this->get_wc_order_currency( $order ),
                'description' => 'Order ID: ' . $order->get_order_number(),
                $this->ref => substr( $order->get_order_key(), 0, 40 ),
                'customer' => $this->get_wc_customer_info( $order ),
                'reminder_enable' => ( $this->reminder === 'yes' ) ? true : false,
                'sms_notify' => ( $this->sms_notification === 'yes' ) ? 1 : 0,
                'email_notify' => ( $this->email_notification === 'yes' ) ? 1 : 0,
                'notes' => array_merge( $this->get_wc_customer_info( $order ), array(
                    'woocommerce_order_id' => $order_id,
 		            'woocommerce_order_number' => $order->get_order_number()
                ) ),
                'callback_url' => trailingslashit( get_home_url( null, 'wc-api/rzp-payment' ) ),
                'callback_method' => 'get',
            );

            if ( $this->api_type === 'standard' ) {
                unset( $args['type'] );
                unset( $args['view_less'] );
                unset( $args['sms_notify'] );
                unset( $args['email_notify'] );
                
                $args['notify']['sms'] = ( $this->sms_notification === 'yes' ) ? true : false;
                $args['notify']['email'] = ( $this->email_notification === 'yes' ) ? true : false;
                $args['upi_link'] = false;
            }

            $held_duration = apply_filters( 'rzpwc_payment_link_expire_duration', get_option( 'woocommerce_hold_stock_minutes' ) );
            if ( $this->link_expire === 'yes' && 'yes' === get_option( 'woocommerce_manage_stock' ) && $held_duration >= 1 ) { 
                $args['expire_by'] = time() + ( absint( $held_duration ) * 60 ); 
            } 

            $args = apply_filters( 'rzpwc_payment_init_payload', $args, $order );

            $this->log( 'Data sent for creating Payment Link: ' . wc_print_r( $args, true ) );

            // get order meta
            $pay_url = $order->get_meta( '_rzp_payment_url', true );

			do_action( 'rzpwc_after_payment_init', $order_id, $order );

            if ( empty( $pay_url ) ) {
                // make api request
                $response = $this->api_data( $this->api_mode . 's/', json_encode( $args ) );
             
                if ( is_wp_error( $response ) ) {

                    $this->log( 'Payment Link Generation Failed: ' . $response->get_error_message(), 'error' );
                        
                    // add error notice
                    wc_add_notice( __( 'Error Occured! Please change API Type form plugin settings or contact with Site Administrator to resolve this issue.', 'rzp-woocommerce' ), 'error' );
                    return;

                } else {
             
                    $body = json_decode( wp_remote_retrieve_body( $response ), true );
                    
                    $this->log( 'Response from server on creating Payment Link: ' . wc_print_r( $body, true ) );
    
                    // check the json response from Razorpay payment processor
                    if ( isset( $body['status'] ) && $body['status'] === $this->status ) {
        
                        // we received the payment init request
                        $order->update_status( apply_filters( 'rzpwc_order_status_on_payment_init', 'pending' ) );

                        // update post metas
                        update_post_meta( $order->get_id(), '_rzp_invoice_id', esc_attr( $body['id'] ) );
                        update_post_meta( $order->get_id(), '_rzp_payment_url', esc_url( $body['short_url'] ) );

                        // add some order notes
                        $order->add_order_note( __( 'Payment is Pending against this order. URL: ', 'rzp-woocommerce' ) . esc_url( $body['short_url'] ), false );
                        
                        if ( apply_filters( 'rzpwc_payment_empty_cart', false ) ) {
                            // Empty cart
                            WC()->cart->empty_cart();
                        }
                 
                        // Redirect to the the payment page
                        return array(
                            'result'   => 'success',
                            'redirect' => apply_filters( 'rzpwc_payment_init_redirect', esc_url( $body['short_url'] ), $order )
                        );
            
                    } else if ( isset( $body['error'] ) ) {

                        $this->log( __( 'Error Occured: ', 'rzp-woocommerce' ) . esc_attr( $body['error']['code'] ) . ' : ' . esc_attr( $body['error']['description'] ) );
                        
                        // add order note
                        $order->add_order_note( esc_attr( $body['error']['code'] ) . ' : ' . esc_attr( $body['error']['description'] ), false );
            
                        // add error notice
                        wc_add_notice( __( 'Connection Error Occured! Please try again.', 'rzp-woocommerce' ), 'error' );
                        return;
            
                    }
             
                }

            } else {
                // add details to log
                $this->log( 'Payment Link already exists: ' . esc_url( $pay_url ) );
                // Redirect to the the payment page
                return array(
                    'result'   => 'success',
                    'redirect' => apply_filters( 'rzpwc_payment_init_redirect', esc_url( $pay_url ) )
                );
            }
        }

        /**
	     * Can the order be refunded via Razorpay?
	     *
	     * @param  WC_Order $order Order object.
	     * @return bool
	     */
	    public function can_refund_order( $order ) {
	    	$has_api_creds = false;
    
	    	if ( $this->testmode ) {
	    		$has_api_creds = $this->get_option( 'test_key_id' ) && $this->get_option( 'test_key_secret' );
	    	} else {
	    		$has_api_creds = $this->get_option( 'key_id' ) && $this->get_option( 'key_secret' );
	    	}
    
	    	return $order && $order->get_transaction_id() && $has_api_creds;
	    }
        
        /**
	     * Process a refund if supported.
	     *
	     * @param  int    $order_id Order ID.
	     * @param  float  $amount Refund amount.
	     * @param  string $reason Refund reason.
	     * @return bool|WP_Error
	     */
        public function process_refund( $order_id, $amount = null, $reason = '' ) {
            // we need it to get any order details
            $order = wc_get_order( $order_id );

            if ( ! $this->can_refund_order( $order ) ) {
                $this->log( 'Refund can\'t be initiated. Please check your plugin settings. Order ID: ' . $order->get_id() );

                return new WP_Error( 'error', __( 'Refund can\'t be initiated. Please check your plugin settings.', 'rzp-woocommerce' ) );
            }
        
            // get order meta
            $payment_id = $order->get_transaction_id();
            $refund_ids = unserialize( $order->get_meta( '_rzp_refund_ids', true ) );
            if ( empty( $refund_ids ) ) $refund_ids = array();
            
            // build array
            $args = array();

            // amount
            if ( ! is_null( $amount ) ) {
                $args['amount'] = (int) round( $amount * 100 );
            }

            $args['speed'] = ( $this->instant_refund === 'yes' ) ? 'optimum' : 'normal';

            // add notes to array
            $args['notes']['comment'] = ! empty( $reason ) ? $reason : __( 'No reason specified!', 'rzp-woocommerce' );
            $args['notes']['woocommerce_order_id'] = $order->get_id();
            $args['notes']['woocommerce_order_number'] = $order->get_order_number();
            $args['notes']['refund_from_website'] = true;
            $args['notes']['source'] = 'woocommerce';

            $args = apply_filters( 'rzpwc_payment_refund_payload', $args, $order );

            $this->log( 'Data sent for Refund: ' . wc_print_r( $args, true ) );
        
            // make api request
            $response = $this->api_data( 'payments/' . $payment_id . '/refund', json_encode( $args ) );
    
            if ( is_wp_error( $response ) ) {
                $this->log( 'Refund Capture Failed: ' . $response->get_error_message(), 'error' );
                    
                /* translators: %s: Razorpay gateway error message */
			    $order->add_order_note( sprintf( __( 'Refund could not be captured: %s', 'rzp-woocommerce' ), $response->get_error_message() ) );
                
                return new WP_Error( 'error', $response->get_error_message() );
            } else {
                 
                $body = json_decode( wp_remote_retrieve_body( $response ), true );

                $this->log( 'Response from server on Refund: ' . wc_print_r( $body, true ) );
    
                // check the json response from Razorpay payment processor
                if ( isset( $body['entity'] ) && $body['entity'] === 'refund' ) {
                    $refund_ids[] = esc_attr( $body['id'] );
                    
                    // add order note
                    $order->add_order_note( sprintf( __( 'Amount Refunded. Rs. %1$s<br>Refund ID: %2$s<br>Reason: %3$s' ), esc_attr( round( $body['amount'] / 100 ) ), esc_attr( $body['id'] ), esc_attr( $body['notes']['comment'] ) ), false );
                    
                    // store refund id to meta
                    update_post_meta( $order->get_id(), '_rzp_refund_id', esc_attr( $body['id'] ) );
                    update_post_meta( $order->get_id(), '_rzp_refund_ids', maybe_serialize( $refund_ids ) );
                    delete_post_meta( $order->get_id(), '_rzp_payment_url' );

                    return true;
                } else if ( isset( $body['error'] ) ) {
                    // refund note
                    $this->log( __( 'Refund Error Occured: ', 'rzp-woocommerce' ) . esc_attr( $body['error']['code'] ) . ' : ' . esc_attr( $body['error']['description'] ) );
        
                    return new WP_Error( 'error', esc_attr( $body['error']['code'] ) . ' : ' . esc_attr( $body['error']['description'] ) );
                }
            }
                
            return false;
        }

        /**
	     * Process a payment capture.
	     */
        public function capture_payment() {
            // check server request method
            if ( 'GET' !== $_SERVER['REQUEST_METHOD'] ) {
                // create redirect
                wp_safe_redirect( home_url() );
                exit;
            }

            // check GET veriables
            if( ! isset( $_GET['razorpay_payment_id'], $_GET['razorpay_'.$this->api_mode.'_id'], $_GET['razorpay_'.$this->api_mode.'_'.$this->ref], $_GET['razorpay_'.$this->api_mode.'_status'], $_GET['razorpay_signature'] ) ) {
                $this->log( 'Missing the nessesary GET variables.' );
                // create redirect
                wp_safe_redirect( home_url() );
                exit;
            }

            // get wc order id
            $order_id = wc_get_order_id_by_order_key( esc_attr( $_GET['razorpay_'.$this->api_mode.'_'.$this->ref] ) );

            // generate order
            $order = wc_get_order( $order_id );

            // check if it an order
            if ( ! is_a( $order, 'WC_Order' ) ) {
                $title = __( 'Order can\'t be found against this payment. If the money deducted from your account, please contact with Site Administrator for further action. Thanks for your understanding.', 'rzp-woocommerce' );
                        
                wp_die( $title, get_bloginfo( 'name' ) );
                exit;
            }

            // load get data
            $signature_payload = esc_attr( $_GET['razorpay_'.$this->api_mode.'_id'] ) . '|' . esc_attr( $_GET['razorpay_'.$this->api_mode.'_'.$this->ref] ) . '|' . esc_attr( $_GET['razorpay_'.$this->api_mode.'_status'] ) . '|' . esc_attr( $_GET['razorpay_payment_id'] );

            $this->log( "Payload: $signature_payload" );

            // generate hash
            $expected_signature = hash_hmac( 'sha256', $signature_payload, $this->key_secret );

            $this->log( "Original Signature: " . esc_attr( $_GET['razorpay_signature'] ) );
            $this->log( "Generated Signature: $expected_signature" );

            // match signatures
            if( hash_equals( $expected_signature, esc_attr( $_GET['razorpay_signature'] ) ) ) {
                $this->log( 'Original and Generated Signature matched.' );
                
                 // check order info
                if ( $this->id === $order->get_payment_method() && $order->needs_payment() === true ) {
                    // update the payment reference
                    $order->payment_complete( esc_attr( $_GET['razorpay_payment_id'] ) );
                    
                    // reduce stock
                    wc_reduce_stock_levels( $order->get_id() );
                    
                    // add some order notes
                    $order->add_order_note( __( 'Payment is Successful against this order.<br/>Transaction ID: ', 'rzp-woocommerce' ) . esc_attr( $_GET['razorpay_payment_id'] ), false );
                
                    // remove old payment link
                    delete_post_meta( $order->get_id(), '_rzp_payment_url' );
    
                    $this->log( 'Order marked as paid successfully. Redirecting...' );
                }
            } else {
                $this->log( 'Original and Generated Signature mismatched. Transaction verfication failed!' );

                // update the order status
                $order->update_status( 'failed' );
            }
            // create redirect
            wp_safe_redirect( apply_filters( 'rzpwc_after_payment_redirect', $this->get_return_url( $order ), $order ) );
            exit;
        }

        /**
	     * Cancel payment link if supported.
	     *
	     * @param  int    $order_id Order ID.
	     */
        public function cancel_payment_link( $order_id ) {
            // we need it to get any order details
            $order = wc_get_order( $order_id );
        
            // get order meta
            $inv_id = $order->get_meta( '_rzp_invoice_id', true );
            $pay_url = $order->get_meta( '_rzp_payment_url', true );
        
            if ( 'yes' === $this->enabled && ( ( $this->id !== $order->get_payment_method() && $order->has_status( 'processing' ) ) || $order->has_status( 'cancelled' ) ) && ! empty( $pay_url ) && ! empty( $inv_id ) ) {
                // make api request
                $response = $this->api_data( $this->api_mode . 's/' . $inv_id . '/cancel' );
        
                if ( is_wp_error( $response ) ) {

                    $this->log( 'Link Cancellation Failed: ' . $response->get_error_message(), 'error' );
                        
                    /* translators: %s: Razorpay gateway error message */
				    $order->add_order_note( sprintf( __( 'Link Cancellation could not be captured: %s', 'rzp-woocommerce' ), $response->get_error_message() ) );
				    return;

                } else {
                     
                    $body = json_decode( wp_remote_retrieve_body( $response ), true );
                    
                    $this->log( 'Response from server on Link Cancellation: ' . wc_print_r( $body, true ) );
        
                    // check the json response from Razorpay payment processor
                    if ( isset( $body['status'] ) && $body['status'] === 'cancelled' ) {
                        // add order note
                        $order->add_order_note( __( 'Invoice Link Cancelled.', 'rzp-woocommerce' ), false );
                        
                        // remove old payment link
                        delete_post_meta( $order->get_id(), '_rzp_payment_url' );
                        
                    } elseif ( isset( $body['error'] ) ) {
                        $this->log( __( 'Link Cancellation falied: ', 'rzp-woocommerce' ) . esc_attr( $body['error']['code'] ) . ' : ' . esc_attr( $body['error']['description'] ) );
            
                        // add order note
                        $order->add_order_note( $body['error']['code'] . ' : ' . $body['error']['description'], false );
                    } 
                }
            }
        }

        /**
	     * Custom Razorpay order received text.
	     *
	     * @param string   $text Default text.
	     * @param WC_Order $order Order data.
	     * @return string
	     */
	    public function order_received_text( $text, $order ) {
	    	if ( 'yes' === $this->enabled && $this->id === $order->get_payment_method() && ! empty( $this->thank_you ) ) {
	    		return esc_html( $this->thank_you );
	    	}
    
	    	return $text;
        }
        
        /**
	     * Custom Razorpay checkout URL.
	     *
	     * @param string   $url Default URL.
	     * @param WC_Order $order Order data.
	     * @return string
	     */
	    public function custom_checkout_url( $url, $order ) {
            $pay_url = $order->get_meta( '_rzp_payment_url', true );
	    	if ( 'yes' === $this->enabled && $this->id === $order->get_payment_method() && ! empty( $pay_url ) && apply_filters( 'rzpwc_custom_checkout_url', false ) ) {
	    		return esc_url( $pay_url );
	    	}
    
	    	return $url;
        }

        /**
          * Process webhook payloads.
          */
        public function process_webhook() {
            // Catch php input.
            $post = file_get_contents( 'php://input' );
            $data = json_decode( $post, true );
            if ( json_last_error() !== 0 ) {
                return;
            }
        
            if ( $this->webhook_enabled === 'yes' && ! empty( $this->webhook_secret ) && ! empty( $data['event'] ) ) {
                if ( isset( $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] ) ) {
                    // generate hash
                    $expected_signature = hash_hmac( 'sha256', $post, $this->webhook_secret );
                    // check signatures
                    if ( hash_equals( $expected_signature, $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] ) ) {
                        switch ( $data['event'] ) {
                            case 'payment.authorized':
                                return $this->webhook_update_order( $data );
                            case 'refund.created':
                                return $this->webhook_refund_order( $data );
                            default:
                                return;
                        }
                    }
                }
            }

            status_header( 200 );
		    exit;
        }

        /**
          * Process order update.
          *
          * @param array  $data
          */
        private function webhook_update_order( $data ) {
            // get payloads
            $razorpayPaymentId = $data['payload']['payment']['entity']['id'];
            $razorpayStatus = $data['payload']['payment']['entity']['status'];
            $wcOrderId = $data['payload']['payment']['entity']['notes']['woocommerce_order_id'];
            $order = wc_get_order( absint( $wcOrderId ) );
            
            // check if it an order
            if ( is_a( $order, 'WC_Order' ) ) {
                if ( ! empty( $razorpayStatus ) && $razorpayStatus === 'authorized' && $order->needs_payment() === true ) {
                    // update the payment reference
                    $order->payment_complete( esc_attr( $razorpayPaymentId ) );
                    
                    // reduce stock
                    wc_reduce_stock_levels( $order->get_id() );
                            
                    // add some order notes
                    $order->add_order_note( __( 'Payment is Successful against this order.<br/>Transaction ID: ', 'rzp-woocommerce' ) . esc_attr( $razorpayPaymentId ), false );
                }
            }
        }

        /**
         * Process order refund.
         *
         * @param array  $data 
         */
        private function webhook_refund_order( $data ) {
            // get payloads
            $refundId = $data['payload']['refund']['entity']['id'];
            $razorpayPaymentId = $data['payload']['refund']['entity']['payment_id'];
            $refund_amount = (int) round( ( $data['payload']['refund']['entity']['amount'] / 100 ), 2 );
            $refund_reason = $data['payload']['refund']['entity']['notes']['comment'];

            $orderId = $data['payload']['payment']['entity']['notes']['woocommerce_order_id'];
            $order = wc_get_order( absint( $orderId ) );
            $refund_ids = unserialize( $order->get_meta( '_rzp_refund_ids', true ) );
            if ( empty( $refund_ids ) ) $refund_ids = array();

            // check if it an order
            if ( is_a( $order, 'WC_Order' ) ) {
                // If it is already marked as unpaid, ignore the event
                if ( $order->needs_payment() === false && ! $order->has_status( 'refunded' ) && ! in_array( $refundId, $refund_ids ) ) {
                    $refund_ids[] = esc_attr( $refundId );
                    
                    // create refund
                    wc_create_refund( array(
                        'amount'         => $refund_amount,
                        'reason'         => $refund_reason,
                        'order_id'       => $order->get_id(),
                        'refund_id'      => $refundId,
                        'line_items'     => array(),
                        'refund_payment' => false,
                        'restock_items'  => true
                    ) );

                    // add some order notes
                    $order->add_order_note( __( 'Order amount is refunded.<br/>Refund ID: ', 'rzp-woocommerce' ) . esc_attr( $refundId ), false );
                    
                    // store refund id to meta
                    update_post_meta( $order->get_id(), '_rzp_refund_id', esc_attr( $refundId ) );
                    update_post_meta( $order->get_id(), '_rzp_refund_ids', maybe_serialize( $refund_ids ) );
                }
            }
        
            // Graceful exit since refund is now processed.
            exit;
        }
        
        public function auto_enable_webhook() {
            $webhook_exist = false;
            $webhook_url = esc_url( get_home_url( null, '/wc-api/rzp-webhook/' ) );
            $webhook_enabled = $this->get_option( 'webhook_enabled' );
            $webhook_secret = $this->get_option( 'webhook_secret' );
            $webhook_events = array(
                'payment.authorized' => true,
                'refund.created' => true
            );

            $domain = parse_url( $webhook_url, PHP_URL_HOST );
            $domain_ip = gethostbyname( $domain );
            if ( ! filter_var( $domain_ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) ) {
                $this->update_option( 'webhook_enabled', 'no' ); ?>
                <div class="notice error is-dismissible">
                    <p><b><?php _e( 'Could not enable webhook for localhost.' ); ?></b></p>
                </div>
                <?php
                return;
            }

            if ( empty( $webhook_secret ) === true ) { ?>
                <div class="notice error is-dismissible">
                    <p><b><?php _e( 'Please enter the webhook secret.' ); ?></b></p>
                </div>
                <?php
                return;
            }

            if ( $webhook_enabled === 'no' ) {
                $data = array(
                    'url'    => $webhook_url,
                    'active' => false,
                );
            } else {
                $data = array(
                    'url'    => $webhook_url,
                    'active' => true,
                    'events' => $webhook_events,
                    'secret' => $webhook_secret,
                );
            }

            $webhook = $this->webhook_data( 'GET', 'webhooks/' );
            if ( $webhook ) {
                foreach ( $webhook['items'] as $key => $value ) {
                    if ( $value['url'] === $webhook_url ) {
                        $webhook_exist = true;
                        $webhook_id = $value['id'];
                    }
                }
            }
            
            if ( $webhook_exist ) {
                $this->webhook_data( 'PUT', 'webhooks/' . $webhook_id, json_encode( $data ) );
            } else {
                $this->webhook_data( 'POST', 'webhooks/', json_encode( $data ) );
            }
        }

        /**
	     * Alter Webhook Data using API.
	     *
         * @param string $method cURL Method
	     * @param string $url API URL
	     * @param string $data Body Data
	     */
        private function webhook_data( $method, $url, $data = null ) {
            // make api request
            $response = $this->api_data( $url, $data, $method );

            if ( is_wp_error( $response ) ) {
                $this->log( 'Webhook Action Failed: ' . $response->get_error_message(), 'error' );
                    
                return false;

            } else {
                $body = json_decode( wp_remote_retrieve_body( $response ), true );
                
                return $body;
            }
        }

        /**
	     * Interact with Razorpay API.
	     *
	     * @param string $url API URL
	     * @param string $data Body Data
         * @param string $method cURL Method
	     */
        private function api_data( $url, $data = null, $method = 'POST' ) {
            // api url
            $api_endpoint = 'https://api.razorpay.com/v1/' . $url;

            $this->log( "Key ID: $this->key_id | Key Secret: $this->key_secret" );
        
            $auth = base64_encode( $this->key_id . ':' . $this->key_secret );
            
            /*
             * Build API interaction
             */
            $response = wp_remote_request( $api_endpoint, array(
                'body' => $data,
                'method' => $method,
                'headers' => array(
                    'Content-Type'   => 'application/json',
                    'Authorization'  => "Basic $auth",
                ) )
            );

            return $response;
        }

        /**
	     * Get Cutomer Info.
	     *
 	     * @param string $order WC_Order Object
	     */
        private function get_wc_customer_info( $order ) {
            if ( version_compare( WOOCOMMERCE_VERSION, '2.7.0', '>=' ) ) {
                $args = array(
                    'name' => html_entity_decode( $order->get_formatted_billing_full_name(), ENT_QUOTES, 'UTF-8' ),
                    'email' => $order->get_billing_email(),
                    'contact' => ( $this->api_type === 'standard' ) ? '+91' . substr( $order->get_billing_phone(), -10 ) : substr( $order->get_billing_phone(), -10 )
                );
            } else {
                $args = array(
                    'name'    => $order->billing_first_name . ' ' . $order->billing_last_name,
                    'email'   => $order->billing_email,
                    'contact' => $order->billing_phone,
                );
            }

            return $args;
        }

        /**
	     * Get WC Order Key
	     *
 	     * @param WC_Order $order
         * @return string Order Key
	     */
        private function get_wc_order_key( $order ) {
            if ( version_compare( WOOCOMMERCE_VERSION, '3.0.0', '>=' ) ) {
                return $order->get_order_key();
            }

            return $order->order_key;
        }

        /**
         * @param WC_Order $order
         * @return string Currency
         */
        private function get_wc_order_currency( $order ) {
            if ( version_compare( WOOCOMMERCE_VERSION, '2.7.0', '>=' ) ) {
                return $order->get_currency();
            }

            return $order->get_order_currency();
        }
 	}
}
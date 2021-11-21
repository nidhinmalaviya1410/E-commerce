<?php 

/**
* Checkout page field manager
*/

class WooLentor_Checkout_Page{

    /**
     * [$instance]
     * @var null
     */
    private static $instance = null;

    /**
     * [$fields_billing]
     * [$fields_shipping]
     * [$fields_additional]
     * @var array
     */
    private $fields_billing     = array();
    private $fields_shipping    = array();
    private $fields_additional  = array();

    /**
     * [__construct] class constructor
     */
    function __construct(){

        $this->fields_billing     = get_option( 'woolentor_wc_fields_billing', array() );
        $this->fields_shipping    = get_option( 'woolentor_wc_fields_shipping', array() );
        $this->fields_additional  = get_option( 'woolentor_wc_fields_additional', array() );

        add_filter('woocommerce_enable_order_notes_field', [ $this, 'enable_order_notes_field' ], 9999 );

        add_filter('woocommerce_get_country_locale_default', [ $this, 'country_locale' ] );

        add_filter('woocommerce_get_country_locale_base', [ $this, 'country_locale' ] );

        add_filter('woocommerce_get_country_locale', [ $this, 'get_country_locale' ] );

        add_filter( 'woocommerce_billing_fields', [ $this, 'billing_fields' ], 9999, 2 );

        add_filter( 'woocommerce_shipping_fields', [ $this, 'shipping_fields' ], 9999, 2 );

        add_filter('woocommerce_checkout_fields', [ $this, 'checkout_fields' ] , 9999 );
        
        add_filter( 'woocommerce_default_address_fields' , [ $this, 'default_address_fields' ], 9999 );

        add_action( 'woocommerce_after_checkout_validation', [ $this, 'checkout_field_validation' ] , 10, 2 );

        add_action('woocommerce_checkout_update_order_meta', [ $this, 'checkout_update_order_meta' ], 10, 2 );

        add_filter('woocommerce_email_order_meta_fields', [ $this, 'show_custom_fields_in_email' ], 10, 3 );
        
        add_action('woocommerce_order_details_after_order_table', [ $this, 'order_details_after_order_table' ], 20, 1);
        
    }

    /**
     * [instance]
     * @return [WooLentor_Checkout_Page]
     */
    public static function instance(){
        if( is_null( self::$instance ) ){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * [country_locale Country locale Base and default]
     * @param  [array] default $fields list get from country location
     * @return [array] Modify Field list
     */
    public function country_locale( $fields ) {

        if( is_array( $fields ) ){

            if( empty( get_option( 'woolentor_wc_fields_billing' ) ) ){
               $fieldgroup = 'shipping'; 
            }else{
                $fieldgroup = 'billing';
            }

            $address_fields = get_option( 'woolentor_wc_fields_'.$fieldgroup );

            foreach( $fields as $name => $field ){

                $field_name = $fieldgroup.'_'.$name;

                $custom_field = isset( $address_fields[$field_name] ) ? $address_fields[$field_name] : false;

                if( is_array( $custom_field ) ){
                    if( $custom_field['label'] && isset( $field['label'] ) ){
                        unset( $fields[$name]['label'] );
                    }

                    if( $custom_field['placeholder'] && isset( $field['placeholder'] ) ){
                        unset( $fields[$name]['placeholder'] );
                    }

                    if( $custom_field['required'] == true && isset( $field['required'] ) ){
                        $fields[$name]['required'] = $custom_field['required'];
                    }
                    
                    if( $custom_field['priority'] && isset( $field['priority'] ) ){
                        unset( $fields[$name]['priority'] );
                    }
                }

            }
            
        }
        return $fields;
    }

    /**
     * [get_country_locale]
     * @param  [array] $locale
     * @return [array]
     */
    public function get_country_locale( $locale ) {
        if( is_array( $locale ) ){
            foreach( $locale as $country => $fields ){
                $locale[$country] = $this->country_locale($fields);
            }
        }
        return $locale;
    }

    /**
     * [enable_order_notes_field Additional Field Status]
     * @return [boolean] field status
     */
    public function enable_order_notes_field() {
        if( is_array( $this->fields_additional ) && !empty( get_option( 'woolentor_wc_fields_additional' ) ) ){
            $enabled = 0;
            if( count( $this->fields_additional ) > 0 ){
                $enabled = 1;
            }
            return ( $enabled > 0 ? true : false );
        }
        return true;
    }

    /**
     * [billing_fields hook callback function]
     * @param  [array] $fields  get WooCommerce default fields
     * @param  [string] $country get WooCommerce country prefix
     * @return [array]  field list
     */
    public function billing_fields( $fields, $country ){
        if( is_wc_endpoint_url( 'edit-address' ) ){
            return $fields;
        }else{
            return $this->manage_fields( $this->fields_billing, $fields, 'billing', $country );
        }
    }

    /**
     * [shipping_fields hook callback function]
     * @param  [array] $fields  get WooCommerce default fields
     * @param  [string] $country get WooCommerce country prefix
     * @return [array]  field list
     */
    public function shipping_fields( $fields, $country ){

        if(is_wc_endpoint_url('edit-address')){
            return $fields;
        }else{
            return $this->manage_fields( $this->fields_shipping, $fields, 'shipping', $country );
        }

    }

    /**
     * [checkout_fields fields list]
     * @param  [array] $fields default field list
     * @return [array] Field list
     */
    public function checkout_fields( $fields ) {

        $additional_fields = $this->fields_additional;

        if( is_array( $additional_fields ) && count( $additional_fields ) > 0 ){

            // Set Default Filed Type
            foreach ( $additional_fields as $key => $value ) {
                if( $key === 'additional_order_comments' ){
                    $additional_fields['additional_order_comments']['type'] = 'textarea';
                }
            }

            // Assign All field Under Order key
            if( isset( $fields['order'] ) && is_array( $fields['order'] ) ){
                $fields['order'] = $additional_fields;
            }

            // Check Default Filed Status
            if( !array_key_exists('additional_order_comments', $additional_fields) ){
                unset( $fields['order']['order_comments'] );
            }

        }
                
        if( isset( $fields['order'] ) && is_array( $fields['order'] ) ){
            $fields['order'] = $this->create_fields( $fields['order'], false );
        }

        if( isset( $fields['order'] ) && !is_array( $fields['order'] ) ){
            unset( $fields['order'] );
        }
        
        return $fields;
    }

    /**
     * [is_address_field]
     * @param  [string]  $name field key
     * @return [boolean] true|false
     */
    public function is_address_field( $name ){
        $address_fields = array(
            'billing_address_1', 
            'billing_address_2', 
            'billing_state', 
            'billing_postcode', 
            'billing_city',
            'shipping_address_1', 
            'shipping_address_2', 
            'shipping_state', 
            'shipping_postcode', 
            'shipping_city',
        );
        if( $name && in_array( $name, $address_fields ) ){
            return true;
        }
        return false;
    }

    /**
     * [default_address_fields change default address field]
     * @param  [array] $fields default field array
     * @return [array] single field array 
     */
    public function default_address_fields( $fields ) {

        $fieldgroup = 'billing';
 
        if( $fieldgroup === 'billing' || $fieldgroup === 'shipping' ){

            $address_fields = get_option( 'woolentor_wc_fields_'.$fieldgroup );;

            if( is_array( $address_fields ) && !empty( $address_fields ) && !empty( $fields ) ){

                foreach( $fields as $name => $field ) {
                    $field_name = $fieldgroup.'_'.$name;
                    
                    if( $this->is_address_field( $field_name ) ){

                        $custom_field = isset( $address_fields[$field_name] ) ? $address_fields[$field_name] : false;

                        $fields[$name]['label'] = isset( $custom_field['label'] ) ? $custom_field['label'] : '';
                        $fields[$name]['default']       = isset( $custom_field['default'] ) ? $custom_field['default'] : '';
                        $fields[$name]['placeholder']   = isset( $custom_field['placeholder'] ) ? $custom_field['placeholder'] : '';
                        $fields[$name]['class']         = isset( $custom_field['class'] ) && is_array( $custom_field['class'] ) ? $custom_field['class'] : array();

                        $fields[$name]['validate']      = isset( $custom_field['validate'] ) && is_array( $custom_field['validate'] ) ? $custom_field['validate'] : array();
                    
                        $fields[$name]['required'] = isset( $custom_field['required'] ) ? $custom_field['required'] : false;
                        $fields[$name]['priority'] = isset( $custom_field['priority'] ) ? $custom_field['priority'] : '';

                    }
                }
            }
        }
        
        return $fields;
    }

    /**
     * [manage_fields create individual field]
     * @param  [array] $ofields option field list
     * @param  [boolean] $default_fields default field group
     * @param  [string] $fieldgroup field group key
     * @param  [string] $country country prefix
     * @return [array] field list
     */
    public function manage_fields( $ofields, $default_fields = false, $fieldgroup = 'billing', $country ){

        if( is_array ( $ofields ) && !empty( $ofields ) ) {

            $locale = WC()->countries->get_country_locale();

            if( isset( $locale[ $country ] ) && is_array( $locale[ $country ] ) ) {

                foreach( $locale[ $country ] as $key => $value ){
                    
                    $fieldname = $fieldgroup.'_'.$key;
                    if( is_array( $value ) && isset( $ofields[$fieldname] ) ){
                        if( !isset( $ofields[$fieldname]['required'] ) ){
                            $ofields[$fieldname]['required'] = $value['required'];
                        }
                    }

                }

            }

            $ofields = $this->create_fields( $ofields, $default_fields );
            return $ofields;

        }else {
            return $default_fields;
        }

    }

    /**
     * [create_fields create field]
     * @param  [array] $ofields option field list
     * @param  [array] $default_fields default field list
     * @return [array] individual field
     */
    public function create_fields( $ofields, $default_fields ) {
        if( is_array( $ofields ) && !empty( $ofields ) ) {

            foreach( $ofields as $name => $field ) {

                $new_field = false;
                
                if( $default_fields && isset( $default_fields[$name] ) ){

                    $new_field = $default_fields[$name];
                    
                    $new_field['label']         = isset( $field['label'] ) ? $field['label'] : '';
                    $new_field['default']       = isset( $field['default'] ) ? $field['default'] : '';
                    $new_field['placeholder']   = isset( $field['placeholder'] ) ? $field['placeholder'] : '';
                    $new_field['class']         = isset( $field['class'] ) && is_array( $field['class'] ) ? $field['class'] : array();

                    $new_field['validate']      = isset( $field['validate'] ) && is_array( $field['validate'] ) ? $field['validate'] : array();
                    
                    $new_field['required'] = isset( $field['required'] ) ? $field['required'] : false;
                    $new_field['priority'] = isset( $field['priority'] ) ? $field['priority'] : '';

                } else {
                    $new_field = $field;
                }

                $field_type = isset( $new_field['type'] ) ? $new_field['type'] : 'text';

                $new_field['class'][] = 'woolentor-field-area';
                $new_field['class'][] = 'woolentor-field-'.$field_type;
                
                if( $field_type === 'select' || $field_type === 'radio' ){

                    if( isset( $new_field['options'] ) ){

                        $options_arr = $this->option_field( $new_field['options'] );
                        $options     = array();

                        foreach( $options_arr as $key => $value ) {

                            $options[$key] = esc_html__( $value, 'woolentor-pro' );
                        }

                        $new_field['options'] = $options;
                    }

                }

                if( isset( $new_field['label'] ) ){
                    $new_field['label'] = esc_html__( $new_field['label'], 'woolentor-pro' );
                }

                if( isset( $new_field['placeholder'] ) ){
                    $new_field['placeholder'] = esc_html__( $new_field['placeholder'], 'woolentor-pro' );
                }
                
                $ofields[$name] = $new_field;

            }  

            return $ofields;

        }else {
            return $default_fields;
        }

    }

    /**
     * [option_field option field generate]
     * @param  [string] $options
     * @return [array]   
     */
    public function option_field( $options ){
        $option_value = array();
        if( is_string( $options ) ){
            $options = array_map( 'trim', explode( "\n", $options ) );
            foreach ( $options as $value ) {
                $sepkey = explode( ',', $value );
                if( is_array( $sepkey ) ){
                    $option_value[$sepkey[0]] = ( isset( $sepkey[1] ) ? $sepkey[1] : '' );
                }
            }
        }
        return is_array( $option_value ) ? $option_value : array();
    }

    /*
    * Check out Field Validation
    */
   
   /**
    * [checkout_field_validation description]
    * @param  [array] $posted Post data
    * @param  [WC_Errors] $errors Errors instance.
    * @return [void] 
    */
    public function checkout_field_validation( $posted, $errors ){
        $checkout_fields = WC()->checkout->checkout_fields;
        
        foreach( $checkout_fields as $fieldgroup_key => $fieldgroup ){

            if( $this->skip_checkout_fieldgroup( $fieldgroup_key, $posted ) ){
                continue;
            }
            
            foreach( $fieldgroup as $key => $field ) {
                if( isset( $posted[$key] ) && !$this->is_empty_value( $posted[$key] ) ){
                    $this->custom_field_validation( $field, $posted, $errors );
                }
            }

        }

    }

    /**
     * [custom_field_validation]
     * @param  [array] $field  single field
     * @param  [array] $posted Post Data
     * @param  [boolean] $errors True | false
     * @param  ]boolean] $return True | False
     * @return [array] Array | False
     */
    public function custom_field_validation( $field, $posted, $errors = false, $return = false ){

        $err_messages = array();
        $key = ( isset( $field['name'] ) ? $field['name'] : false );

        if( $key ){
            $value = ( isset( $posted[$key] ) ? $posted[$key] : '' );
            $validators = ( isset( $field['validate'] ) ? $field['validate'] : '' );

            if( $value && is_array( $validators ) && !empty( $validators ) ){                 
                foreach( $validators as $validator ){

                    $err_message = '';
                    $flabel = ( isset( $field['label'] ) ? $field['label'] : $key );

                    if( $validator === 'number' ){
                        if( !is_numeric( $value ) ){
                            $err_message = '<strong>'. $flabel .'</strong> '. esc_html__('is not a valid number.','woolentor-pro');    
                        }
                    }

                    if( $err_message ){
                        if( $errors || !$return ){
                            $this->add_error_message( $err_message, $errors );
                        }
                        $err_messages[] = $err_message;
                    }
                }
            }
        }
        return ( !empty( $err_messages ) ? $err_messages : false );
    }

    /**
     * [is_empty_value]
     * @param  [string] $value Post data Key
     * @return [boolean] True | False
     */
    public function is_empty_value( $value ) {
        return ( empty( $value ) && !is_numeric( $value ) );
    }

    /**
     * [skip_checkout_fieldgroup]
     * @param  [string] $fieldgroup_key Checkout Feild Group
     * @param  [array] $data Post data
     * @return [boolean] True | False
     */
    public function skip_checkout_fieldgroup( $fieldgroup_key, $data ) {

        $ship_different_address = ( isset( $data['ship_to_different_address'] ) ? $data['ship_to_different_address'] : false );

        if ( $fieldgroup_key === 'shipping' && ( !$ship_different_address || !WC()->cart->needs_shipping_address() ) ) {
            return true;
        }
        return false;

    }

    /**
     * [add_error_message]
     * @param [string] $message Custom Message
     * @param [WC_Errors] $errors Errors instance. 
     */
    public function add_error_message( $message, $errors = false ){
        if( $errors ){
            $errors->add( 'validation', $message );
        }else if( version_compare( WOOCOMMERCE_VERSION, '2.3.0', '>=' ) ){
            wc_add_notice( $message, 'error' );
        } else {
            WC()->add_error( $message );
        }
    }

    /**
     * [checkout_update_order_meta]
     * @param  [int] $order_id Order Id
     * @param  [array] $posted Posted data
     * @return [void]
     */
    public function checkout_update_order_meta( $order_id, $posted ){

        $types = array( 'billing', 'shipping', 'additional' );

        foreach( $types as $type ){

            if( $this->skip_checkout_fieldgroup( $type, $posted ) ){
                continue;
            }

            $fields = $this->get_fields( $type );
            
            foreach( $fields as $name => $field ){

                if( $this->is_custom_field( $field ) && isset( $posted[$name] ) ){
                    $value = wc_clean( $posted[$name] );
                    if( $value ){
                        update_post_meta( $order_id, $name, $value );
                    }
                }

            }

        }

    }

    /**
     * [get_fields]
     * @param  [string] $key Field group Key
     * @return [array] Field List
     */
    public function get_fields( $key ){

        $fields = get_option( 'woolentor_wc_fields_'. $key, array() );

        $fields = ( is_array( $fields ) ? array_filter( $fields ) : array() );
        
        if( empty( $fields ) || sizeof( $fields ) == 0 ){

            if( $key === 'billing' || $key === 'shipping' ){

                $fields = WC()->countries->get_address_fields( WC()->countries->get_base_country(), $key . '_' );

            } else if( $key === 'additional' ){
                $fields = array(
                    'order_comments' => array(
                        'type'        => 'textarea',
                        'class'       => array('notes'),
                        'label'       => __('Order Notes', 'woolentor-pro'),
                        'placeholder' => _x('Notes about your order, e.g. special notes for delivery.', 'placeholder', 'woolentor-pro')
                    )
                );
            }

            $fields = $this->default_checkout_fields( $fields );
        }
        return $fields;
    }

    /**
     * [default_checkout_fields]
     * @param  [array] $fields Field list
     * @return [array] Field List
     */
    public function default_checkout_fields( $fields ){
        foreach ( $fields as $key => $value ) {
            $fields[$key]['custom'] = true;
            $fields[$key]['show_in_email'] = true;
            $fields[$key]['show_in_order'] = true;
        }
        return $fields;
    }

    /**
     * [is_custom_field]
     * @param  [array] $field single field information
     * @return [boolean] True | False
     */
    public function is_custom_field( $field ){
        $status = false;
        if( is_array( $field ) ){
            if( isset( $field['custom'] ) && $field['custom'] === true ){
                $status = true;
            }
        }
        return $status;
    }

    /**
     * [get_checkout_fields Get all checkout Field]
     * @param  [WC_Order] $order Order instance.
     * @return [array] Field List
     */
    public function get_checkout_fields( $order = false ){
        $fields = array();
        $needs_shipping = true;

        if( $order ){
            $needs_shipping = !wc_ship_to_billing_address_only() && $order->needs_shipping_address() ? true : false;
        }
        
        if( $needs_shipping ){
            $fields = array_merge( $this->get_fields('billing'), $this->get_fields('shipping'), $this->get_fields('additional') );
        }else{
            $fields = array_merge( $this->get_fields('billing'), $this->get_fields('additional') );
        }
        return $fields;
    }

    /**
     * [get_order_id]
     * @param  [WC_Order] $order Order instance.
     * @return [int] Order Id
     */
    public function get_order_id($order){
        $order_id = false;
        if( version_compare( WOOCOMMERCE_VERSION, '2.3.0', '>=' ) ){
            $order_id = $order->get_id();
        }else{
            $order_id = $order->id;
        }
        return $order_id;
    }

    /**
     * [get_option_value]
     * @param  [array] $field Field List
     * @param  [string] $value
     * @return [string] option field value
     */
    public function get_option_value( $field, $value ){
        $type = isset( $field['type'] ) ? $field['type'] : false;
        if( $type === 'select' || $type === 'radio' ){
            $options = isset( $field['options'] ) ? $field['options'] : array();
            $options = array_map( 'trim', explode( "\n", $options ) );
            if( is_array( $options ) ){
                $pickvalue = explode( ',', $options[$value-1] );
                $value = ( isset( $pickvalue[1] ) ? $pickvalue[1] : '' );
            }
        }
        return $value;
    }

    /**
     * [show_custom_fields_in_email]
     * @param  [array] $ofields [description]
     * @param  [boolean] $sent_to_admin If should sent to admin.
     * @param  [WC_Order] $order Order instance.
     * @return [array] Field list
     */
    public function show_custom_fields_in_email( $ofields, $sent_to_admin, $order ){
        
        $custom_fields = array();
        $fields = $this->get_checkout_fields();

        foreach( $fields as $key => $field ) {

            if( isset( $field['show_in_email'] ) && $field['show_in_email'] ){

                $order_id   = $this->get_order_id($order);
                $value      = get_post_meta( $order_id, $key, true );
                
                if( $value ){
                    $label = isset( $field['label'] ) && $field['label'] ? $field['label'] : $key;
                    $label = esc_attr( $label );
                    $value = $this->get_option_value( $field, $value );
                    
                    $custom_field = array();
                    $custom_field['label'] = $label;
                    $custom_field['value'] = $value;

                    $custom_fields[$key] = $custom_field;
                }

            }

        }

        return array_merge( $ofields, $custom_fields );
    }

    /**
     * [order_details_after_order_table]
     * @param  [WC_Order] $order Order instance.
     * @return [void] 
     */
    public function order_details_after_order_table( $order ){

        $order_id   = $this->get_order_id( $order );
        $fields     = $this->get_checkout_fields( $order );

        if( is_array( $fields ) && !empty( $fields ) ){

            $output_data = '';

            foreach( $fields as $key => $field ){     

                if( $this->is_custom_field( $field ) && isset( $field['show_in_order'] ) && $field['show_in_order'] ){

                    $value = get_post_meta( $order_id, $key, true );
                    
                    if( $value ){

                        $label = ( isset( $field['label'] ) && $field['label'] ? $field['label'] : $key );

                        $label = esc_attr( $label );

                        $value = $this->get_option_value( $field, $value );
                        
                        if( is_account_page() ){
                            if( apply_filters( 'woolentor_view_order_customer_details_table_view', true ) ){
                                $output_data .= '<tr><th>'. $label .':</th><td>'. $value .'</td></tr>';
                            }else{
                                $output_data .= '<br/><dt>'. $label .':</dt><dd>'. $value .'</dd>';
                            }
                        }else{
                            if( apply_filters( 'woolentor_thankyou_customer_details_table_view', true )){
                                $output_data .= '<tr><th>'. $label .':</th><td>'. $value .'</td></tr>';
                            }else{
                                $output_data .= '<br/><dt>'. $label .':</dt><dd>'. $value .'</dd>';
                            }
                        }
                    }
                }
            }
            
            if( $output_data ){
                do_action( 'woolentor_order_details_before_custom_fields_table', $order ); 
                ?>
                    <table class="woocommerce-table woocommerce-table--custom-fields shop_table custom-fields">
                        <?php echo $output_data; ?>
                    </table>
                <?php
                do_action( 'woolentor_order_details_after_custom_fields_table', $order ); 
            }

        }
    }

}

if( woolentor_get_option_pro( 'multi_step_checkout', 'woolentor_others_tabs', 'off' ) != 'on' ){
    WooLentor_Checkout_Page::instance();
}
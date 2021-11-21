<?php
/**
* Class Sale Notification
*/
class Woolentor_Sale_Notification{

    private static $_instance = null;
    public static function instance(){
        if( is_null( self::$_instance ) ){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    function __construct(){
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'woolentor_inline_styles' ] );
        add_action( 'wp_footer', [ $this, 'woolentor_ajax_request' ] );
    }

    public function enqueue_scripts(){
        wp_enqueue_style( 'woolentor-widgets-pro' );
        wp_enqueue_style( 'woolentor-animate' );
        wp_enqueue_script( 'woolentor-main' );
        wp_localize_script( 'woolentor-main', 'porduct_fake_data', $this->woolentor_fakes_notification_data() );
    }

    public function woolentor_fakes_notification_data(){
        $notification = array();
        foreach( woolentor_get_option_pro( 'noification_fake_data','woolentor_sales_notification_tabs', '' ) as $key => $fakedata ) 
        {
            $nc = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $fakedata );
            array_push( $notification, $nc );
        }
        return $notification;
    }

    // Inline CSS
    function woolentor_inline_styles() {
        $crosscolor = woolentor_get_option_pro( 'cross_color','woolentor_sales_notification_tabs', '#000000' );
        $custom_css = "
            .wlcross{
                color: {$crosscolor} !important;
            }";
        wp_add_inline_style( 'woolentor-widgets-pro', $custom_css );
    }

    // Ajax request
    function woolentor_ajax_request() {

        $intervaltime  = (int)woolentor_get_option_pro( 'notification_time_int','woolentor_sales_notification_tabs', '4' )*1000;
        $duration      = (int)woolentor_get_option_pro( 'notification_loadduration','woolentor_sales_notification_tabs', '3' )*1000;
        $inanimation   = woolentor_get_option_pro( 'notification_inanimation','woolentor_sales_notification_tabs', 'fadeInLeft' );
        $outanimation  = woolentor_get_option_pro( 'notification_outanimation','woolentor_sales_notification_tabs', 'fadeOutRight' );
        $notposition  = woolentor_get_option_pro( 'notification_pos','woolentor_sales_notification_tabs', 'bottomleft' );

       
        ?>
            <script>
                ;jQuery( document ).ready( function( $ ) {

                    var notposition = '<?php echo $notposition; ?>';

                    $('body').append('<div class="woolentor-sale-notification"><div class="notifake woolentor-notification-content '+notposition+'"></div></div>');

                    var intervaltime = <?php echo $intervaltime; ?>,
                        i = 0,
                        duration = <?php echo $duration; ?>,
                        inanimation = '<?php echo $inanimation; ?>',
                        outanimation = '<?php echo $outanimation; ?>';

                    window.setTimeout( function(){
                        setInterval(function() {
                            if( i == porduct_fake_data.length ){ i = 0; }
                            $('.woolentor-notification-content').html('');
                            var ordercontent = `${ porduct_fake_data[i] }<span class="wlcross">&times;</span>`;
                            $('.woolentor-notification-content').append( ordercontent ).addClass('animated '+inanimation).removeClass(outanimation);
                            setTimeout(function() {
                                $('.woolentor-notification-content').removeClass(inanimation).addClass(outanimation);
                            }, intervaltime-500 );
                            i++;
                        }, intervaltime );
                    }, duration );

                    // Close Button
                    $('.woolentor-notification-content').on('click', '.wlcross', function(e){
                        e.preventDefault()
                        $(this).closest('.woolentor-notification-content').removeClass(inanimation).addClass(outanimation);
                    });

                });
            </script>
        <?php 
    }



}

Woolentor_Sale_Notification::instance();
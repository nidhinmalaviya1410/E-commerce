<?php
    class WooLentor_MyAccount{

    private $itemsorder = [];
    private $itemsurl   = [];

    public function __construct( $menuorders = array(), $item_url = array(), $userinfo = 'no' ) {
        $this->itemsorder   = $menuorders;
        $this->itemsurl     = $item_url;
        if( $userinfo == 'yes' ){
            add_action( 'woocommerce_before_account_navigation', [ $this, 'navigation_user' ] );
        }
        add_filter( 'woocommerce_account_menu_items',[ $this, 'navigation_items' ], 15 );
        add_filter( 'woocommerce_get_endpoint_url', [ $this, 'navigation_endpoint_url' ], 15, 4 );
    }

    // My account navigation Item
    public function navigation_items( $items ){
        $items = array();
        foreach ( $this->itemsorder as $key => $item ) {
            $items[$key] = $item;
        }
        return $items;
    }

    // My account navigation URL
    public function navigation_endpoint_url( $url, $endpoint, $value, $permalink ){
        foreach ( $this->itemsurl as $key => $value ) {
            if ( $key === $endpoint ) {
                $url = $value;
            }
        }
        return $url;
    }

    // My Account User Info
    public function navigation_user(){
        $current_user = wp_get_current_user();
        if ( $current_user->display_name ) {
            $name = $current_user->display_name;
        } else {
            $name = esc_html__( 'Welcome!', 'woolentor-pro' );
        }
        $name = apply_filters( 'woolentor_profile_name', $name );
        ?>
            <div class="woolentor-user-area">
                <div class="woolentor-user-image">
                    <?php echo get_avatar( $current_user->user_email, 125 ); ?>
                </div>
                <div class="woolentor-user-info">
                    <span class="woolentor-username"><?php echo esc_attr( $name ); ?></span>
                    <span class="woolentor-logout"><a href="<?php echo esc_url( wp_logout_url( get_permalink() ) ); ?>"><?php echo esc_html__( 'Logout', 'woolentor-pro' ); ?></a></span>
                </div>
            </div>
        <?php

    }
    

}
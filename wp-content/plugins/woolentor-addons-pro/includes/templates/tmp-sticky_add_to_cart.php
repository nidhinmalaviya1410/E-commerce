<div class="woolentor-add-to-cart-sticky">
    <div class="ht-container">

        <div class="ht-row">
            <div class="ht-col-lg-6 ht-col-md-6 ht-col-sm-6 ht-col-xs-12">
                <div class="woolentor-addtocart-content">
                    <div class="woolentor-sticky-thumbnail">
                        <?php echo woocommerce_get_product_thumbnail(); ?>  
                    </div>
                    <div class="woolentor-sticky-product-info">
                        <h4 class="title"><?php the_title(); ?></h4>
                        <span class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>     
                    </div>
                </div>
            </div>
            <div class="ht-col-lg-6 ht-col-md-6 ht-col-sm-6 ht-col-xs-12">
                <div class="woolentor-sticky-btn-area">
                    <?php 
                        if ( $product->is_type( 'simple' ) ){ 
                            woocommerce_simple_add_to_cart();
                        }else{
                            echo '<a href="'.esc_url( $product->add_to_cart_url() ).'" class="woolentor-sticky-add-to-cart button alt">'.( true == $product->is_type( 'variable' ) ? esc_html__( 'Select Options', 'woolentor' ) : $product->single_add_to_cart_text() ).'</a>';
                        }

                        if ( class_exists( 'YITH_WCWL' ) ) {
                            echo '<div class="woolentor-sticky-wishlist">'.woolentor_add_to_wishlist_button().'</div>';
                        }
                        if( class_exists('TInvWL_Public_AddToWishlist') ){
                            echo '<div class="woolentor-sticky-wishlist">';
                                \TInvWL_Public_AddToWishlist::instance()->htmloutput();
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>
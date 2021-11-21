<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

    $product = wc_get_product( get_the_ID() );

    $settings = $args;
    $tabuniqid = $args['tabuniqid'];

    // Stock Progress Bar data
    $order_text     = $settings['order_custom_text'] ? $settings['order_custom_text'] : esc_html__('Ordered:','woolentor-pro');
    $available_text = $settings['available_custom_text'] ? $settings['available_custom_text'] : esc_html__( 'Items available:','woolentor-pro' );


    // Calculate Column
    $collumval = 'ht-product product mb-30 wl-col-3';
    if( $column !='' ){
        $collumval = 'ht-product product mb-30 wl-col-'.$args['column'];
    }

    // Action Button Style
    if( $settings['action_button_style'] == 2 ){
        $collumval .= ' ht-product-action-style-2';
    }elseif( $settings['action_button_style'] == 3 ){
        $collumval .= ' ht-product-action-style-2 ht-product-action-round';
    }else{
        $collumval = $collumval;
    }

    // Position Action Button
    if( $settings['action_button_position'] == 'right' ){
        $collumval .= ' ht-product-action-right';
    }elseif( $settings['action_button_position'] == 'bottom' ){
        $collumval .= ' ht-product-action-bottom';
    }elseif( $settings['action_button_position'] == 'middle' ){
        $collumval .= ' ht-product-action-middle';
    }elseif( $settings['action_button_position'] == 'contentbottom' ){
        $collumval .= ' ht-product-action-bottom-content';
    }else{
        $collumval = $collumval;
    }

    // Show Action
    if( $settings['action_button_show_on'] == 'hover' ){
        $collumval .= ' ht-product-action-on-hover';
    }

    // Content Style
    if( $settings['product_content_style'] == 2 ){
        $collumval .= ' ht-product-category-right-bottom';
    }elseif( $settings['product_content_style'] == 3 ){
        $collumval .= ' ht-product-ratting-top-right';
    }elseif( $settings['product_content_style'] == 4 ){
        $collumval .= ' ht-product-content-allcenter';
    }else{
        $collumval = $collumval;
    }

    // Position countdown
    if( $settings['product_countdown_position'] == 'left' ){
        $collumval .= ' ht-product-countdown-left';
    }elseif( $settings['product_countdown_position'] == 'right' ){
        $collumval .= ' ht-product-countdown-right';
    }elseif( $settings['product_countdown_position'] == 'middle' ){
        $collumval .= ' ht-product-countdown-middle';
    }elseif( $settings['product_countdown_position'] == 'bottom' ){
        $collumval .= ' ht-product-countdown-bottom';
    }elseif( $settings['product_countdown_position'] == 'contentbottom' ){
        $collumval .= ' ht-product-countdown-content-bottom';
    }else{
        $collumval = $collumval;
    }

    // Countdown Gutter 
    if( $settings['show_countdown_gutter'] != 'yes' ){
       $collumval .= ' ht-product-countdown-fill'; 
    }

    // Countdown Custom Label
    if( $settings['show_countdown'] == 'yes' ){
        $data_customlavel = [];
        $data_customlavel['daytxt'] = ! empty( $settings['customlabel_days'] ) ? $settings['customlabel_days'] : 'Days';
        $data_customlavel['hourtxt'] = ! empty( $settings['customlabel_hours'] ) ? $settings['customlabel_hours'] : 'Hours';
        $data_customlavel['minutestxt'] = ! empty( $settings['customlabel_minutes'] ) ? $settings['customlabel_minutes'] : 'Min';
        $data_customlavel['secondstxt'] = ! empty( $settings['customlabel_seconds'] ) ? $settings['customlabel_seconds'] : 'Sec';
    }

    // Sale Schedule
    $offer_start_date_timestamp = get_post_meta( get_the_ID(), '_sale_price_dates_from', true );
    $offer_start_date = $offer_start_date_timestamp ? date_i18n( 'Y/m/d', $offer_start_date_timestamp ) : '';
    $offer_end_date_timestamp = get_post_meta( get_the_ID(), '_sale_price_dates_to', true );
    $offer_end_date = $offer_end_date_timestamp ? date_i18n( 'Y/m/d', $offer_end_date_timestamp ) : '';

    // Gallery Image
    $gallery_images_ids = $product->get_gallery_image_ids() ? $product->get_gallery_image_ids() : array();
    if ( has_post_thumbnail() ){
        array_unshift( $gallery_images_ids, $product->get_image_id() );
    }

    // Thumbanail Image size
    $image_size = 'woocommerce_thumbnail';
    $size = $settings['thumbnailsize_size'];
    if( $size === 'custom' ){
        $image_size = [
            (int)$settings['thumbnailsize_custom_dimension']['width'],
            (int)$settings['thumbnailsize_custom_dimension']['height']
        ];
    }else{
        $image_size = $size;
    }

?>

<!--Product Grid View Start-->
<div class="wlshop-grid-area <?php echo $collumval; ?>">
    <div class="ht-product-inner">

        <div class="ht-product-image-wrap">
            <?php
                if( class_exists('WooCommerce') ){ 
                    woolentor_custom_product_badge(); 
                    Woolentor_Control_Sale_Badge( $args, get_the_ID() );
                }
            ?>
            <div class="ht-product-image">
                <?php  if( $settings['thumbnails_style'] == 2 && $gallery_images_ids ): ?>
                    <div class="ht-product-image-slider ht-product-image-thumbnaisl-<?php echo $tabuniqid; ?>" data-slick='{"rtl":<?php if( is_rtl() ){ echo 'true'; }else{ echo 'false'; } ?> }'>
                        <?php
                            foreach ( $gallery_images_ids as $gallery_attachment_id ) {
                                echo '<a href="'.esc_url( get_the_permalink() ).'" class="item">'.wp_get_attachment_image( $gallery_attachment_id, $image_size ).'</a>';
                            }
                        ?>
                    </div>

                <?php elseif( $settings['thumbnails_style'] == 3 && $gallery_images_ids ) : $tabactive = ''; ?>
                    <div class="ht-product-cus-tab">
                        <?php
                            $i = 0;
                            foreach ( $gallery_images_ids as $gallery_attachment_id ) {
                                $i++;
                                if( $i == 1 ){ $tabactive = 'htactive'; }else{ $tabactive = ' '; }
                                echo '<div class="ht-product-cus-tab-pane '.$tabactive.'" id="image-'.$i.get_the_ID().'"><a href="'.esc_url( get_the_permalink() ).'">'.wp_get_attachment_image( $gallery_attachment_id, $image_size ).'</a></div>';
                            }
                        ?>
                    </div>
                    <ul class="ht-product-cus-tab-links">
                        <?php
                            $j = 0;
                            foreach ( $gallery_images_ids as $gallery_attachment_id ) {
                                $j++;
                                if( $j == 1 ){ $tabactive = 'htactive'; }else{ $tabactive = ' '; }
                                echo '<li><a href="#image-'.$j.get_the_ID().'" class="'.$tabactive.'">'.wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_gallery_thumbnail' ).'</a></li>';
                            }
                        ?>
                    </ul>

                <?php else: ?>
                    <a href="<?php the_permalink();?>"> 
                        <?php echo $product->get_image( $image_size ); ?>
                    </a>
                <?php endif; ?>
            </div>

            <?php if( $settings['show_countdown'] == 'yes' && $settings['product_countdown_position'] != 'contentbottom' && $offer_end_date != '' ):

                if( $offer_start_date_timestamp && $offer_end_date_timestamp && current_time( 'timestamp' ) > $offer_start_date_timestamp && current_time( 'timestamp' ) < $offer_end_date_timestamp
                ): 
            ?>
                <div class="ht-product-countdown-wrap">
                    <div class="ht-product-countdown" data-countdown="<?php echo esc_attr( $offer_end_date ); ?>" data-customlavel='<?php echo wp_json_encode( $data_customlavel ) ?>'></div>
                </div>
            <?php endif; endif; ?>

            <?php if( $settings['show_action_button'] == 'yes' ){ if( $settings['action_button_position'] != 'contentbottom' ): ?>
                <div class="ht-product-action">
                    <ul>
                        <?php if( $settings['show_quickview_button']!='yes'): ?>
                        <li>
                            <a href="javascript:void(0);" class="woolentorquickview" data-quick-id="<?php the_ID();?>" >
                                <i class="sli sli-magnifier"></i>
                                <span class="ht-product-action-tooltip"><?php esc_html_e('Quick View','woolentor'); ?></span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if( $settings['show_wishlist_button']!='yes'): ?>
                        <?php
                            if( true === woolentor_has_wishlist_plugin() ){
                                echo '<li>'.woolentor_add_to_wishlist_button('<i class="sli sli-heart"></i>','<i class="sli sli-heart"></i>', 'yes').'</li>';
                            }
                        ?>
                        <?php endif; ?>
                        <?php if( $settings['show_compare_button']!='yes'): ?>
                        <?php
                            if( function_exists('woolentor_compare_button') && true === woolentor_exist_compare_plugin() ){
                                echo '<li>';
                                    woolentor_compare_button(
                                        array(
                                            'style'=>2,
                                            'btn_text'=>'<i class="sli sli-refresh"></i>',
                                            'btn_added_txt'=>'<i class="sli sli-check"></i>'
                                        )
                                    );
                                echo '</li>';
                            }
                        ?>
                        <?php endif; ?>
                        <?php if( $settings['show_addtocart_button']!='yes'): ?>
                        <li class="woolentor-cart"><?php woocommerce_template_loop_add_to_cart(); ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; } ?>

        </div>

        <div class="ht-product-content">
            <div class="ht-product-content-inner">
                <div class="ht-product-categories"><?php woolentor_get_product_category_list(); ?></div>
                <h4 class="ht-product-title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), $settings['title_length'], '' ); ?></a></h4>
                <div class="ht-product-price"><?php woocommerce_template_loop_price();?></div>
                <div class="ht-product-ratting-wrap"><?php echo woolentor_wc_get_rating_html(); ?></div>

                <?php  
                    if( $settings['hide_product_gird_content']=='yes' ){
                        echo "<div class='woocommerce-product-details__short-description'><p>". wp_trim_words( get_the_excerpt(), $settings['woolentor_product_grid_desription_count'],'')."</p></div>";
                    }
                ?>

                <?php if( $settings['show_action_button'] == 'yes' ){ if( $settings['action_button_position'] == 'contentbottom' ): ?>
                    <div class="ht-product-action">
                        <ul>
                            <?php if( $settings['show_quickview_button']!='yes'): ?>
                            <li>
                                <a href="javascript:void(0);" class="woolentorquickview" data-quick-id="<?php the_ID();?>" >
                                    <i class="sli sli-magnifier"></i>
                                    <span class="ht-product-action-tooltip"><?php esc_html_e('Quick View','woolentor'); ?></span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if( $settings['show_wishlist_button']!='yes'): ?>
                            <?php
                                if( true === woolentor_has_wishlist_plugin() ){
                                    echo '<li>'.woolentor_add_to_wishlist_button('<i class="sli sli-heart"></i>','<i class="sli sli-heart"></i>', 'yes').'</li>';
                                }
                            ?>
                            <?php endif; ?>
                            <?php if( $settings['show_compare_button']!='yes'): ?>
                            <?php
                                if( function_exists('woolentor_compare_button') && true === woolentor_exist_compare_plugin() ){
                                    echo '<li>';
                                        woolentor_compare_button(
                                            array(
                                                'style'=>2,
                                                'btn_text'=>'<i class="sli sli-refresh"></i>',
                                                'btn_added_txt'=>'<i class="sli sli-check"></i>'
                                            )
                                        );
                                    echo '</li>';
                                }
                            ?>
                            <?php endif; ?>
                            <?php if( $settings['show_addtocart_button']!='yes'): ?>
                            <li class="woolentor-cart"><?php woocommerce_template_loop_add_to_cart(); ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; } ?>

                <?php
                    if( $settings['stock_progress_bar'] == 'yes'){
                        woolentor_stock_status_pro( $order_text, $available_text, get_the_ID() );
                    }
                ?>
            </div>
            <?php 
                if( $settings['show_countdown'] == 'yes' && $settings['product_countdown_position'] == 'contentbottom' && $offer_end_date != ''  ):

                    if( $offer_start_date_timestamp && $offer_end_date_timestamp && current_time( 'timestamp' ) > $offer_start_date_timestamp && current_time( 'timestamp' ) < $offer_end_date_timestamp
                    ):
            ?>
                <div class="ht-product-countdown-wrap">
                    <div class="ht-product-countdown" data-countdown="<?php echo esc_attr( $offer_end_date ); ?>" data-customlavel='<?php echo wp_json_encode( $data_customlavel ) ?>'></div>
                </div>
            <?php endif; endif; ?>
        </div>

    </div>
</div>
<!--Product Grid View End-->


<!--Product List View Start-->
<div class="ht-col-xs-12 wlshop-list-area">
    <div class="wlshop-list-wrap">
        <div class="ht-row">
            
            <div class="ht-col-md-4 ht-col-sm-4 ht-col-xs-12 ht-product">
                <div class="wlproduct-list-img">
                    <div class="ht-product-inner">

                        <div class="ht-product-image-wrap">
                            <?php
                                if( class_exists('WooCommerce') ){ 
                                    woolentor_custom_product_badge(); 
                                    Woolentor_Control_Sale_Badge( $args, get_the_ID() );
                                }
                            ?>
                            <div class="ht-product-image">
                                <?php  if( $settings['thumbnails_style'] == 2 && $gallery_images_ids ): ?>
                                    <div class="ht-product-image-slider ht-product-image-thumbnaisl-<?php echo $tabuniqid; ?>" data-slick='{"rtl":<?php if( is_rtl() ){ echo 'true'; }else{ echo 'false'; } ?> }'>
                                        <?php
                                            foreach ( $gallery_images_ids as $gallery_attachment_id ) {
                                                echo '<a href="'.esc_url( get_the_permalink() ).'" class="item">'.wp_get_attachment_image( $gallery_attachment_id, $image_size ).'</a>';
                                            }
                                        ?>
                                    </div>

                                <?php elseif( $settings['thumbnails_style'] == 3 && $gallery_images_ids ) : $tabactive = ''; ?>
                                    <div class="ht-product-cus-tab">
                                        <?php
                                            $i = 0;
                                            foreach ( $gallery_images_ids as $gallery_attachment_id ) {
                                                $i++;
                                                if( $i == 1 ){ $tabactive = 'htactive'; }else{ $tabactive = ' '; }
                                                echo '<div class="ht-product-cus-tab-pane '.$tabactive.'" id="image-'.$i.get_the_ID().'"><a href="'.esc_url( get_the_permalink() ).'">'.wp_get_attachment_image( $gallery_attachment_id, $image_size ).'</a></div>';
                                            }
                                        ?>
                                    </div>
                                    <ul class="ht-product-cus-tab-links">
                                        <?php
                                            $j = 0;
                                            foreach ( $gallery_images_ids as $gallery_attachment_id ) {
                                                $j++;
                                                if( $j == 1 ){ $tabactive = 'htactive'; }else{ $tabactive = ' '; }
                                                echo '<li><a href="#image-'.$j.get_the_ID().'" class="'.$tabactive.'">'.wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_gallery_thumbnail' ).'</a></li>';
                                            }
                                        ?>
                                    </ul>

                                <?php else: ?>
                                    <a href="<?php the_permalink();?>"> 
                                        <?php echo $product->get_image( $image_size ); ?>
                                    </a>
                                <?php endif; ?>

                            </div>

                            <?php if( $settings['show_countdown'] == 'yes' && $settings['product_countdown_position'] != 'contentbottom' && $offer_end_date != '' ):

                                if( $offer_start_date_timestamp && $offer_end_date_timestamp && current_time( 'timestamp' ) > $offer_start_date_timestamp && current_time( 'timestamp' ) < $offer_end_date_timestamp
                                ): 
                            ?>
                                <div class="ht-product-countdown-wrap">
                                    <div class="ht-product-countdown" data-countdown="<?php echo esc_attr( $offer_end_date ); ?>" data-customlavel='<?php echo wp_json_encode( $data_customlavel ) ?>'></div>
                                </div>
                            <?php endif; endif; ?>

                            <div class="product-quickview">
                                <a href="javascript:void(0);" class="woolentorquickview" data-quick-id="<?php the_ID();?>" >
                                    <i class="sli sli-magnifier-add"></i>
                                </a>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="ht-col-md-8 ht-col-sm-8 ht-col-xs-12">
                <div class="wlshop-list-content">
                    <h3>
                        <a href="<?php the_permalink();?>"><?php echo wp_trim_words( get_the_title(), $settings['title_length'], '' ); ?></a>
                    </h3>

                    <?php  
                        echo "<div class='woocommerce-product-details__short-description'><p>".wp_trim_words(get_the_excerpt(), $settings['woolentor_list_desription_count'],'')."</p></div>";
                    ?>
                    <div class="ht-product-categories">
                        <?php woolentor_get_product_category_list(); ?>
                    </div>

                    <div class="wlshop-list-price-action-wrap">
                        <div class="wlshop-list-price-ratting">
                            <div class="ht-product-list-price">
                                <?php woocommerce_template_loop_price(); ?>
                            </div>
                            <div class="ht-product-list-ratting">
                                <div class="ht-product-ratting-wrap">
                                    <?php woocommerce_template_loop_rating();?>
                                </div>
                            </div>
                        </div>
                        <div class="ht-product-list-action">
                            <ul>
                                <li class="cart-list">
                                    <?php woocommerce_template_loop_add_to_cart(); ?>
                                </li>
                                <li>
                                    <?php
                                        if( true === woolentor_has_wishlist_plugin() ){
                                            echo '<li>'.woolentor_add_to_wishlist_button('<i class="sli sli-heart"></i>','<i class="sli sli-heart"></i>', 'no').'</li>';
                                        }
                                    ?>
                                </li>
                                <li>
                                <?php
                                    if( function_exists('woolentor_compare_button') && true === woolentor_exist_compare_plugin() ){
                                        woolentor_compare_button(
                                            array(
                                                'btn_text'=>'<i class="sli sli-refresh"></i>',
                                                'btn_added_txt'=>'<i class="sli sli-check"></i>'
                                            )
                                        );
                                    }
                                ?>
                                </li>
                            </ul>
                        </div>

                    </div>

                    <?php
                        if( $settings['stock_progress_bar'] == 'yes'){
                            woolentor_stock_status_pro( $order_text, $available_text, get_the_ID() );
                        }
                    ?>

                </div>
            </div>

        </div>
    </div>
</div>
<!--Product List View End-->
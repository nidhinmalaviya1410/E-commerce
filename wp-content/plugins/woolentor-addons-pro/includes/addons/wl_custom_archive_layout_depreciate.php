<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Woolentor_Custom_Product_Archive_Layout_Widget extends Widget_Base {

    public function get_name() {
        return 'woolentor-custom-product-archive';
    }
    
    public function get_title() {
        return __( 'WL: Product Archive Layout (Custom)', 'woolentor-pro' );
    }

    public function get_icon() {
        return 'eicon-products';
    }
    
    public function get_categories() {
        return [ 'woolentor-addons-pro' ];
    }

    public function get_style_depends(){
        return ['elementor-icons-shared-0-css','elementor-icons-fa-brands','elementor-icons-fa-regular','elementor-icons-fa-solid','woolentor-widgets-pro'];
    }

    public function get_script_depends() {
        return [
            'slick',
            'countdown-min',
            'woolentor-widgets-scripts',
            'woolentor-widgets-scripts-pro',
        ];
    }

    public function get_keywords(){
        return ['shop page','product page','custom product page','custom shop page','custom layout'];
    }

    protected function _register_controls() {

        // Product Content
        $this->start_controls_section(
            'woolentor-products-layout-setting',
            [
                'label' => __( 'Layout Settings', 'woolentor-pro' ),
            ]
        );

            $this->add_control(
                'woolentor_product_view_mode',
                [
                    'label' => __( 'View Mode', 'woolentor-pro' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'grid',
                    'options' => [
                        'grid' => __( 'Grid', 'woolentor-pro' ),
                        'list' => __( 'List', 'woolentor-pro' ),
                    ],

                ]
            );

            $this->add_control(
                'woolentor_product_grid_column',
                [
                    'label' => __( 'Columns', 'woolentor-pro' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '3',
                    'options' => [
                        '1' => __( '1', 'woolentor-pro' ),
                        '2' => __( '2', 'woolentor-pro' ),
                        '3' => __( '3', 'woolentor-pro' ),
                        '4' => __( '4', 'woolentor-pro' ),
                        '5' => __( '5', 'woolentor-pro' ),
                        '6' => __( '6', 'woolentor-pro' ),
                    ],

                ]
            );

            $this->add_control(
                'woolentor_product_grid_column_tablet',
                [
                    'label' => esc_html__( 'Tablet Columns', 'woolentor-pro' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '2',
                    'options' => [
                        '1' => esc_html__( '1', 'woolentor-pro' ),
                        '2' => esc_html__( '2', 'woolentor-pro' ),
                        '3' => esc_html__( '3', 'woolentor-pro' ),
                        '4' => esc_html__( '4', 'woolentor-pro' ),
                        '5' => esc_html__( '5', 'woolentor-pro' ),
                        '6' => esc_html__( '6', 'woolentor-pro' ),
                    ],

                ]
            );

            $this->add_control(
                'woolentor_product_grid_column_mobile',
                [
                    'label' => esc_html__( 'Mobile Columns', 'woolentor-pro' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '1',
                    'options' => [
                        '1' => esc_html__( '1', 'woolentor-pro' ),
                        '2' => esc_html__( '2', 'woolentor-pro' ),
                        '3' => esc_html__( '3', 'woolentor-pro' ),
                        '4' => esc_html__( '4', 'woolentor-pro' ),
                        '5' => esc_html__( '5', 'woolentor-pro' ),
                        '6' => esc_html__( '6', 'woolentor-pro' ),
                    ],
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'woolentor-products',
            [
                'label' => __( 'Query Settings', 'woolentor-pro' ),
            ]
        );

            $this->add_control(
              'woolentor_product_grid_products_count',
                [
                    'label'   => __( 'Product Limit', 'woolentor-pro' ),
                    'type'    => Controls_Manager::NUMBER,
                    'default' => 3,
                    'step'    => 1,
                ]
            );

            $this->add_control(
                'woolentor_product_grid_categories',
                [
                    'label' => esc_html__( 'Product Categories', 'woolentor-pro' ),
                    'type' => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'multiple' => true,
                    'options' => woolentor_taxonomy_list(),
                ]
            );

            $this->add_control(
                'woolentor_custom_order',
                [
                    'label' => __( 'Custom order', 'woolentor-pro' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $this->add_control(
                'orderby',
                [
                    'label' => __( 'Orderby', 'woolentor-pro' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'none',
                    'options' => [
                        'none'          => __('None','woolentor-pro'),
                        'ID'            => __('ID','woolentor-pro'),
                        'date'          => __('Date','woolentor-pro'),
                        'name'          => __('Name','woolentor-pro'),
                        'title'         => __('Title','woolentor-pro'),
                        'comment_count' => __('Comment count','woolentor-pro'),
                        'rand'          => __('Random','woolentor-pro'),
                    ],
                    'condition' => [
                        'woolentor_custom_order' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'order',
                [
                    'label' => __( 'order', 'woolentor-pro' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'DESC',
                    'options' => [
                        'DESC'  => __('Descending','woolentor-pro'),
                        'ASC'   => __('Ascending','woolentor-pro'),
                    ],
                    'condition' => [
                        'woolentor_custom_order' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'query_post_type',
                [
                    'type' => 'hidden',
                    'default' => 'current_query',
                ]
            );

            $this->add_control(
                'paginate',
                [
                    'label' => __( 'Pagination', 'woolentor-pro' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'allow_order',
                [
                    'label' => __( 'Allow Order', 'woolentor-pro' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'show_result_count',
                [
                    'label' => __( 'Show Result Count', 'woolentor-pro' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

        $this->end_controls_section();

        // Product Content
        $this->start_controls_section(
            'woolentor-products-content-setting',
            [
                'label' => __( 'Content Settings', 'woolentor-pro' ),
            ]
        );
            $this->add_control(
                'product_content_style',
                [
                    'label'   => __( 'Style', 'woolentor-pro' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => '1',
                    'options' => [
                        '1'  => __( 'Style One', 'woolentor-pro' ),
                        '2'  => __( 'Style Two', 'woolentor-pro' ),
                        '3'  => __( 'Style Three', 'woolentor-pro' ),
                        '4'  => __( 'Style Four', 'woolentor-pro' ),
                    ]
                ]
            );

            $this->add_control(
                'hide_product_title',
                [
                    'label'     => __( 'Hide Title', 'woolentor-pro' ),
                    'type'      => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} .ht-product-inner .ht-product-title' => 'display: none !important;',
                        '{{WRAPPER}} .wlshop-list-content h3' => 'display: none !important;',
                    ],
                ]
            );

            $this->add_control(
                'hide_product_price',
                [
                    'label'     => __( 'Hide Price', 'woolentor-pro' ),
                    'type'      => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} .ht-product-inner .ht-product-price' => 'display: none !important;',
                        '{{WRAPPER}} .wlshop-list-content .ht-product-list-price' => 'display: none !important;',
                    ],
                ]
            );

            $this->add_control(
                'hide_product_category',
                [
                    'label'     => __( 'Hide Category', 'woolentor-pro' ),
                    'type'      => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} .ht-product-inner .ht-product-categories' => 'display: none !important;',
                        '{{WRAPPER}} .wlshop-list-content .ht-product-categories' => 'display: none !important;',
                    ],
                ]
            );

            $this->add_control(
                'hide_product_ratting',
                [
                    'label'     => __( 'Hide Rating', 'woolentor-pro' ),
                    'type'      => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} .ht-product-inner .ht-product-ratting-wrap' => 'display: none !important;',
                        '{{WRAPPER}} .wlshop-list-content .ht-product-list-ratting' => 'display: none !important;',
                    ],
                ]
            );

            $this->add_control(
                'hide_product_gird_content',
                [
                    'label'     => __( 'Grid Description ', 'woolentor-pro' ),
                    'type'      => Controls_Manager::SWITCHER,
                ]
            );
            $this->add_control(
              'woolentor_product_grid_desription_count',
                [
                    'label'   => __( 'Description Limit', 'woolentor-pro' ),
                    'type'    => Controls_Manager::NUMBER,
                    'default' => 15,
                    'step'    => 1,
                    'condition' => [
                    	'hide_product_gird_content' => 'yes'
                    ]
                ]
            );
            $this->add_control(
                'hide_product_list_content',
                [
                    'label'     => __( 'Hide List Description', 'woolentor-pro' ),
                    'type'      => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} .wlshop-list-content .woocommerce-product-details__short-description' => 'display: none !important;',
                    ],
                ]
            );
            $this->add_control(
              'woolentor_list_desription_count',
                [
                    'label'   => __( 'Description Limit', 'woolentor-pro' ),
                    'type'    => Controls_Manager::NUMBER,
                    'default' => 150,
                    'step'    => 1,
                    'condition' => [
                    	'hide_product_list_content!' => 'yes'
                    ]
                ]
            );

            $this->add_control(
                'hide_product_sale_badge',
                [
                    'label'     => __( 'Hide Sale Badge', 'woolentor-pro' ),
                    'type'      => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} .ht-product-image-wrap .ht-product-label' => 'display: none !important;',
                    ],
                ]
            );
            $this->add_control(
                'product_sale_badge_type',
                [
                    'label'     => __( 'Sale Badge Type', 'woolentor-pro' ),
                    'type'      => Controls_Manager::SELECT,
                    'default'   => 'default',
                    'options'   => [
                        'default'       => __( 'Default', 'woolentor-pro' ),
                        'custom'        => __( 'Custom', 'woolentor-pro' ),
                        'dis_percent'   => __( 'Percentage', 'woolentor-pro' ),
                        'dis_price'     => __( 'Discount Ammount', 'woolentor-pro' ),
                    ],                    
                    'condition' => [
                    	'hide_product_sale_badge!' => 'yes'
                    ]
                ]
            );
            $this->add_control(
                'product_sale_badge_custom',
                [
                    'label'     => __( 'Custom Badge Text', 'woolentor-pro' ),
                    'type'      => Controls_Manager::TEXT,
                    'default'   => 'Sale!',
                    'condition' => [
                        'product_sale_badge_type' =>'custom'
                    ]
                ]
            );
            $this->add_control(
                'product_sale_percent_position',
                [
                    'label'     => __( 'Additional Text Position', 'woolentor-pro' ),
                    'type'      => Controls_Manager::SELECT,
                    'default'   => 'before',
                    'options'   => [
                        'after' => __( 'After', 'woolentor-pro' ),
                        'before'=> __( 'Before', 'woolentor-pro' ),
                    ],
                    'condition' => [
                        'product_sale_badge_type' => array('dis_percent','dis_price'),
                    ]
                ]
            );
            $this->add_control(
                'product_after_badge_percent',
                [
                    'label'     => __( 'After Text', 'woolentor-pro' ),
                    'type'      => Controls_Manager::TEXT,
                    'condition' => [
                        'product_sale_percent_position' =>'after',
                        'product_sale_badge_type' => array('dis_percent','dis_price'),
                    ]
                ]
            );
            $this->add_control(
                'product_before_badge_percent',
                [
                    'label'     => __( 'Before Text', 'woolentor-pro' ),
                    'type'      => Controls_Manager::TEXT,
                    'condition' => [
                        'product_sale_percent_position' =>'before',
                        'product_sale_badge_type' => array('dis_percent','dis_price'),
                    ]
                ]
            );

            $this->add_control(
                'title_length',
                [
                    'label'     => __( 'Title Length', 'woolentor-pro' ),
                    'type'      => Controls_Manager::NUMBER,
                    'min'       => 0,
                    'max'       => 1000,
                    'step'      => 1,
                    'default'   => 3
                ]
            );

            $this->add_control(
                'stock_progress_bar',
                [
                    'label'     => __( 'Show Product Stock Progress Bar', 'woolentor-pro' ),
                    'type'      => Controls_Manager::SWITCHER,
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_stock_progressbar',
            [
                'label' => __( 'Stock Progressbar', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition'=>[
                    'stock_progress_bar'=>'yes',
                ],
            ]
        );
            
            $this->add_control(
                'hide_order_counter',
                [
                    'label'     => __( 'Hide Order Counter', 'woolentor-pro' ),
                    'type'      => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} .wltotal-sold' => 'display: none !important;',
                    ],
                ]
            );

            $this->add_control(
                'hide_available_counter',
                [
                    'label'     => __( 'Hide Available Counter', 'woolentor-pro' ),
                    'type'      => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} .wlcurrent-stock' => 'display: none !important;',
                    ],
                ]
            );

            $this->add_control(
                'order_custom_text',
                [
                    'label' => __( 'Ordered Custom Text', 'woolentor-pro' ),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => __( 'Ordered', 'woolentor-pro' ),
                    'condition' => [
                        'hide_order_counter!' => 'yes',
                    ],
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'available_custom_text',
                [
                    'label' => __( 'Available Custom Text', 'woolentor-pro' ),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => __( 'Items available', 'woolentor-pro' ),
                    'condition' => [
                        'hide_available_counter!' => 'yes',
                    ],
                    'label_block' => true,
                ]
            );

        $this->end_controls_section();

        // Product Action Button
        $this->start_controls_section(
            'woolentor-products-action-button',
            [
                'label' => __( 'Action Button Settings', 'woolentor-pro' ),
            ]
        );
            
            $this->add_control(
                'show_action_button',
                [
                    'label' => __( 'Action Button', 'woolentor-pro' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'woolentor-pro' ),
                    'label_off' => __( 'Hide', 'woolentor-pro' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'show_quickview_button',
                [
                    'label' => __( 'Hide Quick View Button', 'woolentor-pro' ),
                    'type' => Controls_Manager::SWITCHER,
                    'condition'=>[
                        'show_action_button'=>'yes',
                    ],
                ]
            );

            $this->add_control(
                'show_wishlist_button',
                [
                    'label' => __( 'Hide Wishlist Button', 'woolentor-pro' ),
                    'type' => Controls_Manager::SWITCHER,
                    'condition'=>[
                        'show_action_button'=>'yes',
                    ],
                ]
            );

            $this->add_control(
                'show_compare_button',
                [
                    'label' => __( 'Hide Compare Button', 'woolentor-pro' ),
                    'type' => Controls_Manager::SWITCHER,
                    'condition'=>[
                        'show_action_button'=>'yes',
                    ],
                ]
            );

            $this->add_control(
                'show_addtocart_button',
                [
                    'label' => __( 'Hide Shopping Cart Button', 'woolentor-pro' ),
                    'type' => Controls_Manager::SWITCHER,
                    'condition'=>[
                        'show_action_button'=>'yes',
                    ],
                ]
            );

            $this->add_control(
                'action_button_style',
                [
                    'label'   => __( 'Style', 'woolentor-pro' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => '1',
                    'options' => [
                        '1'   => __( 'Style One', 'woolentor-pro' ),
                        '2'   => __( 'Style Two', 'woolentor-pro' ),
                        '3'   => __( 'Style Three', 'woolentor-pro' ),
                    ],
                    'condition'=>[
                        'show_action_button'=>'yes',
                    ]
                ]
            );

            $this->add_control(
                'action_button_show_on',
                [
                    'label'   => __( 'Show On', 'woolentor-pro' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'normal',
                    'options' => [
                        'hover'   => __( 'Hover', 'woolentor-pro' ),
                        'normal'  => __( 'Normal', 'woolentor-pro' ),
                    ],
                    'condition'=>[
                        'show_action_button'=>'yes',
                    ]
                ]
            );

            $this->add_control(
                'action_button_position',
                [
                    'label'   => __( 'Position', 'woolentor-pro' ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'woolentor-pro' ),
                            'icon'  => 'eicon-h-align-left',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'woolentor-pro' ),
                            'icon'  => 'eicon-h-align-right',
                        ],
                        'middle' => [
                            'title' => __( 'Middle', 'woolentor-pro' ),
                            'icon'  => 'eicon-v-align-middle',
                        ],
                        'bottom' => [
                            'title' => __( 'Bottom', 'woolentor-pro' ),
                            'icon'  => 'eicon-v-align-bottom',
                        ],
                        'contentbottom' => [
                            'title' => __( 'Content Bottom', 'woolentor-pro' ),
                            'icon'  => 'eicon-v-align-bottom',
                        ],
                    ],
                    'default'     => is_rtl() ? 'left' : 'right',
                    'toggle'      => false,
                ]
            );

        $this->end_controls_section();

        // Product Image Setting
        $this->start_controls_section(
            'woolentor-products-thumbnails-setting',
            [
                'label' => __( 'Image Settings', 'woolentor-pro' ),
            ]
        );

            $this->add_control(
                'thumbnails_style',
                [
                    'label'   => __( 'Thumbnails Style', 'woolentor-pro' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => '1',
                    'options' => [
                        '1'  => __( 'Single Image', 'woolentor-pro' ),
                        '2'  => __( 'Image Slider', 'woolentor-pro' ),
                        '3'  => __( 'Gallery Tab', 'woolentor-pro' ),
                    ]
                ]
            );

            $this->add_control(
                'image_navigation_bg_color',
                [
                    'label' => __( 'Arrows Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' =>'#444444',
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-image-wrap .ht-product-image .ht-product-image-slider .slick-arrow' => 'color: {{VALUE}} !important;',
                    ],
                    'condition'=>[
                        'thumbnails_style'=>'2',
                    ]
                ]
            );

            $this->add_control(
                'image_dots_normal_bg_color',
                [
                    'label' => __( 'Dots Background Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' =>'#cccccc',
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-image-wrap .ht-product-image .ht-product-image-slider .slick-dots li button' => 'background-color: {{VALUE}} !important;',
                    ],
                    'condition'=>[
                        'thumbnails_style'=>'2',
                    ]
                ]
            );

            $this->add_control(
                'image_dots_hover_bg_color',
                [
                    'label' => __( 'Dots Active Background Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'condition'=>[
                        'thumbnails_style'=>'2',
                    ],
                    'default' =>'#666666',
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-image-wrap .ht-product-image .ht-product-image-slider .slick-dots li.slick-active button' => 'background-color: {{VALUE}} !important;',
                    ],
                ]
            );

            $this->add_control(
                'image_tab_menu_border_color',
                [
                    'label' => __( 'Border Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' =>'#737373',
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-image-wrap .ht-product-image .ht-product-cus-tab-links li a' => 'border-color: {{VALUE}};',
                    ],
                    'condition'=>[
                        'thumbnails_style'=>'3',
                    ]
                ]
            );

            $this->add_control(
                'image_tab_menu_active_border_color',
                [
                    'label' => __( 'Active Border Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' =>'#ECC87B',
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-image-wrap .ht-product-image .ht-product-cus-tab-links li a.htactive' => 'border-color: {{VALUE}} !important;',
                    ],
                    'condition'=>[
                        'thumbnails_style'=>'3',
                    ]
                ]
            );

        $this->end_controls_section();

        // Product countdown
        $this->start_controls_section(
            'woolentor-products-countdown-setting',
            [
                'label' => __( 'Offer Price Counter Settings', 'woolentor-pro' ),
            ]
        );
            
            $this->add_control(
                'show_countdown',
                [
                    'label' => __( 'Show Countdown Timer', 'woolentor-pro' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'woolentor-pro' ),
                    'label_off' => __( 'Hide', 'woolentor-pro' ),
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $this->add_control(
                'show_countdown_gutter',
                [
                    'label' => __( 'Gutter', 'woolentor-pro' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Yes', 'woolentor-pro' ),
                    'label_off' => __( 'No', 'woolentor-pro' ),
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'condition' =>[
                        'show_countdown' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'product_countdown_position',
                [
                    'label'   => __( 'Position', 'woolentor-pro' ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'woolentor-pro' ),
                            'icon'  => 'eicon-h-align-left',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'woolentor-pro' ),
                            'icon'  => 'eicon-h-align-right',
                        ],
                        'middle' => [
                            'title' => __( 'Middle', 'woolentor-pro' ),
                            'icon'  => 'eicon-v-align-middle',
                        ],
                        'bottom' => [
                            'title' => __( 'Bottom', 'woolentor-pro' ),
                            'icon'  => 'eicon-v-align-bottom',
                        ],
                        'contentbottom' => [
                            'title' => __( 'Content Bottom', 'woolentor-pro' ),
                            'icon'  => 'eicon-v-align-bottom',
                        ],
                    ],
                    'default'     => 'bottom',
                    'toggle'      => false,
                    'label_block' => true,
                    'condition' =>[
                        'show_countdown' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'custom_labels',
                [
                    'label'        => __( 'Custom Label', 'woolentor-pro' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'condition'   => [
                        'show_countdown' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'customlabel_days',
                [
                    'label'       => __( 'Days', 'woolentor-pro' ),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => __( 'Days', 'woolentor-pro' ),
                    'condition'   => [
                        'custom_labels!' => '',
                        'show_countdown' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'customlabel_hours',
                [
                    'label'       => __( 'Hours', 'woolentor-pro' ),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => __( 'Hours', 'woolentor-pro' ),
                    'condition'   => [
                        'custom_labels!' => '',
                        'show_countdown' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'customlabel_minutes',
                [
                    'label'       => __( 'Minutes', 'woolentor-pro' ),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => __( 'Minutes', 'woolentor-pro' ),
                    'condition'   => [
                        'custom_labels!' => '',
                        'show_countdown' => 'yes',
                    ]
                ]
            );

            $this->add_control(
                'customlabel_seconds',
                [
                    'label'       => __( 'Seconds', 'woolentor-pro' ),
                    'type'        => Controls_Manager::TEXT,
                    'placeholder' => __( 'Seconds', 'woolentor-pro' ),
                    'condition'   => [
                        'custom_labels!' => '',
                        'show_countdown' => 'yes',
                    ]
                ]
            );

        $this->end_controls_section();

        // Style Default tab section
        $this->start_controls_section(
            'universal_product_style_section',
            [
                'label' => __( 'Grid View Style', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control(
                'product_inner_padding',
                [
                    'label' => __( 'Padding', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce div.product.mb-30' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_inner_margin',
                [
                    'label' => __( 'Margin', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce div.product.mb-30' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'product_inner_border_color',
                [
                    'label' => __( 'Border Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' =>'#f1f1f1',
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner' => 'border-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'product_inner_box_shadow',
                    'label' => __( 'Hover Box Shadow', 'woolentor-pro' ),
                    'selector' => '{{WRAPPER}} .ht-products .ht-product .ht-product-inner:hover',
                ]
            );

            $this->add_control(
                'product_content_area_heading',
                [
                    'label' => __( 'Content area', 'woolentor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'product_content_area_padding',
                [
                    'label' => __( 'Padding', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'product_content_area_bg_color',
                [
                    'label' => __( 'Background Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'content_area_bg','woolentor_style_tabs', '#ffffff' ),
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'product_content_area_border',
                    'label' => __( 'Border', 'woolentor-pro' ),
                    'selector' => '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content',
                ]
            );

            $this->add_control(
                'product_badge_heading',
                [
                    'label' => __( 'Product Badge', 'woolentor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'product_badge_color',
                [
                    'label' => __( 'Badge Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'badge_color','woolentor_style_tabs', '#444444' ),
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-image-wrap .ht-product-label' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_badge_typography',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-image-wrap .ht-product-label',
                ]
            );

            // Product Category
            $this->add_control(
                'product_category_heading',
                [
                    'label' => __( 'Product Category', 'woolentor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_category_typography',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content .ht-product-content-inner .ht-product-categories a',
                ]
            );

            $this->add_control(
                'product_category_color',
                [
                    'label' => __( 'Category Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'category_color','woolentor_style_tabs', '#444444' ),
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content .ht-product-content-inner .ht-product-categories a' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content .ht-product-content-inner .ht-product-categories::before' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'product_category_hover_color',
                [
                    'label' => __( 'Category Hover Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'category_hover_color','woolentor_style_tabs', '#dc9a0e' ),
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content .ht-product-content-inner .ht-product-categories a:hover' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_category_margin',
                [
                    'label' => __( 'Margin', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content .ht-product-content-inner .ht-product-categories' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            // Product Title
            $this->add_control(
                'product_title_heading',
                [
                    'label' => __( 'Product Title', 'woolentor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_title_typography',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content .ht-product-content-inner .ht-product-title a',
                ]
            );

            $this->add_control(
                'product_title_color',
                [
                    'label' => __( 'Title Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,                    
                    'default' => woolentor_get_option_pro( 'title_color','woolentor_style_tabs', '#444444' ),
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content .ht-product-content-inner .ht-product-title a' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'product_title_hover_color',
                [
                    'label' => __( 'Title Hover Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'title_hover_color','woolentor_style_tabs', '#dc9a0e' ),
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content .ht-product-content-inner .ht-product-title a:hover' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_title_margin',
                [
                    'label' => __( 'Margin', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content .ht-product-content-inner .ht-product-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            // Product Price
            $this->add_control(
                'product_price_heading',
                [
                    'label' => __( 'Product Price', 'woolentor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'product_sale_price_color',
                [
                    'label' => __( 'Sale Price Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'sale_price_color','woolentor_style_tabs', '#444444' ),
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content .ht-product-content-inner .ht-product-price span' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_sale_price_typography',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content .ht-product-content-inner .ht-product-price span',
                ]
            );

            $this->add_control(
                'product_regular_price_color',
                [
                    'label' => __( 'Regular Price Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'separator' => 'before',
                    'default' => woolentor_get_option_pro( 'regular_price_color','woolentor_style_tabs', '#444444' ),
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content .ht-product-content-inner .ht-product-price span del span,{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content .ht-product-content-inner .ht-product-price span del' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_regular_price_typography',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content .ht-product-content-inner .ht-product-price span del span',
                ]
            );

            $this->add_responsive_control(
                'product_price_margin',
                [
                    'label' => __( 'Margin', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content .ht-product-content-inner .ht-product-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            // Product Rating
            $this->add_control(
                'product_rating_heading',
                [
                    'label' => __( 'Product Rating', 'woolentor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'product_rating_color',
                [
                    'label' => __( 'Empty Rating Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'empty_rating_color','woolentor_style_tabs', '#aaaaaa' ),
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content .ht-product-content-inner .ht-product-ratting-wrap .ht-product-ratting .ht-product-user-ratting i.empty' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'product_rating_give_color',
                [
                    'label' => __( 'Rating Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'rating_color','woolentor_style_tabs', '#dc9a0e' ),
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content .ht-product-content-inner .ht-product-ratting-wrap .ht-product-ratting .ht-product-user-ratting i' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_rating_margin',
                [
                    'label' => __( 'Margin', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content .ht-product-content-inner .ht-product-ratting-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

             // Product Description
            $this->add_control(
                'product_grid_description_heading',
                [
                    'label' => __( 'Product Description', 'woolentor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_grid_description_typography',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .ht-product-content .woocommerce-product-details__short-description p',
                ]
            );

            $this->add_control(
                'product_grid_description_color',
                [
                    'label' => __( 'Description Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'desc_color','woolentor_style_tabs', '#444444' ),
                    'selectors' => [
                        '{{WRAPPER}} .ht-product-content .woocommerce-product-details__short-description p' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_grid_description_margin',
                [
                    'label' => __( 'Margin', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .ht-product-content .woocommerce-product-details__short-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section(); // Style Default End

        // Style Action Button tab section
        $this->start_controls_section(
            'universal_product_action_button_style_section',
            [
                'label' => __( 'Action Button Style', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'product_action_button_background_color',
                    'label' => __( 'Background', 'woolentor-pro' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-action ul',
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'product_action_button_box_shadow',
                    'label' => __( 'Box Shadow', 'woolentor-pro' ),
                    'selector' => '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-action ul',
                ]
            );

            $this->add_control(
                'product_tooltip_heading',
                [
                    'label' => __( 'Tooltip', 'woolentor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

                $this->add_control(
                    'product_tooltip_color',
                    [
                        'label' => __( 'Tool Tip Color', 'woolentor-pro' ),
                        'type' => Controls_Manager::COLOR,
                        'default' => woolentor_get_option_pro( 'tooltip_color','woolentor_style_tabs', '#ffffff' ),
                        'selectors' => [
                            '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-action ul li a .ht-product-action-tooltip,{{WRAPPER}} span.woolentor-tip' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'product_action_button_tooltip_background_color',
                        'label' => __( 'Background', 'woolentor-pro' ),
                        'types' => [ 'classic', 'gradient' ],
                        'selector' => '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-action ul li a .ht-product-action-tooltip,{{WRAPPER}} span.woolentor-tip',
                    ]
                );

            $this->start_controls_tabs('product_action_button_style_tabs');

                // Normal
                $this->start_controls_tab(
                    'product_action_button_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'woolentor-pro' ),
                    ]
                );
                    
                    $this->add_control(
                        'product_action_button_normal_color',
                        [
                            'label' => __( 'Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => woolentor_get_option_pro( 'btn_color','woolentor_style_tabs', '#000000' ),
                            'selectors' => [
                                '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-action ul li a' => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'product_action_button_font_size',
                        [
                            'label' => __( 'Font Size', 'woolentor-pro' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 200,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 20,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-action ul li a i' => 'font-size: {{SIZE}}{{UNIT}};',
                                '{{WRAPPER}} .woolentor-compare.compare::before,{{WRAPPER}} .ht-product-action ul li.woolentor-cart a::before' => 'font-size: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'product_action_button_line_height',
                        [
                            'label' => __( 'Line Height', 'woolentor-pro' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 200,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 30,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-action ul li a i' => 'line-height: {{SIZE}}{{UNIT}};',
                                '{{WRAPPER}} .woolentor-compare.compare::before,{{WRAPPER}} .ht-product-action ul li.woolentor-cart a::before' => 'line-height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'product_action_button_normal_background_color',
                            'label' => __( 'Background', 'woolentor-pro' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-action ul li',
                        ]
                    );

                    $this->add_responsive_control(
                        'product_action_button_normal_padding',
                        [
                            'label' => __( 'Padding', 'woolentor-pro' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-action ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'product_action_button_normal_margin',
                        [
                            'label' => __( 'Margin', 'woolentor-pro' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-action ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'product_action_button_normal_button_border',
                            'label' => __( 'Border', 'woolentor-pro' ),
                            'selector' => '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-action ul li',
                        ]
                    );

                    $this->add_responsive_control(
                        'product_action_button_border_radius',
                        [
                            'label' => __( 'Border Radius', 'woolentor-pro' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-action ul li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'product_action_button_width',
                        [
                            'label' => __( 'Width', 'woolentor-pro' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 200,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 30,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-action ul li a' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'product_action_button_height',
                        [
                            'label' => __( 'Height', 'woolentor-pro' ),
                            'type' => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 200,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 30,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-action ul li a' => 'height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Hover
                $this->start_controls_tab(
                    'product_action_button_style_hover_tab',
                    [
                        'label' => __( 'Hover', 'woolentor-pro' ),
                    ]
                );
                    
                    $this->add_control(
                        'product_action_button_hover_color',
                        [
                            'label' => __( 'Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'default' => woolentor_get_option_pro( 'btn_hover_color','woolentor_style_tabs', '#dc9a0e' ),
                            'selectors' => [
                                '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-action ul li:hover a' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .ht-product-action .yith-wcwl-wishlistaddedbrowse a, .ht-product-action .yith-wcwl-wishlistexistsbrowse a' => 'color: {{VALUE}} !important;',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'product_action_button_hover_background_color',
                            'label' => __( 'Background', 'woolentor-pro' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-action ul li:hover',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'product_action_button_hover_button_border',
                            'label' => __( 'Border', 'woolentor-pro' ),
                            'selector' => '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-action ul li:hover',
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        // Style Countdown tab section
        $this->start_controls_section(
            'universal_product_counter_style_section',
            [
                'label' => __( 'Offer Price Counter', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'show_countdown'=>'yes',
                ]
            ]
        );

            $this->add_control(
                'product_counter_color',
                [
                    'label' => __( 'Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'counter_color','woolentor_style_tabs', '#ffffff' ),
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-countdown-wrap .ht-product-countdown .cd-single .cd-single-inner h3' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-countdown-wrap .ht-product-countdown .cd-single .cd-single-inner p' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'product_counter_background_color',
                    'label' => __( 'Counter Background', 'woolentor-pro' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-countdown-wrap .ht-product-countdown .cd-single .cd-single-inner,{{WRAPPER}} .ht-products .ht-product.ht-product-countdown-fill .ht-product-inner .ht-product-countdown-wrap .ht-product-countdown',
                ]
            );

            $this->add_responsive_control(
                'product_counter_space_between',
                [
                    'label' => __( 'Space', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-countdown-wrap .ht-product-countdown .cd-single' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
        $this->end_controls_section();

        // Pagination Style Section
        $this->start_controls_section(
            'product-pagination-section',
            [
                'label' => __( 'Pagination', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'paginate' => 'yes',
                ],
            ]
        );
            $this->start_controls_tabs('product_pagination_style_tabs');

                // Pagination normal style
                $this->start_controls_tab(
                    'product_pagination_style_normal_tab',
                    [
                        'label' => __( 'Normal', 'woolentor-pro' ),
                    ]
                );
                    
                    $this->add_control(
                        'product_pagination_border_color',
                        [
                            'label' => __( 'Border Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woolentor-custom-product-archive nav.woocommerce-pagination ul' => 'border-color: {{VALUE}} !important',
                                '{{WRAPPER}}.elementor-widget-woolentor-custom-product-archive nav.woocommerce-pagination ul li' => 'border-right-color: {{VALUE}} !important; border-left-color: {{VALUE}} !important',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'product_pagination_border_radius',
                        [
                            'label' => __( 'Border Radisu', 'woolentor-pro' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woolentor-custom-product-archive nav.woocommerce-pagination ul li a, {{WRAPPER}}.elementor-widget-woolentor-custom-product-archive nav.woocommerce-pagination ul li span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'product_pagination_padding',
                        [
                            'label' => __( 'Padding', 'woolentor-pro' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woolentor-custom-product-archive nav.woocommerce-pagination ul li a, {{WRAPPER}}.elementor-widget-woolentor-custom-product-archive nav.woocommerce-pagination ul li span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'product_pagination_link_color',
                        [
                            'label' => __( 'Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woolentor-custom-product-archive nav.woocommerce-pagination ul li a' => 'color: {{VALUE}} !important',
                            ],
                        ]
                    );

                    $this->add_control(
                        'product_pagination_link_bg_color',
                        [
                            'label' => __( 'Background Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woolentor-custom-product-archive nav.woocommerce-pagination ul li a' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Pagination Active style
                $this->start_controls_tab(
                    'product_pagination_style_active_tab',
                    [
                        'label' => __( 'Active', 'woolentor-pro' ),
                    ]
                );
                    
                    $this->add_control(
                        'product_pagination_link_color_hover',
                        [
                            'label' => __( 'Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woolentor-custom-product-archive nav.woocommerce-pagination ul li a:hover' => 'color: {{VALUE}}',
                                '{{WRAPPER}}.elementor-widget-woolentor-custom-product-archive nav.woocommerce-pagination ul li span.current' => 'color: {{VALUE}} !important',
                            ],
                        ]
                    );

                    $this->add_control(
                        'product_pagination_link_bg_color_hover',
                        [
                            'label' => __( 'Background Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}}.elementor-widget-woolentor-custom-product-archive nav.woocommerce-pagination ul li a:hover' => 'background-color: {{VALUE}}',
                                '{{WRAPPER}}.elementor-widget-woolentor-custom-product-archive nav.woocommerce-pagination ul li span.current' => 'background-color: {{VALUE}} !important',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        // List View Style section
        $this->start_controls_section(
            'universal_product_list_style_section',
            [
                'label' => __( 'List View Style', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            // Product Description
            $this->add_control(
                'product_list_viewmode_heading',
                [
                    'label' => __( 'Viewing Mode Button', 'woolentor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'product_list_viewmode_button_color',
                [
                    'label' => __( 'Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' =>'#000000',
                    'selectors' => [
                        '{{WRAPPER}} .wl-shop-tab-links li a' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'product_list_viewmode_active_color',
                [
                    'label' => __( 'Active Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' =>'#f05b64',
                    'selectors' => [
                        '{{WRAPPER}} .wl-shop-tab-links li a:hover' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .wl-shop-tab-links li a.htactive' => 'color: {{VALUE}};',
                    ],
                ]
            );

            // Product Description
            $this->add_control(
                'product_list_description_heading',
                [
                    'label' => __( 'Product Description', 'woolentor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_list_description_typography',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .wlshop-list-content .woocommerce-product-details__short-description p',
                ]
            );

            $this->add_control(
                'product_list_description_color',
                [
                    'label' => __( 'Description Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'desc_color','woolentor_style_tabs', '#444444' ),
                    'selectors' => [
                        '{{WRAPPER}} .wlshop-list-content .woocommerce-product-details__short-description p' => 'color: {{VALUE}};',
                    ],
                ]
            );

            // Product Category
            $this->add_control(
                'product_list_category_heading',
                [
                    'label' => __( 'Product Category', 'woolentor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_list_category_typography',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .wlshop-list-content .ht-product-categories a',
                ]
            );

            $this->add_control(
                'product_list_category_color',
                [
                    'label' => __( 'Category Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'category_color','woolentor_style_tabs', '#444444' ),
                    'selectors' => [
                        '{{WRAPPER}} .wlshop-list-content .ht-product-categories a' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'product_list_category_hover_color',
                [
                    'label' => __( 'Category Hover Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'category_hover_color','woolentor_style_tabs', '#dc9a0e' ),
                    'selectors' => [
                        '{{WRAPPER}} .wlshop-list-content .ht-product-categories a:hover' => 'color: {{VALUE}};',
                    ],
                ]
            );

            // Product Title
            $this->add_control(
                'product_list_title_heading',
                [
                    'label' => __( 'Product Title', 'woolentor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_list_title_typography',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .wlshop-list-content h3',
                ]
            );

            $this->add_control(
                'product_list_title_color',
                [
                    'label' => __( 'Title Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'title_color','woolentor_style_tabs', '#444444' ),
                    'selectors' => [
                        '{{WRAPPER}} .wlshop-list-content h3 a' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'product_list_title_hover_color',
                [
                    'label' => __( 'Title Hover Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'title_hover_color','woolentor_style_tabs', '#dc9a0e' ),
                    'selectors' => [
                        '{{WRAPPER}} .wlshop-list-content h3 a:hover' => 'color: {{VALUE}};',
                    ],
                ]
            );

            // Product Price
            $this->add_control(
                'product_list_price_heading',
                [
                    'label' => __( 'Product Price', 'woolentor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'product_list_sale_price_color',
                [
                    'label' => __( 'Sale Price Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'sale_price_color','woolentor_style_tabs', '#444444' ),
                    'selectors' => [
                        '{{WRAPPER}} .wlshop-list-wrap .wlshop-list-content .ht-product-list-price span.price' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_list_sale_price_typography',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .wlshop-list-wrap .wlshop-list-content .ht-product-list-price span.price',
                ]
            );

            $this->add_control(
                'product_list_regular_price_color',
                [
                    'label' => __( 'Regular Price Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'separator' => 'before',
                    'default' => woolentor_get_option_pro( 'regular_price_color','woolentor_style_tabs', '#444444' ),
                    'selectors' => [
                        '{{WRAPPER}} .wlshop-list-wrap .wlshop-list-content .ht-product-list-price span.price del span' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_list_regular_price_typography',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .wlshop-list-wrap .wlshop-list-content .ht-product-list-price span.price del span',
                ]
            );

            // Product Rating
            $this->add_control(
                'product_list_rating_heading',
                [
                    'label' => __( 'Product Rating', 'woolentor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'product_list_rating_color',
                [
                    'label' => __( 'Empty Rating Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'empty_rating_color','woolentor_style_tabs', '#aaaaaa' ),
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content .ht-product-content-inner .ht-product-ratting-wrap .ht-product-ratting .ht-product-user-ratting i.empty' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'product_list_rating_give_color',
                [
                    'label' => __( 'Rating Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'rating_color','woolentor_style_tabs', '#dc9a0e' ),
                    'selectors' => [
                        '{{WRAPPER}} .ht-products .ht-product .ht-product-inner .ht-product-content .ht-product-content-inner .ht-product-ratting-wrap .ht-product-ratting .ht-product-user-ratting i' => 'color: {{VALUE}};',
                    ],
                ]
            );

            // List view cart button
            $this->add_control(
                'product_list_cart_button_heading',
                [
                    'label' => __( 'Add to Cart Button', 'woolentor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'product_list_cart_button_typography',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .woocommerce .ht-product-list-action ul li a',
                ]
            );

            $this->add_control(
                'product_list_cart_button_color',
                [
                    'label' => __( 'Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'list_btn_color','woolentor_style_tabs', '#000000' ),
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce .ht-product-list-action ul li a' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'product_list_cart_button_border_color',
                [
                    'label' => __( 'Border Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'list_btn_bg_color','woolentor_style_tabs', '#000000' ),
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce .ht-product-list-action ul li a' => 'border-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'product_list_cart_button_background_color',
                [
                    'label' => __( 'Background Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'list_btn_bg_color','woolentor_style_tabs', '#ffffff' ),
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce .ht-product-list-action ul li a' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'product_list_cart_button_hover_color',
                [
                    'label' => __( 'Hover Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'list_btn_hover_color','woolentor_style_tabs', '#ffffff' ),
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce .ht-product-list-action ul li a:hover' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'product_list_cart_button_hover_border_color',
                [
                    'label' => __( 'Hover Border Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'list_btn_hover_bg_color','woolentor_style_tabs', '#ff3535' ),
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce .ht-product-list-action ul li a:hover' => 'border-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'product_list_cart_button_hover_background_color',
                [
                    'label' => __( 'Hover Background Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'list_btn_hover_bg_color','woolentor_style_tabs', '#ff3535' ),
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce .ht-product-list-action ul li a:hover' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            // List view quickview button
            $this->add_control(
                'product_list_quickview_button_heading',
                [
                    'label' => __( 'Quickview Button', 'woolentor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'product_list_quickview_button_color',
                [
                    'label' => __( 'Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'list_btn_color','woolentor_style_tabs', '#000000' ),
                    'selectors' => [
                        '{{WRAPPER}} .wlshop-list-wrap .wlproduct-list-img .product-quickview a' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'product_list_quickview_button_background_color',
                [
                    'label' => __( 'Background Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'list_btn_bg_color','woolentor_style_tabs', '#ffffff' ),
                    'selectors' => [
                        '{{WRAPPER}} .wlshop-list-wrap .wlproduct-list-img .product-quickview a' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'product_list_quickview_button_hover_color',
                [
                    'label' => __( 'Hover Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'list_btn_hover_color','woolentor_style_tabs', '#ffffff' ),
                    'selectors' => [
                        '{{WRAPPER}} .wlshop-list-wrap .wlproduct-list-img .product-quickview a:hover' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'product_list_quickview_button_hover_background_color',
                [
                    'label' => __( 'Hover Background Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => woolentor_get_option_pro( 'list_btn_hover_bg_color','woolentor_style_tabs', '#ff3535' ),
                    'selectors' => [
                        '{{WRAPPER}} .wlshop-list-wrap .wlproduct-list-img .product-quickview a:hover' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_section();

        // Progressbar Style
        $this->start_controls_section(
            'section_stock_progressbar_style',
            [
                'label' => __( 'Stock Progressbar', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'stock_progress_bar'=>'yes',
                ],
            ]
        );

            $this->add_control(
                'progressbar_heading',
                [
                    'label' => __( 'Progressbar', 'woolentor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'progressbar_height',
                [
                    'label' => __( 'Height', 'woolentor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 10,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .woolentor-stock-progress-bar .wlprogress-area' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'progressbar_bg_color',
                [
                    'label' => __( 'Background Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woolentor-stock-progress-bar .wlprogress-area' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'progressbar_active_bg_color',
                [
                    'label' => __( 'Sell Progress Background Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woolentor-stock-progress-bar .wlprogress-bar' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'progressbar_area',
                [
                    'label' => __( 'Margin', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .woolentor-stock-progress-bar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'progressbar_order_heading',
                [
                    'label' => __( 'Order & Ability Counter', 'woolentor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'order_ability_typography',
                    'label' => __( 'Typography', 'woolentor-pro' ),
                    'selector' => '{{WRAPPER}} .woolentor-stock-progress-bar .wlstock-info',
                ]
            );

            $this->add_control(
                'order_ability_color',
                [
                    'label' => __( 'Label Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woolentor-stock-progress-bar .wlstock-info' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'counter_number_color',
                [
                    'label' => __( 'Counter Number Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woolentor-stock-progress-bar .wlstock-info span' => 'color: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();


    }

    public function woolentor_custom_product_limit( $limit = 3 ) {
        $limit = $this->get_settings_for_display( 'woolentor_product_grid_products_count' );
        return $limit;
    }

    protected function render( $instance = [] ) {

        $settings           = $this->get_settings_for_display();
        $per_page           = $this->get_settings_for_display('woolentor_product_grid_products_count');
        $custom_order_ck    = $this->get_settings_for_display('woolentor_custom_order');
        $orderby            = $this->get_settings_for_display('orderby');
        $order              = $this->get_settings_for_display('order');
        $tabuniqid          = $this->get_id();
        $columns            = $this->get_settings_for_display('woolentor_product_grid_column');

        // Stock Progress Bar data
        $order_text     = $settings['order_custom_text'] ? $settings['order_custom_text'] : esc_html__('Ordered:','woolentor-pro');
        $available_text = $settings['available_custom_text'] ? $settings['available_custom_text'] : esc_html__( 'Items available:','woolentor-pro' );

        // Query Argument
        add_filter( 'product_custom_limit', array( $this, 'woolentor_custom_product_limit' ) );

        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
        $args = array(
            'post_type'             => 'product',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $per_page,
            'paged'                 => $paged,
        );
        $args['meta_query']   = WC()->query->get_meta_query();
        $args['tax_query']    = WC()->query->get_tax_query();

        // Category Wise
        $get_product_categories = $settings['woolentor_product_grid_categories'];
        if( !is_tax('product_cat') && !is_product_category() ){
            if( !empty( $get_product_categories ) ) {
                $args['tax_query'][] = array(
                    array(
                        'taxonomy'  => 'product_cat',
                        'field'     => 'slug', 
                        'terms'     => $get_product_categories,
                    )
                );
            }
        }

        // Taxonomy Taxquery
        $termobj = get_queried_object();
        if( isset( $termobj->taxonomy ) ){
            $term_id = $termobj->term_id;
            $args['tax_query'] = array(
                array(
                    'taxonomy' => $termobj->taxonomy,
                    'terms' => $term_id,
                    'field' => 'term_id',
                    'include_children' => true
                )
            );
        }

        if( $custom_order_ck == 'yes' ){
            $args['orderby'] = $orderby;
            $args['order'] = $order;
        }

        $ordering_args = WC()->query->get_catalog_ordering_args();
        if ( $ordering_args['meta_key'] ) {
            $args['meta_key'] = $ordering_args['meta_key'];
        }

        // Fintering by price
        if( isset( $_GET['min_price'] ) || isset( $_GET['max_price'] ) ){
            $args['meta_query'] = array(
                array(
                    'key' => '_price',
                    'value' => array( $_GET['min_price'], $_GET['max_price'] ),
                    'compare' => 'BETWEEN',
                    'type' => 'NUMERIC'
                ),
            );
        }

        // Search Result
        if ( isset( $_GET['q'] ) || isset( $_GET['s'] ) ) {
            $s = !empty( $_GET['s'] ) ? $_GET['s'] : '';
            $q = !empty( $_GET['q'] ) ? $_GET['q'] : '';
            $args['s'] = !empty( $q ) ? $q : $s;
        }

        // Support Filter
        $args = \WooLentorProThirdParty::instance()->support_filter( $args );

        $products = new \WP_Query( $args );

        // Calculate Column
        $collumval = 'ht-product ht-col-lg-4 ht-col-md-6 ht-col-sm-6 ht-col-xs-12 mb-30 product';
        if( $columns !='' ){
            $colwidthtablate = round( 12 / $settings['woolentor_product_grid_column_tablet'] );
            $colwidthmobile = round( 12 / $settings['woolentor_product_grid_column_mobile'] );
            if( $columns == 5 ){
                $collumval = 'ht-product cus-col-5 ht-col-md-'.$colwidthtablate.' ht-col-sm-'.$colwidthtablate.' ht-col-xs-'.$colwidthmobile.' mb-30 product';
            }else{
                $colwidth = round( 12 / $columns );
                $collumval = 'ht-product ht-col-lg-'.$colwidth.' ht-col-md-'.$colwidthtablate.' ht-col-sm-'.$colwidthtablate.' ht-col-xs-'.$colwidthmobile.' mb-30 product';
            }
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

    
        if( $products->have_posts() ):

            echo '<div class="woocommerce ht-row"><div class="ht-col-xs-12">';
                ?>
                <ul class="wl-shop-tab-links">
                    <li><a href="#grid-<?php echo $this->get_id(); ?>" class="<?php if( $settings['woolentor_product_view_mode'] == 'grid' ){ echo 'htactive'; } ?>"><i class="sli sli-grid"></i></a></li>
                    <li><a href="#list-<?php echo $this->get_id(); ?>" class="<?php if( $settings['woolentor_product_view_mode'] == 'list' ){ echo 'htactive'; } ?>"><i class="sli sli-menu"></i></a></li>
                </ul>
                <?php
                if( $settings['show_result_count'] == 'yes' ){
                    woolentor_product_result_count( $products->found_posts, $per_page, $paged );
                }
                if( $settings['allow_order'] == 'yes' ){
                    woocommerce_catalog_ordering();
                }
            echo '</div></div>';
        ?>
            <div class="ht-products woocommerce" >

                <div class="wl-shop-tab-pane <?php if( $settings['woolentor_product_view_mode'] == 'grid' ){ echo 'htactive'; } ?>" id="grid-<?php echo $this->get_id(); ?>">
                    <div class="ht-row">
                        <?php
                            while( $products->have_posts() ): $products->the_post();

                                // Sale Schedule
                                $offer_start_date_timestamp = get_post_meta( get_the_ID(), '_sale_price_dates_from', true );
                                $offer_start_date = $offer_start_date_timestamp ? date_i18n( 'Y/m/d', $offer_start_date_timestamp ) : '';
                                $offer_end_date_timestamp = get_post_meta( get_the_ID(), '_sale_price_dates_to', true );
                                $offer_end_date = $offer_end_date_timestamp ? date_i18n( 'Y/m/d', $offer_end_date_timestamp ) : '';

                                // Gallery Image
                                global $product;
                                $gallery_images_ids = $product->get_gallery_image_ids() ? $product->get_gallery_image_ids() : array();
                                if ( has_post_thumbnail() ){
                                    array_unshift( $gallery_images_ids, $product->get_image_id() );
                                }

                        ?>
                            <!--Product Start-->
                            <div class="<?php echo $collumval; ?>">
                                <div class="ht-product-inner">

                                    <div class="ht-product-image-wrap">
                                        <?php
                                            if( class_exists('WooCommerce') ){ 
                                                woolentor_custom_product_badge(); 
                                                Woolentor_Control_Sale_Badge($settings,get_the_ID());
                                            }
                                        ?>
                                        <div class="ht-product-image">
                                            <?php  if( $settings['thumbnails_style'] == 2 && $gallery_images_ids ): ?>
                                                <div class="ht-product-image-slider ht-product-image-thumbnaisl-<?php echo $tabuniqid; ?>" data-slick='{"rtl":<?php if( is_rtl() ){ echo 'true'; }else{ echo 'false'; } ?> }'>
                                                    <?php
                                                        foreach ( $gallery_images_ids as $gallery_attachment_id ) {
                                                            echo '<a href="'.esc_url( get_the_permalink() ).'" class="item">'.wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_thumbnail' ).'</a>';
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
                                                            echo '<div class="ht-product-cus-tab-pane '.$tabactive.'" id="image-'.$i.get_the_ID().'"><a href="'.esc_url( get_the_permalink() ).'">'.wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_thumbnail' ).'</a></div>';
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
                                                    <?php woocommerce_template_loop_product_thumbnail(); ?> 
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
                                                        if ( class_exists( 'YITH_WCWL' ) ) {
                                                            echo '<li>'.woolentor_add_to_wishlist_button('<i class="sli sli-heart"></i>','<i class="sli sli-heart"></i>', 'yes').'</li>';
                                                        }
                                                        if( class_exists('TInvWL_Public_AddToWishlist') ){
                                                            echo '<li>';
                                                                \TInvWL_Public_AddToWishlist::instance()->htmloutput();
                                                            echo '</li>';
                                                        }
                                                    ?>
                                                    <?php endif; ?>
                                                    <?php if( $settings['show_compare_button']!='yes'): ?>
                                                    <?php
                                                        if( function_exists('woolentor_compare_button') && class_exists('YITH_Woocompare_Frontend') ){
                                                            echo '<li>';
                                                                woolentor_compare_button(2);
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
                                                            if ( class_exists( 'YITH_WCWL' ) ) {
                                                                echo '<li>'.woolentor_add_to_wishlist_button('<i class="sli sli-heart"></i>','<i class="sli sli-heart"></i>', 'yes').'</li>';
                                                            }
                                                            if( class_exists('TInvWL_Public_AddToWishlist') ){
                                                                echo '<li>';
                                                                    \TInvWL_Public_AddToWishlist::instance()->htmloutput();
                                                                echo '</li>';
                                                            }
                                                        ?>
                                                        <?php endif; ?>
                                                        <?php if( $settings['show_compare_button']!='yes'): ?>
                                                        <?php
                                                            if( function_exists('woolentor_compare_button') && class_exists('YITH_Woocompare_Frontend') ){
                                                                echo '<li>';
                                                                    woolentor_compare_button(2);
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
                            <!--Product End-->

                        <?php endwhile; ?>
                    </div>
                </div>

                <div class="wl-shop-tab-pane <?php if( $settings['woolentor_product_view_mode'] == 'list' ){ echo 'htactive'; } ?>" id="list-<?php echo $this->get_id(); ?>">
                    <div class="ht-row">

                        <?php while( $products->have_posts() ): $products->the_post();

                            // Sale Schedule
                            $offer_start_date_timestamp = get_post_meta( get_the_ID(), '_sale_price_dates_from', true );
                            $offer_start_date = $offer_start_date_timestamp ? date_i18n( 'Y/m/d', $offer_start_date_timestamp ) : '';
                            $offer_end_date_timestamp = get_post_meta( get_the_ID(), '_sale_price_dates_to', true );
                            $offer_end_date = $offer_end_date_timestamp ? date_i18n( 'Y/m/d', $offer_end_date_timestamp ) : '';

                            // Gallery Image
                            global $product;
                            $gallery_images_ids = $product->get_gallery_image_ids() ? $product->get_gallery_image_ids() : array();
                            if ( has_post_thumbnail() ){
                                array_unshift( $gallery_images_ids, $product->get_image_id() );
                            }


                        ?>
                        <div class="ht-col-xs-12">
                            <div class="wlshop-list-wrap">
                                <div class="ht-row">
                                    
                                    <div class="ht-col-md-4 ht-col-sm-4 ht-col-xs-12 ht-product">
                                        <div class="wlproduct-list-img">
                                            <div class="ht-product-inner">

                                                <div class="ht-product-image-wrap">
                                                    <?php
                                                        if( class_exists('WooCommerce') ){ 
                                                            woolentor_custom_product_badge(); 
                                                            Woolentor_Control_Sale_Badge($settings,get_the_ID());
                                                        }
                                                    ?>
                                                    <div class="ht-product-image">
                                                        <?php  if( $settings['thumbnails_style'] == 2 && $gallery_images_ids ): ?>
                                                            <div class="ht-product-image-slider ht-product-image-thumbnaisl-<?php echo $tabuniqid; ?>" data-slick='{"rtl":<?php if( is_rtl() ){ echo 'true'; }else{ echo 'false'; } ?> }'>
                                                                <?php
                                                                    foreach ( $gallery_images_ids as $gallery_attachment_id ) {
                                                                        echo '<a href="'.esc_url( get_the_permalink() ).'" class="item">'.wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_thumbnail' ).'</a>';
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
                                                                        echo '<div class="ht-product-cus-tab-pane '.$tabactive.'" id="image-'.$i.get_the_ID().'"><a href="'.esc_url( get_the_permalink() ).'">'.wp_get_attachment_image( $gallery_attachment_id, 'woocommerce_thumbnail' ).'</a></div>';
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
                                                                <?php woocommerce_template_loop_product_thumbnail(); ?> 
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
                                                                if ( class_exists( 'YITH_WCWL' ) && function_exists('woolentor_add_to_wishlist_button')) {
                                                                    echo woolentor_add_to_wishlist_button('<i class="sli sli-heart"></i>','<i class="sli sli-heart"></i>', 'no');
                                                                }
                                                                if( class_exists('TInvWL_Public_AddToWishlist') ){
                                                                    echo '<li>';
                                                                        \TInvWL_Public_AddToWishlist::instance()->htmloutput();
                                                                    echo '</li>';
                                                                }
                                                            ?>
                                                        </li>
                                                        <li><?php if( function_exists('woolentor_compare_button') && class_exists('YITH_Woocompare_Frontend') ){ woolentor_compare_button(1); } ?></li>
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
                        <?php endwhile; ?>

                    </div>
                </div>

            </div>
            <?php else: ?>
                <?php echo '<div class="products-not-found">' . __( 'Product not found','woolentor-pro' ) . '</div>'; ?>
            <?php endif; ?>

            <script type="text/javascript">
                ;jQuery(document).ready(function($) {
                    function woolentor_tabs_pro( $tabmenus, $tabpane ){
                        $tabmenus.on('click', 'a', function(e){
                            e.preventDefault();
                            var $this = $(this),
                                $target = $this.attr('href');
                            $this.addClass('htactive').parent().siblings().children('a').removeClass('htactive');
                            $( $tabpane + $target ).addClass('htactive').siblings().removeClass('htactive');

                            // refresh slick
                            $id = $this.attr('href');
                            $($id).find('.slick-slider').slick('refresh');
                        });
                    }
                    woolentor_tabs_pro( $(".wl-shop-tab-links"), '.wl-shop-tab-pane' );
                });
            </script>

            <?php if ( Plugin::instance()->editor->is_edit_mode() ) { ?>
                <script type="text/javascript">
                    ;jQuery(document).ready(function($) {
                        'use strict';
                        $(".ht-product-image-thumbnaisl-<?php echo $tabuniqid; ?>").slick({
                            dots: true,
                            arrows: true,
                            prevArrow: '<button class="slick-prev"><i class="sli sli-arrow-left"></i></button>',
                            nextArrow: '<button class="slick-next"><i class="sli sli-arrow-right"></i></button>',
                        });
                    });
                </script>
            <?php } ?>

            <?php 
            if( $products->max_num_pages > 1 && $settings['paginate'] == 'yes' ){ woolentor_custom_pagination( $products->max_num_pages ); }
            wp_reset_query();
            wp_reset_postdata();

    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Woolentor_Custom_Product_Archive_Layout_Widget() );
<?php
namespace Elementor;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WL_Product_Cart_Table_Element extends Widget_Base {

    public function get_name() {
        return 'wl-cart-table';
    }
    
    public function get_title() {
        return __( 'WL: Cart Table', 'woolentor-pro' );
    }

    public function get_icon() {
        return 'eicon-product-breadcrumbs';
    }

    public function get_categories() {
        return array( 'woolentor-addons-pro' );
    }

    public function get_style_depends(){
        return [
            'woolentor-widgets-pro',
        ];
    }

    public function get_keywords(){
        return ['cart','table','woocommerce cart table','woocommerce cart','customize cart table'];
    }

    public function get_custom_help_url(){
        return '#';
    }

    protected function _register_controls() {

        // Cart Table Row Content
        $this->start_controls_section(
            'cart_content',
            [
                'label' => esc_html__( 'Manage Table Row', 'woolentor-pro' ),
            ]
        );
            
            $repeater = new Repeater();
            $repeater->add_control(
                'table_items',
                [
                    'label' => esc_html__( 'Table Item', 'woolentor-pro' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'remove',
                    'options' => [
                        'remove'    => esc_html__( 'Remove', 'woolentor-pro' ),
                        'thumbnail' => esc_html__( 'Image', 'woolentor-pro' ),
                        'name'      => esc_html__( 'Product Title', 'woolentor-pro' ),
                        'price'     => esc_html__( 'Price', 'woolentor-pro' ),
                        'quantity'  => esc_html__( 'Quantity', 'woolentor-pro' ),
                        'subtotal'  => esc_html__( 'Total', 'woolentor-pro' ),
                        'customadd' => esc_html__( 'Custom', 'woolentor-pro' ),
                    ],
                ]
            );

            $repeater->add_control(
                'table_heading_title', 
                [
                    'label' => esc_html__( 'Heading Title', 'woolentor-pro' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Product tilte' , 'woolentor-pro' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_responsive_control(
                'table_cell_width',
                [
                    'label' => esc_html__( 'Column Width', 'woolentor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 5,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.shop_table_responsive.cart tr td{{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .shop_table.shop_table_responsive.cart tr th{{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'table_item_list',
                [
                    'label' => __( 'Table Item List', 'woolentor-pro' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'table_items'           => 'remove',
                            'table_heading_title'   => esc_html__( 'Remove', 'woolentor-pro' ),
                        ],
                        [
                            'table_items'           => 'thumbnail',
                            'table_heading_title'   => esc_html__( 'Image', 'woolentor-pro' ),
                        ],
                        [
                            'table_items'           => 'name',
                            'table_heading_title'   => esc_html__( 'Product Title', 'woolentor-pro' ),
                        ],
                        [
                            'table_items'           => 'price',
                            'table_heading_title'   => esc_html__( 'Price', 'woolentor-pro' ),
                        ],
                        [
                            'table_items'           => 'quantity',
                            'table_heading_title'   => esc_html__( 'Quantity', 'woolentor-pro' ),
                        ],
                        [
                            'table_items'           => 'subtotal',
                            'table_heading_title'   => esc_html__( 'Total', 'woolentor-pro' ),
                        ],
                    ],
                    'title_field' => '{{{ table_heading_title }}}',
                ]
            );

        $this->end_controls_section();

        // Pricing Discount Roles
        $this->start_controls_section(
            'discount_rules',
            [
                'label' => esc_html__( 'Pricing Discount Rules', 'woolentor-pro' ),
            ]
        );
            
            $roles_fileds = new Repeater();

            $roles_fileds->add_control(
                'discount_qtn',
                [
                    'label' => esc_html__( 'Quantity', 'woolentor-pro' ),
                    'type' => Controls_Manager::NUMBER,
                ]
            );

            $roles_fileds->add_control(
                'discount_amount',
                [
                    'label' => esc_html__( 'Percent / Amount', 'woolentor-pro' ),
                    'type' => Controls_Manager::NUMBER,
                ]
            );

            $roles_fileds->add_control(
                'discount_type',
                [
                    'label' => esc_html__( 'Type', 'woolentor-pro' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'percent',
                    'options' => [
                        'percent' => esc_html__( 'Percent Of', 'woolentor-pro' ),
                        'amount'  => esc_html__( 'Amount Of', 'woolentor-pro' ),
                    ],
                ]
            );

            $this->add_control(
                'discount_rule_list',
                [
                    'label' => __( 'Discount Rules', 'woolentor-pro' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'title_field' => 'Quantity: {{{ discount_qtn }}} Amount: {{{ discount_amount }}}',
                ]
            );

        $this->end_controls_section();

        // Product Gift Roles
        $this->start_controls_section(
            'product_gift_rules',
            [
                'label' => esc_html__( 'Buy One Get One Rule', 'woolentor-pro' ),
            ]
        );
            
            $this->add_control(
                'brougth_pro_id',
                [
                    'label' => __( 'Select Bought Product', 'woolentor-pro' ),
                    'type' => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => woolentor_post_name( 'product' ),
                ]
            );
            
            $this->add_control(
                'gifted_pro_id',
                [
                    'label' => __( 'Select Gifted Product', 'woolentor-pro' ),
                    'type' => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'options' => woolentor_post_name( 'product' ),
                    'description'=>esc_html__( 'This product must be set price = 0', 'woolentor-pro' )
                ]
            );

        $this->end_controls_section();

        // Cart table Action
        $this->start_controls_section(
            'cart_table_action',
            [
                'label' => esc_html__( 'Cart Table Action', 'woolentor-pro' ),
            ]
        );
            
            $this->add_control(
                'show_update_button',
                [
                    'label'         => esc_html__( 'Update Cart', 'woolentor-pro' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Show', 'woolentor-pro' ),
                    'label_off'     => esc_html__( 'Hide', 'woolentor-pro' ),
                    'return_value'  => 'yes',
                    'default'       => 'yes',
                ]
            );

            $this->add_control(
                'update_cart_button_txt',
                [
                    'label' => __( 'Update cart button text', 'woolentor-pro' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Update cart', 'woolentor-pro' ),
                    'placeholder' => __( 'Update cart button text', 'woolentor-pro' ),
                    'condition'=>[
                        'show_update_button'=>'yes',
                    ],
                    'label_block'=>true,
                ]
            );

            $this->add_responsive_control(
                'update_cart_button_align',
                [
                    'label'        => __( 'Cart Button Alignment', 'woolentor-pro' ),
                    'type'         => Controls_Manager::CHOOSE,
                    'options'      => [
                        'left'   => [
                            'title' => __( 'Left', 'woolentor-pro' ),
                            'icon'  => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'woolentor-pro' ),
                            'icon'  => 'fa fa-align-center',
                        ],
                        'right'  => [
                            'title' => __( 'Right', 'woolentor-pro' ),
                            'icon'  => 'fa fa-align-right',
                        ],
                    ],
                    'condition'=>[
                        'show_update_button'=>'yes',
                        'show_coupon_form!'=>'yes',
                    ],
                    'default'  => 'right',
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart.wl_cart_table .actions' => 'text-align: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_control(
                'show_continue_button',
                [
                    'label'         => esc_html__( 'Continue Shopping', 'woolentor-pro' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Show', 'woolentor-pro' ),
                    'label_off'     => esc_html__( 'Hide', 'woolentor-pro' ),
                    'return_value'  => 'yes',
                    'default'       => 'no',
                    'separator'     => 'before',
                ]
            );

            $this->add_control(
                'continue_button_txt',
                [
                    'label' => __( 'Continue Shopping button text', 'woolentor-pro' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Continue Shopping', 'woolentor-pro' ),
                    'placeholder' => __( 'Continue Shopping button text', 'woolentor-pro' ),
                    'condition'=>[
                        'show_continue_button'=>'yes',
                    ],
                    'label_block'=>true,
                ]
            );

            $this->add_responsive_control(
                'continue_button_align',
                [
                    'label'        => __( 'Continue Button Alignment', 'woolentor-pro' ),
                    'type'         => Controls_Manager::CHOOSE,
                    'options'      => [
                        'left'   => [
                            'title' => __( 'Left', 'woolentor-pro' ),
                            'icon'  => 'fa fa-align-left',
                        ],
                        'right'  => [
                            'title' => __( 'Right', 'woolentor-pro' ),
                            'icon'  => 'fa fa-align-right',
                        ],
                    ],
                    'condition'=>[
                        'show_continue_button'=>'yes',
                        'show_coupon_form!'=>'yes',
                    ],
                    'default'  => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping' => 'float: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_control(
                'show_coupon_form',
                [
                    'label'         => esc_html__( 'Coupon Form', 'woolentor-pro' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Show', 'woolentor-pro' ),
                    'label_off'     => esc_html__( 'Hide', 'woolentor-pro' ),
                    'return_value'  => 'yes',
                    'default'       => 'yes',
                    'separator'     => 'before',
                ]
            );

            $this->add_control(
                'coupon_form_button_txt',
                [
                    'label' => __( 'Coupon form button text', 'woolentor-pro' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Apply coupon', 'woolentor-pro' ),
                    'placeholder' => __( 'Apply coupon button text', 'woolentor-pro' ),
                    'condition'=>[
                        'show_coupon_form'=>'yes',
                    ],
                    'label_block'=>true,
                ]
            );

            $this->add_control(
                'coupon_form_pl_txt',
                [
                    'label' => __( 'Placeholder text', 'woolentor-pro' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => __( 'Coupon code', 'woolentor-pro' ),
                    'placeholder' => __( 'Coupon code', 'woolentor-pro' ),
                    'condition'=>[
                        'show_coupon_form'=>'yes',
                    ],
                    'label_block'=>true,
                ]
            );

        $this->end_controls_section();

        // Style tab
        $this->start_controls_section(
            'cart_heading_style_section',
            [
                'label' => __( 'Heading', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            $this->add_control(
                'heading_text_color',
                [
                    'label' => __( 'Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart th' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'heading_typography',
                    'label'     => __( 'Typography', 'woolentor-pro' ),
                    'selector'  => '{{WRAPPER}} .shop_table.cart th',
                )
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'heading_border',
                    'label' => __( 'Border', 'woolentor-pro' ),
                    'selector' => '{{WRAPPER}} .shop_table.cart th',
                ]
            );

            $this->add_responsive_control(
                'heading_padding',
                [
                    'label' => __( 'Padding', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'heading_text_align',
                [
                    'label'        => __( 'Text Alignment', 'woolentor-pro' ),
                    'type'         => Controls_Manager::CHOOSE,
                    'options'      => [
                        'left'   => [
                            'title' => __( 'Left', 'woolentor-pro' ),
                            'icon'  => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'woolentor-pro' ),
                            'icon'  => 'fa fa-align-center',
                        ],
                        'right'  => [
                            'title' => __( 'Right', 'woolentor-pro' ),
                            'icon'  => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', 'woolentor-pro' ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart thead th' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'heading_background',
                    'label' => __( 'Background', 'woolentor-pro' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .shop_table.cart th',
                ]
            );

        $this->end_controls_section();

        // Cart Table Content
        $this->start_controls_section(
            'cart_content_style_section',
            [
                'label' => __( 'Table Cell', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'table_cell_border',
                    'label' => __( 'Border', 'woolentor-pro' ),
                    'selector' => '{{WRAPPER}} .shop_table.cart tr.cart_item td',
                ]
            );

            $this->add_responsive_control(
                'table_cell_padding',
                [
                    'label' => __( 'Padding', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart tr.cart_item td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'table_cell_text_align',
                [
                    'label'        => __( 'Text Alignment', 'woolentor-pro' ),
                    'type'         => Controls_Manager::CHOOSE,
                    'options'      => [
                        'left'   => [
                            'title' => __( 'Left', 'woolentor-pro' ),
                            'icon'  => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'woolentor-pro' ),
                            'icon'  => 'fa fa-align-center',
                        ],
                        'right'  => [
                            'title' => __( 'Right', 'woolentor-pro' ),
                            'icon'  => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', 'woolentor-pro' ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart tr.cart_item td' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'cart_table_background',
                    'label' => __( 'Background', 'woolentor-pro' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .shop_table.cart',
                ]
            );

        $this->end_controls_section();

        // Product Image
        $this->start_controls_section(
            'cart_product_image_style',
            array(
                'label' => __( 'Product Image', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'product_image_border',
                    'label' => __( 'Border', 'woolentor-pro' ),
                    'selector' => '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-thumbnail img',
                ]
            );

            $this->add_responsive_control(
                'product_image_border_radius',
                [
                    'label' => __( 'Border Radius', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'product_image_padding',
                [
                    'label' => __( 'Padding', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-thumbnail img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'product_image_width',
                [
                    'label' => __( 'Image Width', 'woolentor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 10,
                            'max' => 200,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 200,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 32,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-thumbnail img' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();

        // Product Title
        $this->start_controls_section(
            'cart_product_title_style',
            array(
                'label' => __( 'Product Title', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->start_controls_tabs( 'cart_item_style_tabs' );

                // Product Title Normal Style
                $this->start_controls_tab( 
                    'product_title_normal',
                    [
                        'label' => __( 'Normal', 'woolentor-pro' ),
                    ]
                );
                    
                    $this->add_control(
                        'cart_product_title_color',
                        [
                            'label' => __( 'Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-name' => 'color: {{VALUE}}',
                                '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-name a' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'cart_product_title_typography',
                            'label'     => __( 'Typography', 'woolentor-pro' ),
                            'selector'  => '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-name',
                        )
                    );

                $this->end_controls_tab();

                // Product Title Hover Style
                $this->start_controls_tab( 
                    'product_title_hover',
                    [
                        'label' => __( 'Hover', 'woolentor-pro' ),
                    ]
                );
                    
                    $this->add_control(
                        'cart_product_title_hover_color',
                        [
                            'label' => __( 'Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-name:hover' => 'color: {{VALUE}}',
                                '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-name a:hover' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        // Product Price
        $this->start_controls_section(
            'cart_product_price_style',
            array(
                'label' => __( 'Product Price', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'cart_product_price_color',
                [
                    'label' => __( 'Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-price' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-price .amount' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'cart_product_price_typography',
                    'label'     => __( 'Typography', 'woolentor-pro' ),
                    'selector'  => '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-price,{{WRAPPER}} .shop_table.cart tr.cart_item td.product-price .amount',
                )
            );

        $this->end_controls_section();

        // Product Price Total
        $this->start_controls_section(
            'cart_product_subtotal_price_style',
            array(
                'label' => __( 'Total Price', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'cart_product_subtotal_price_color',
                [
                    'label' => __( 'Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-subtotal' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'cart_product_subtotal_price_typography',
                    'label'     => __( 'Typography', 'woolentor-pro' ),
                    'selector'  => '{{WRAPPER}} .shop_table.cart tr.cart_item td.product-subtotal',
                )
            );

        $this->end_controls_section();

        // Update cart
        $this->start_controls_section(
            'cart_update_button_style',
            array(
                'label' => __( 'Update Cart Button', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'show_update_button'=>'yes',
                ],
            )
        );

            $this->start_controls_tabs( 'cart_update_style_tabs' );

                // Product Title Normal Style
                $this->start_controls_tab( 
                    'cart_update_button_normal',
                    [
                        'label' => __( 'Normal', 'woolentor-pro' ),
                    ]
                );
                    
                    $this->add_control(
                        'cart_update_button_color',
                        [
                            'label' => __( 'Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions .wl_update_cart_shop input.button' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'cart_update_button_bg_color',
                        [
                            'label' => __( 'Background Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions .wl_update_cart_shop input.button' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'cart_update_button_typography',
                            'label'     => __( 'Typography', 'woolentor-pro' ),
                            'selector'  => '{{WRAPPER}} .shop_table.cart td.actions .wl_update_cart_shop input.button',
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'cart_update_button_border',
                            'label' => __( 'Border', 'woolentor-pro' ),
                            'selector' => '{{WRAPPER}} .shop_table.cart td.actions .wl_update_cart_shop input.button',
                        ]
                    );

                    $this->add_responsive_control(
                        'cart_update_button_border_radius',
                        [
                            'label' => __( 'Border Radius', 'woolentor-pro' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions .wl_update_cart_shop input.button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'cart_update_button_padding',
                        [
                            'label' => __( 'Padding', 'woolentor-pro' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions .wl_update_cart_shop input.button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Update cart button hover style
                $this->start_controls_tab( 
                    'cart_update_button_hover',
                    [
                        'label' => __( 'Hover', 'woolentor-pro' ),
                    ]
                );
                    
                    $this->add_control(
                        'cart_update_button_hover_color',
                        [
                            'label' => __( 'Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions .wl_update_cart_shop input.button:hover' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'cart_update_button_hover_bg_color',
                        [
                            'label' => __( 'Background Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions .wl_update_cart_shop input.button:hover' => 'background-color: {{VALUE}}; transition:0.4s',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'cart_update_button_hover_border',
                            'label' => __( 'Border', 'woolentor-pro' ),
                            'selector' => '{{WRAPPER}} .shop_table.cart td.actions > input.button:hover',
                        ]
                    );

                    $this->add_responsive_control(
                        'cart_update_button_hover_border_radius',
                        [
                            'label' => __( 'Border Radius', 'woolentor-pro' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions .wl_update_cart_shop input.button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        // Continue Button Style
        $this->start_controls_section(
            'cart_continue_button_style',
            array(
                'label' => __( 'Continue Button', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'show_continue_button'=>'yes',
                ],
            )
        );

            $this->start_controls_tabs( 'cart_continue_style_tabs' );

                // Continue Button Normal Style
                $this->start_controls_tab( 
                    'cart_continue_button_normal',
                    [
                        'label' => __( 'Normal', 'woolentor-pro' ),
                    ]
                );
                    
                    $this->add_control(
                        'cart_continue_button_color',
                        [
                            'label' => __( 'Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'cart_continue_button_bg_color',
                        [
                            'label' => __( 'Background Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'cart_continue_button_typography',
                            'label'     => __( 'Typography', 'woolentor-pro' ),
                            'selector'  => '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping',
                        )
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'cart_continue_button_border',
                            'label' => __( 'Border', 'woolentor-pro' ),
                            'selector' => '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping',
                        ]
                    );

                    $this->add_responsive_control(
                        'cart_continue_button_border_radius',
                        [
                            'label' => __( 'Border Radius', 'woolentor-pro' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'cart_continue_button_padding',
                        [
                            'label' => __( 'Padding', 'woolentor-pro' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'cart_continue_button_margin',
                        [
                            'label' => __( 'Margin', 'woolentor-pro' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Cart continue Button hover style
                $this->start_controls_tab( 
                    'cart_continue_button_hover',
                    [
                        'label' => __( 'Hover', 'woolentor-pro' ),
                    ]
                );
                    
                    $this->add_control(
                        'cart_continue_button_hover_color',
                        [
                            'label' => __( 'Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping:hover' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'cart_continue_button_hover_bg_color',
                        [
                            'label' => __( 'Background Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping:hover' => 'background-color: {{VALUE}}; transition:0.4s',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'cart_continue_button_hover_border',
                            'label' => __( 'Border', 'woolentor-pro' ),
                            'selector' => '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping:hover',
                        ]
                    );

                    $this->add_responsive_control(
                        'cart_continue_button_hover_border_radius',
                        [
                            'label' => __( 'Border Radius', 'woolentor-pro' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%' ],
                            'selectors' => [
                                '{{WRAPPER}} .shop_table.cart td.actions a.wlbutton-continue-shopping:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

        // Apply coupon
        $this->start_controls_section(
            'cart_coupon_style',
            array(
                'label' => __( 'Apply coupon', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'show_coupon_form'=>'yes',
                ],
            )
        );

            $this->add_control(
                'cart_coupon_button_heading',
                [
                    'label' => __( 'Button', 'woolentor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'cart_coupon_button_typography',
                    'label'     => __( 'Typography', 'woolentor-pro' ),
                    'selector'  => '{{WRAPPER}} .shop_table.cart td.actions .coupon .button',
                )
            );

            $this->add_control(
                'cart_coupon_button_color',
                [
                    'label' => __( 'Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart td.actions .coupon .button' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'cart_coupon_button_bg_color',
                [
                    'label' => __( 'Background Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart td.actions .coupon .button' => 'background-color: {{VALUE}}; transition:0.4s',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'cart_coupon_button_border',
                    'label' => __( 'Border', 'woolentor-pro' ),
                    'selector' => '{{WRAPPER}} .shop_table.cart td.actions .coupon .button',
                ]
            );

            $this->add_responsive_control(
                'cart_coupon_button_border_radius',
                [
                    'label' => __( 'Border Radius', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart td.actions .coupon .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );


            $this->add_control(
                'cart_coupon_button_hover_color',
                [
                    'label' => __( 'Hover Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart td.actions .coupon .button:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'cart_coupon_button_hover_bg_color',
                [
                    'label' => __( 'Hover Background Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart td.actions .coupon .button:hover' => 'background-color: {{VALUE}}; transition:0.4s',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'cart_coupon_hover_button_border',
                    'label' => __( 'Border', 'woolentor-pro' ),
                    'selector' => '{{WRAPPER}} .shop_table.cart td.actions .coupon .button:hover',
                ]
            );

            $this->add_control(
                'cart_coupon_inputbox_heading',
                [
                    'label' => __( 'Input Box', 'woolentor-pro' ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'after',
                ]
            );

            $this->add_control(
                'cart_coupon_inputbox_color',
                [
                    'label' => __( 'Input Box Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart td.actions .coupon input.input-text' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'cart_coupon_inputbox_typography',
                    'label'     => __( 'Typography', 'woolentor-pro' ),
                    'selector'  => '{{WRAPPER}} .shop_table.cart td.actions .coupon input.input-text',
                )
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'cart_coupon_inputbox_border',
                    'label' => __( 'Border', 'woolentor-pro' ),
                    'selector' => '{{WRAPPER}} .shop_table.cart td.actions .coupon input.input-text',
                ]
            );

            $this->add_responsive_control(
                'cart_coupon_inputbox_border_radius',
                [
                    'label' => __( 'Border Radius', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart td.actions .coupon input.input-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'cart_coupon_inputbox_padding',
                [
                    'label' => __( 'Padding', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart td.actions .coupon input.input-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'cart_coupon_inputbox_width',
                [
                    'label' => __( 'Input Box Width', 'woolentor-pro' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 10,
                            'max' => 200,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 200,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 100,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .shop_table.cart td.actions .coupon input.input-text' => 'width: {{SIZE}}{{UNIT}} !important;',
                    ],
                ]
            );

        $this->end_controls_section();

    }

    protected function render() {
        $settings  = $this->get_settings_for_display();

        $table_items = ( isset( $settings['table_item_list'] ) ? $settings['table_item_list'] : array() );

        // Cart Option
        $cart_table_opt = array(
            'update_cart_button' => array(
                'enable'    => $settings['show_update_button'],
                'button_txt'=> $settings['update_cart_button_txt'],
            ),
            'continue_shop_button'=> array(
                'enable'    => $settings['show_continue_button'],
                'button_txt'=> $settings['continue_button_txt'],
            ),
            'coupon_form' => array(
                'enable'        => $settings['show_coupon_form'],
                'button_txt'    => $settings['coupon_form_button_txt'],
                'placeholder'   => $settings['coupon_form_pl_txt'],
            ),
        );

        $by_one_get_one = [
            'bought_id' => !empty( $settings['brougth_pro_id'] ) ? $settings['brougth_pro_id'] : '',
            'gifted_id' => !empty( $settings['gifted_pro_id'] ) ? $settings['gifted_pro_id'] : ''
        ];

        if( class_exists('\WC_Shortcode_Cart') ){
            WooLentor_Shortcode_Cart::byOneGetone( $by_one_get_one );
            add_action( 'woocommerce_before_calculate_totals', [ $this, 'quantity_based_pricing' ], 9999 );
            WooLentor_Shortcode_Cart::output( $atts = array(), $table_items, $cart_table_opt );
        }
        
    }

    public function quantity_based_pricing( $cart ) {

        if ( is_admin() && !defined( 'DOING_AJAX' ) ) return;

        $discount_rule_list = $this->get_settings_for_display('discount_rule_list');

        if( isset( $discount_rule_list ) && is_array( $discount_rule_list ) ){
            foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
                $cart_item['data']->set_price( $this->apply_discount( $discount_rule_list, $cart_item ) );
            }
        }
        
    }

    /**
     * [apply_discount]
     * @param  [array] $threshold Discount data array
     * @param  [array] $cart_item cart data
     * @return [int]   price
     */
    public function apply_discount( $threshold, $cart_item ){

        $pre_price = $price = $cart_item['data']->get_price();
        foreach ( $threshold as $key => $data ) {
            if( $cart_item['quantity'] >= $data['discount_qtn'] && !empty( $data['discount_amount'] ) ){
                if( $data['discount_type'] === 'amount' ){
                    $price = $pre_price - ( $data['discount_amount'] / $cart_item['quantity'] );
                }else{
                    $price = round( $pre_price * ( 1 - ( $data['discount_amount'] / 100 ) ), 2 );
                }
            }
        }
        return $price;

    }


}

Plugin::instance()->widgets_manager->register_widget_type( new WL_Product_Cart_Table_Element() );


/**
 * Cart Shortcode
 *
 * Used on the cart page, the cart shortcode displays the cart contents and interface for coupon codes and other cart bits and pieces.
 *
 * @package WooCommerce/Shortcodes/Cart
 * @version 2.3.0
 */
if( class_exists('\WC_Shortcode_Cart') ){
    class WooLentor_Shortcode_Cart extends \WC_Shortcode_Cart{
        /**
         * Output the cart shortcode.
         */
        public static function output( $atts = '', $cartitem = [], $cartopt = [] ) {
            // Constants.
            wc_maybe_define_constant( 'WOOCOMMERCE_CART', true );

            $atts        = shortcode_atts( array(), $atts, 'woocommerce_cart' );
            $nonce_value = wc_get_var( $_REQUEST['woocommerce-shipping-calculator-nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) ); // @codingStandardsIgnoreLine.

            // Update Shipping. Nonce check uses new value and old value (woocommerce-cart). @todo remove in 4.0.
            if ( ! empty( $_POST['calc_shipping'] ) && ( wp_verify_nonce( $nonce_value, 'woocommerce-shipping-calculator' ) || wp_verify_nonce( $nonce_value, 'woocommerce-cart' ) ) ) { // WPCS: input var ok.
                
                //self::calculate_shipping();

                // Also calc totals before we check items so subtotals etc are up to date.
                \WC()->cart->calculate_totals();
            }

            // Check cart items are valid.
            do_action( 'woocommerce_check_cart_items' );

            // Calc totals.
            \WC()->cart->calculate_totals();

            if ( \WC()->cart->is_empty() ) {
                wc_get_template( 'cart/cart-empty.php');
            } else {
                if( file_exists( WOOLENTOR_ADDONS_PL_PATH_PRO . 'wl-woo-templates/cart/cart-table.php' ) ){
                    include WOOLENTOR_ADDONS_PL_PATH_PRO . 'wl-woo-templates/cart/cart-table.php';
                }
            }

        }

        // By One get one apply
        public static function byOneGetone( $by_one_get_one ){

            $product_bought_id = !empty( $by_one_get_one['bought_id'] ) ? $by_one_get_one['bought_id'] : '';
            $product_gifted_id = !empty( $by_one_get_one['gifted_id'] ) ? $by_one_get_one['gifted_id'] : '';

            if( !empty( $product_gifted_id ) ){

                // see if product id in cart
                $product_bought_cart_id = \WC()->cart->generate_cart_id( $product_bought_id );
                $product_bought_in_cart = \WC()->cart->find_product_in_cart( $product_bought_cart_id );

                // see if gift id in cart
                $product_gifted_cart_id = \WC()->cart->generate_cart_id( $product_gifted_id );
                $product_gifted_in_cart = \WC()->cart->find_product_in_cart( $product_gifted_cart_id );


                // if not in cart remove gift, else add gift
                if ( ! $product_bought_in_cart ) {
                    if ( $product_gifted_in_cart ) \WC()->cart->remove_cart_item( $product_gifted_in_cart );
                } else {
                    if ( ! $product_gifted_in_cart ) \WC()->cart->add_to_cart( $product_gifted_id );
                }

            }

        }


    }
}
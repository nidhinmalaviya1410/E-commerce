<?php
namespace Elementor;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WL_Checkout_Payment_Element extends Widget_Base {

    public function get_name() {
        return 'wl-checkout-payment-method';
    }
    
    public function get_title() {
        return __( 'WL: Checkout Payment Method', 'woolentor-pro' );
    }

    public function get_icon() {
        return 'eicon-woocommerce';
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
        return ['checkout payment','payment method' ];
    }

    protected function _register_controls() {

        // Payment
        $this->start_controls_section(
            'checkout_payment_style',
            array(
                'label' => __( 'Payment', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'checkout_payment_typography',
                    'label'     => __( 'Typography', 'woolentor-pro' ),
                    'selector'  => '{{WRAPPER}} #payment',
                )
            );

            $this->add_control(
                'checkout_payment_color',
                [
                    'label' => __( 'Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} #payment' => 'color: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();

        // Payment Method Heading
        $this->start_controls_section(
            'checkout_heading_style',
            array(
                'label' => __( 'Payment Heading', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'checkout_payment_heading_typography',
                    'label'     => __( 'Typography', 'woolentor-pro' ),
                    'selector'  => '{{WRAPPER}} #payment .wc_payment_method label',
                )
            );

            $this->add_control(
                'checkout_payment_heading_color',
                [
                    'label' => __( 'Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} #payment .wc_payment_method label' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'checkout_payment_heading_border',
                    'label' => __( 'Border', 'woolentor-pro' ),
                    'selector' => '{{WRAPPER}} #payment ul.payment_methods.methods li',
                ]
            );

            $this->add_responsive_control(
                'checkout_payment_heading_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} #payment ul.payment_methods.methods li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'checkout_payment_heading_padding',
                [
                    'label' => __( 'Padding', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} #payment ul.payment_methods.methods li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'checkout_payment_heading_margin',
                [
                    'label' => __( 'Margin', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} #payment ul.payment_methods.methods li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} #payment .wc_payment_method label' => 'margin: 0;',
                    ],
                ]
            );

            $this->add_responsive_control(
                'checkout_payment_heading_align',
                [
                    'label'        => __( 'Alignment', 'woolentor-pro' ),
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
                    'default'   => 'left',
                    'selectors' => [
                        '{{WRAPPER}} #payment ul.payment_methods.methods li' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'checkout_payment_heading_background_color',
                [
                    'label' => __( 'Background Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} #payment ul.payment_methods.methods li' => 'background-color: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();

        // Payment Content
        $this->start_controls_section(
            'checkout_payment_content_style',
            array(
                'label' => __( 'Content', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'checkout_payment_content_typography',
                    'label'     => __( 'Typography', 'woolentor-pro' ),
                    'selector'  => '{{WRAPPER}} #payment .payment_box',
                )
            );

            $this->add_control(
                'checkout_payment_content_color',
                [
                    'label' => __( 'Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} #payment .payment_box' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'checkout_payment_content_padding',
                [
                    'label' => esc_html__( 'Padding', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} #payment .payment_box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'checkout_payment_content_bg_color',
                [
                    'label' => __( 'Background Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} #payment .payment_box' => 'background-color: {{VALUE}}',
                        '{{WRAPPER}} #payment div.payment_box::before, {{WRAPPER}} #payment div.payment_box::before' => 'border-color:transparent transparent {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'checkout_payment_content_border',
                    'label' => __( 'Border', 'woolentor-pro' ),
                    'selector' => '{{WRAPPER}} #payment .payment_box',
                ]
            );

            $this->add_responsive_control(
                'checkout_payment_content_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} #payment .payment_box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();

        // Payment Place Order Button
        $this->start_controls_section(
            'checkout_payment_place_order_style',
            array(
                'label' => __( 'Place Order Button', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->start_controls_tabs('checkout_payment_place_order_style_tabs');
                
                // Plece order button normal
                $this->start_controls_tab(
                    'checkout_payment_place_order_normal_tab',
                    [
                        'label' => __( 'Normal', 'woolentor-pro' ),
                    ]
                );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        array(
                            'name'      => 'checkout_payment_place_order_typography',
                            'label'     => __( 'Typography', 'woolentor-pro' ),
                            'selector'  => '{{WRAPPER}} #payment #place_order',
                        )
                    );

                    $this->add_control(
                        'checkout_payment_place_order_color',
                        [
                            'label' => __( 'Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} #payment #place_order' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_control(
                        'checkout_payment_place_order_bg_color',
                        [
                            'label' => __( 'Background Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} #payment #place_order' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'checkout_payment_place_order_padding',
                        [
                            'label' => esc_html__( 'Padding', 'woolentor-pro' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} #payment #place_order' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' => 'before',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'checkout_payment_place_order_border',
                            'label' => __( 'Border', 'woolentor-pro' ),
                            'selector' => '{{WRAPPER}} #payment #place_order',
                        ]
                    );

                    $this->add_responsive_control(
                        'checkout_payment_place_order_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'woolentor-pro' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', 'em', '%'],
                            'selectors' => [
                                '{{WRAPPER}} #payment #place_order' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                $this->end_controls_tab();

                // Plece order button hover
                $this->start_controls_tab(
                    'checkout_payment_place_order_hover_tab',
                    [
                        'label' => __( 'Hover', 'woolentor-pro' ),
                    ]
                );
                    
                    $this->add_control(
                        'checkout_payment_place_order_hover_color',
                        [
                            'label' => __( 'Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} #payment #place_order:hover' => 'color: {{VALUE}}; transition:0.4s;',
                            ],
                        ]
                    );

                    $this->add_control(
                        'checkout_payment_place_order_hover_bg_color',
                        [
                            'label' => __( 'Background Color', 'woolentor-pro' ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} #payment #place_order:hover' => 'background-color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'checkout_payment_place_order_hover_border',
                            'label' => __( 'Border', 'woolentor-pro' ),
                            'selector' => '{{WRAPPER}} #payment #place_order:hover',
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        if ( Plugin::instance()->editor->is_edit_mode() ) {
            woocommerce_checkout_payment();
        }else{
            if( is_checkout() ){
                woocommerce_checkout_payment();
            }
        }
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new WL_Checkout_Payment_Element() );
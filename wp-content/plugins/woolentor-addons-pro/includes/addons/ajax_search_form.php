<?php
namespace Elementor;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WL_Ajax_Search_Form_Element extends Widget_Base {

    public function get_name() {
        return 'wl-ajax-search-form';
    }
    
    public function get_title() {
        return __( 'WL: Ajax Product Search Form', 'woolentor-pro' );
    }

    public function get_icon() {
        return 'eicon-site-search';
    }

    public function get_categories() {
        return array( 'woolentor-addons-pro' );
    }

    public function get_style_depends(){
        return [
            'woolentor-ajax-search',
        ];
    }

    public function get_script_depends(){
        return [
            'woolentor-ajax-search',
        ];
    }

    public function get_keywords(){
        return ['search','search form','product search','live search','ajax search','ajax search form','product ajax search'];
    }

    protected function _register_controls() {

        // Content Start
        $this->start_controls_section(
            'woolentor-ajax-search-form',
            [
                'label' => esc_html__( 'Search Form', 'woolentor-pro' ),
            ]
        );
            
            $this->add_control(
                'limit',
                [
                    'label' => __( 'Show Number of Product', 'woolentor-pro' ),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 100,
                    'step' => 1,
                    'default' => 10,
                ]
            );

            $this->add_control(
                'placeholder_text',
                [
                    'label'     => __( 'Placeholder Text', 'woolentor-pro' ),
                    'type'      => Controls_Manager::TEXT,
                    'default'   => __( 'Search Products', 'woolentor-pro' ),
                ]
            );

        $this->end_controls_section();
        // Content end

        // Style tab section
        $this->start_controls_section(
            'search_form_input',
            [
                'label' => __( 'Input Box', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_control(
                'search_form_input_text_color',
                [
                    'label'     => __( 'Text Color', 'woolentor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woolentor_widget_psa input[type="search"]'   => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'search_form_input_placeholder_color',
                [
                    'label'     => __( 'Placeholder Color', 'woolentor-pro' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woolentor_widget_psa input[type*="search"]::-webkit-input-placeholder' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .woolentor_widget_psa input[type*="search"]::-moz-placeholder'  => 'color: {{VALUE}};',
                        '{{WRAPPER}} .woolentor_widget_psa input[type*="search"]:-ms-input-placeholder'  => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'search_form_input_typography',
                    'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .woolentor_widget_psa input[type="search"]',
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'search_form_input_background',
                    'label' => __( 'Background', 'woolentor-pro' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .woolentor_widget_psa input[type="search"]',
                ]
            );

            $this->add_responsive_control(
                'search_form_input_margin',
                [
                    'label' => __( 'Margin', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .woolentor_widget_psa' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'search_form_input_padding',
                [
                    'label' => __( 'Padding', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .woolentor_widget_psa input[type="search"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'search_form_input_height',
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
                        'size' => 43,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .woolentor_widget_psa input[type="search"]' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'search_form_input_border',
                    'label' => __( 'Border', 'woolentor-pro' ),
                    'selector' => '{{WRAPPER}} .woolentor_widget_psa input[type="search"]',
                    'separator' =>'before',
                ]
            );

            $this->add_responsive_control(
                'search_form_input_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .woolentor_widget_psa input[type="search"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                ]
            );

        $this->end_controls_section();

        // Submit Button
        $this->start_controls_section(
            'search_form_style_submit_button',
            [
                'label' => __( 'Button', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            // Button Tabs Start
            $this->start_controls_tabs('search_form_style_submit_tabs');

                // Start Normal Submit button tab
                $this->start_controls_tab(
                    'search_form_style_submit_normal_tab',
                    [
                        'label' => __( 'Normal', 'woolentor-pro' ),
                    ]
                );
                    
                    $this->add_control(
                        'search_form_submitbutton_text_color',
                        [
                            'label'     => __( 'Color', 'woolentor-pro' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .woolentor_widget_psa button'   => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'search_form_submitbutton_typography',
                            'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                            'selector' => '{{WRAPPER}} .woolentor_widget_psa button',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'search_form_submitbutton_background',
                            'label' => __( 'Background', 'woolentor-pro' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .woolentor_widget_psa button',
                        ]
                    );

                    $this->add_responsive_control(
                        'search_form_submitbutton_padding',
                        [
                            'label' => __( 'Padding', 'woolentor-pro' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .woolentor_widget_psa button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_control(
                        'search_form_submitbutton_height',
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
                                'size' => 40,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .woolentor_widget_psa button' => 'height: {{SIZE}}{{UNIT}};',
                            ],
                            'separator' =>'before',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'search_form_submitbutton_border',
                            'label' => __( 'Border', 'woolentor-pro' ),
                            'selector' => '{{WRAPPER}} .woolentor_widget_psa button',
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'search_form_submitbutton_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'woolentor-pro' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .woolentor_widget_psa button' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Normal submit Button tab end

                // Start Hover Submit button tab
                $this->start_controls_tab(
                    'search_form_style_submit_hover_tab',
                    [
                        'label' => __( 'Hover', 'woolentor-pro' ),
                    ]
                );
                    
                    $this->add_control(
                        'search_form_submitbutton_hover_text_color',
                        [
                            'label'     => __( 'Color', 'woolentor-pro' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .woolentor_widget_psa button:hover'   => 'color: {{VALUE}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Background::get_type(),
                        [
                            'name' => 'search_form_submitbutton_hover_background',
                            'label' => __( 'Background', 'woolentor-pro' ),
                            'types' => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .woolentor_widget_psa button:hover',
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'search_form_submitbutton_hover_border',
                            'label' => __( 'Border', 'woolentor-pro' ),
                            'selector' => '{{WRAPPER}} .woolentor_widget_psa button:hover',
                            'separator' =>'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'search_form_submitbutton_hover_border_radius',
                        [
                            'label' => esc_html__( 'Border Radius', 'woolentor-pro' ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'selectors' => [
                                '{{WRAPPER}} .woolentor_widget_psa button:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                            ],
                        ]
                    );

                $this->end_controls_tab(); // Hover Submit Button tab End

            $this->end_controls_tabs(); // Button Tabs End

        $this->end_controls_section();


    }

    protected function render() {

        $settings  = $this->get_settings_for_display();
        $shortcode_atts = [
            'limit'         => 'limit="'.$settings[ 'limit' ].'"',
            'placeholder'   => 'placeholder="'.$settings[ 'placeholder_text' ].'"',
        ];
        echo do_shortcode( sprintf( '[woolentorsearch %s]', implode(' ', $shortcode_atts ) ) );
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new WL_Ajax_Search_Form_Element() );
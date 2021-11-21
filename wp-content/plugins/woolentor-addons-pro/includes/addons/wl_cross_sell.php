<?php
namespace Elementor;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WL_Product_Cross_Sell_Element extends Widget_Base {

    public function get_name() {
        return 'wl-cross-sell';
    }
    
    public function get_title() {
        return __( 'WL: Cross Sell', 'woolentor-pro' );
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
        return ['cross sell','cross sell product','cross'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_cross_sells',
            [
                'label' => __( 'Cross Sells', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        
            $this->add_control(
                'limit',
                [
                    'label' => __( 'Limit', 'woolentor-pro' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 2,
                    'min' => 1,
                    'max' => 16,
                ]
            );
            
            $this->add_responsive_control(
                'columns',
                [
                    'label' => __( 'Columns', 'woolentor-pro' ),
                    'type' => Controls_Manager::NUMBER,
                    'prefix_class' => 'elementor-products-columns%s-',
                    'default' => 2,
                    'min' => 1,
                    'max' => 16,
                ]
            );
            
            $this->add_control(
                'orderby',
                [
                    'label' => __( 'Orderby', 'woolentor-pro' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'rand',
                    'options' => [
                        'rand' => __( 'Random', 'woolentor-pro' ),
                        'date' => __( 'Publish Date', 'woolentor-pro' ),
                        'modified' => __( 'Modified Date', 'woolentor-pro' ),
                        'title' => __( 'Alphabetic', 'woolentor-pro' ),
                        'popularity' => __( 'Popularity', 'woolentor-pro' ),
                        'rating' => __( 'Rate', 'woolentor-pro' ),
                        'price' => __( 'Price', 'woolentor-pro' ),
                    ],
                ]
            );
            
            $this->add_control(
                'order',
                [
                    'label' => __( 'Order', 'woolentor-pro' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'desc',
                    'options' => [
                        'desc' => __( 'DESC', 'woolentor-pro' ),
                        'asc' => __( 'ASC', 'woolentor-pro' ),
                    ],
                ]
            );
        
        $this->end_controls_section();

        // Heading
        $this->start_controls_section(
            'cross_sell_heading_style',
            array(
                'label' => __( 'Heading', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'cross_sell_heading_typography',
                    'label'     => __( 'Typography', 'woolentor-pro' ),
                    'selector'  => '{{WRAPPER}} .cross-sells > h2',
                )
            );

            $this->add_control(
                'cross_sell_heading_color',
                [
                    'label' => __( 'Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cross-sells > h2' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'cross_sell_heading_margin',
                [
                    'label' => __( 'Margin', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .cross-sells > h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'cross_sell_heading_align',
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
                    'prefix_class' => 'elementor%s-align-',
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .cross-sells > h2' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        woocommerce_cross_sell_display( $settings['limit'], $settings['columns'], $settings['orderby'], $settings['order'] );
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new WL_Product_Cross_Sell_Element() );
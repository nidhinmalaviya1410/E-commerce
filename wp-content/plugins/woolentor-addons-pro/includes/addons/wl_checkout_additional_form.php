<?php
namespace Elementor;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WL_Checkout_Additional_Form_Element extends Widget_Base {

    public function get_name() {
        return 'wl-checkout-additional-form';
    }
    
    public function get_title() {
        return __( 'WL: Checkout Additional info Form', 'woolentor-pro' );
    }

    public function get_icon() {
        return ' eicon-form-horizontal';
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
        return ['checkout form','additional form','additional field','checkout'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_additional_content',
            [
                'label' => esc_html__( 'Additional Form', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
            
            $this->add_control(
                'form_title',
                [
                    'label' => esc_html__( 'Title', 'woolentor-pro' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Additional information', 'woolentor-pro' ),
                    'placeholder' => esc_html__( 'Type your title here', 'woolentor-pro' ),
                    'label_block' => true,
                ]
            );

        $this->end_controls_section();

        // Manage Additional Field
        $this->start_controls_section(
            'section_additional_fields',
            [
                'label' => esc_html__( 'Manage Field', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
            
            $this->add_control(
                'important_note',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<div style="color:#F64444;line-height:18px;">After editing these fields, update this template, reload this template and check your real checkout page from your website.</div>',
                    'content_classes' => 'wlnotice-imp',
                ]
            );
            $this->add_control(
                'modify_field',
                [
                    'label' => esc_html__( 'Modify Field', 'woolentor-pro' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__( 'Yes', 'woolentor-pro' ),
                    'label_off' => esc_html__( 'No', 'woolentor-pro' ),
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $repeater = new Repeater();

            $repeater->add_control(
                'field_key',
                [
                    'label' => esc_html__( 'Field name', 'woolentor-pro' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'order_comments',
                    'options' => [
                        'order_comments'=> esc_html__( 'Order Notes', 'woolentor-pro' ),
                        'customadd' => esc_html__( 'Add Custom', 'woolentor-pro' ),
                    ],
                ]
            );

            $repeater->add_control(
                'field_label', 
                [
                    'label' => esc_html__( 'Label', 'woolentor-pro' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Custom Field name' , 'woolentor-pro' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'field_placeholder', 
                [
                    'label' => esc_html__( 'Placeholder', 'woolentor-pro' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Custom Field name' , 'woolentor-pro' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'field_default_value', 
                [
                    'label' => esc_html__( 'Default Value', 'woolentor-pro' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Custom Field name' , 'woolentor-pro' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'field_validation',
                [
                    'label' => esc_html__( 'Validation', 'woolentor-pro' ),
                    'type' => Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options' => [
                        'email'     => esc_html__( 'Email', 'woolentor-pro' ),
                        'phone'     => esc_html__( 'Phone', 'woolentor-pro' ),
                        'postcode'  => esc_html__( 'Postcode', 'woolentor-pro' ),
                        'state'     => esc_html__( 'State', 'woolentor-pro' ),
                        'number'    => esc_html__( 'Number', 'woolentor-pro' ),
                    ],
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'field_class', 
                [
                    'label' => esc_html__( 'Class', 'woolentor-pro' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'notes' , 'woolentor-pro' ),
                    'description' => esc_html__( 'You can use ( form-row-first,form-row-last,form-row-wide,notes )' , 'woolentor-pro' ),
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'field_key_custom', 
                [
                    'label' => esc_html__( 'Custom key', 'woolentor-pro' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'customkey' , 'woolentor-pro' ),
                    'label_block' => true,
                    'condition'=>[
                        'field_key'=>'customadd',
                    ],
                ]
            );

            $repeater->add_control(
                'field_type',
                [
                    'label' => __( 'Field Type', 'woolentor-pro' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'textarea',
                    'options' => [
                        'text'      => esc_html__( 'Text', 'woolentor-pro' ),
                        'password'  => esc_html__( 'Password', 'woolentor-pro' ),
                        'email'     => esc_html__( 'Email', 'woolentor-pro' ),
                        'tel'       => esc_html__( 'Tel', 'woolentor-pro' ),
                        'textarea'  => esc_html__( 'Textarea', 'woolentor-pro' ),
                        'select'    => esc_html__( 'Select', 'woolentor-pro' ),
                        'radio'     => esc_html__( 'Radio', 'woolentor-pro' ),
                    ],
                    'condition'=>[
                        'field_key'=>'customadd',
                    ],
                ]
            );

            $repeater->add_control(
                'field_options',
                [
                    'label' => esc_html__( 'Options', 'woolentor-pro' ),
                    'type' => Controls_Manager::TEXTAREA,
                    'rows' => 5,
                    'placeholder' => esc_html__( 'Value, Text','woolentor-pro' ),
                    'condition'=>[
                        'field_type' => array( 'radio','select' ),
                    ],
                ]
            );

            $repeater->add_control(
                'field_required',
                [
                    'label'         => esc_html__( 'Required', 'woolentor-pro' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Yes', 'woolentor-pro' ),
                    'label_off'     => esc_html__( 'No', 'woolentor-pro' ),
                    'return_value'  => true,
                    'default'       => false,
                ]
            );

            $repeater->add_control(
                'field_show_email',
                [
                    'label'         => esc_html__( 'Show in Email', 'woolentor-pro' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Yes', 'woolentor-pro' ),
                    'label_off'     => esc_html__( 'No', 'woolentor-pro' ),
                    'return_value'  => true,
                    'default'       => true,
                    'condition'=>[
                        'field_key'=>'customadd',
                    ],
                ]
            );

            $repeater->add_control(
                'field_show_order',
                [
                    'label'         => esc_html__( 'Show in Order Detail Page', 'woolentor-pro' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'label_on'      => esc_html__( 'Yes', 'woolentor-pro' ),
                    'label_off'     => esc_html__( 'No', 'woolentor-pro' ),
                    'return_value'  => true,
                    'default'       => true,
                    'condition'=>[
                        'field_key'=>'customadd',
                    ],
                ]
            );

            $this->add_control(
                'field_list',
                [
                    'label' => __( 'Field List', 'woolentor-pro' ),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'condition'=>[
                        'modify_field'=>'yes',
                    ],
                    'default' => [
                        [
                            'field_key'             => 'order_comments',
                            'field_label'           => esc_html__( 'Order Notes', 'woolentor-pro' ),
                            'field_placeholder'     => 'Notes about your order, e.g. special notes for delivery.',
                            'field_default_value'   => '',
                            'field_validation'      => '',
                            'field_class'           => 'notes',
                            'field_required'        => false,
                        ],

                    ],
                    'title_field' => '{{{ field_label }}}',
                ]
            );

        $this->end_controls_section();

        // Heading
        $this->start_controls_section(
            'form_heading_style',
            array(
                'label' => __( 'Heading', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'form_heading_typography',
                    'label'     => __( 'Typography', 'woolentor-pro' ),
                    'selector'  => '{{WRAPPER}} .woocommerce-additional-fields > h3',
                )
            );

            $this->add_control(
                'form_heading_color',
                [
                    'label' => __( 'Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-additional-fields > h3' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'form_heading_margin',
                [
                    'label' => __( 'Margin', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-additional-fields > h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'form_heading_align',
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
                        '{{WRAPPER}} .woocommerce-additional-fields > h3' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();

        // Form label
        $this->start_controls_section(
            'form_label_style',
            array(
                'label' => __( 'Label', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'form_label_typography',
                    'label'     => __( 'Typography', 'woolentor-pro' ),
                    'selector'  => '{{WRAPPER}} .woocommerce-additional-fields .form-row label',
                )
            );

            $this->add_control(
                'form_label_color',
                [
                    'label' => __( 'Label Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-additional-fields .form-row label' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_responsive_control(
                'form_label_padding',
                [
                    'label' => esc_html__( 'Margin', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-additional-fields .form-row label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'form_label_align',
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
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-additional-fields .form-row label' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();

        // Input box
        $this->start_controls_section(
            'form_input_box_style',
            array(
                'label' => esc_html__( 'Input Box', 'woolentor-pros' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            $this->add_control(
                'form_input_box_text_color',
                [
                    'label' => __( 'Text Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-additional-fields input , {{WRAPPER}} .woocommerce-additional-fields textarea' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'form_input_box_typography',
                    'label'     => esc_html__( 'Typography', 'woolentor-pro' ),
                    'selector'  => '{{WRAPPER}} .woocommerce-additional-fields input , {{WRAPPER}} .woocommerce-additional-fields textarea',
                )
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'form_input_box_border',
                    'label' => __( 'Border', 'woolentor-pro' ),
                    'selector' => '{{WRAPPER}} .woocommerce-additional-fields input , {{WRAPPER}} .woocommerce-additional-fields textarea',
                ]
            );

            $this->add_responsive_control(
                'form_input_box_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-additional-fields input , {{WRAPPER}} .woocommerce-additional-fields textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
            $this->add_responsive_control(
                'form_input_box_padding',
                [
                    'label' => esc_html__( 'Padding', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-additional-fields input , {{WRAPPER}} .woocommerce-additional-fields textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );
            
            $this->add_responsive_control(
                'form_input_box_margin',
                [
                    'label' => esc_html__( 'Margin', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-additional-fields input , {{WRAPPER}} .woocommerce-additional-fields textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();
        $field_list = $this->get_settings_for_display( 'field_list' );

        $items = array();

        if( $settings['modify_field'] == 'yes' ){
            if( isset( $field_list ) ){

                $priority = 0;

                foreach ( $field_list as $key => $field ) {

                    $fkey = 'additional_'.$field['field_key'];

                    if( $field['field_key'] == 'customadd' ){
                        $fkey = 'additional_'.$field['field_key_custom'];
                    }
                    $items[$fkey] = array(
                        'label'       => $field['field_label'],
                        'required'    => ( $field['field_required'] == true ? $field['field_required'] : false ),
                        'class'       => array( $field['field_class'] ),
                        'default'     => $field['field_default_value'],
                        'placeholder' => $field['field_placeholder'],
                        'validate'    => $field['field_validation'],
                        'priority'    => $priority+10,
                    );

                    if( $field['field_key'] == 'customadd' ){
                        $items[$fkey]['custom']         = true;
                        $items[$fkey]['type']           = $field['field_type'];
                        $items[$fkey]['show_in_email']  = $field['field_show_email'];
                        $items[$fkey]['show_in_order']  = $field['field_show_order'];
                        $items[$fkey]['options']        = isset( $field['field_options'] ) ? $field['field_options'] : '';
                    }
                    $priority = $priority+10;
                }
            }

            if( !empty( get_option( 'woolentor_wc_fields_additional' ) ) || get_option( 'woolentor_wc_fields_additional' ) ){
                update_option( 'woolentor_wc_fields_additional', $items );
            }else{
                add_option( 'woolentor_wc_fields_additional', $items );
            }
            
        }else{
            delete_option( 'woolentor_wc_fields_additional' );
        }

        $checkout = WC()->checkout();
        if ( sizeof( $checkout->checkout_fields ) > 0 ) { ?>
            <div class="woocommerce-additional-fields">
                <?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>
            
                <?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

                    <?php
                        if( !empty( $settings['form_title'] ) ){
                            echo '<h3>'.esc_html__( $settings['form_title'], 'woolentor-pro' ).'</h3>';
                        }
                    ?>
                    <div class="woocommerce-additional-fields__field-wrapper">
                        <?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
                            <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
                        <?php endforeach; ?>
                    </div>
            
                <?php endif; ?>
            
                <?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
            </div>
        <?php
        }
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new WL_Checkout_Additional_Form_Element() );
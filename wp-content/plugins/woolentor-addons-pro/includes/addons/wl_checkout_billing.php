<?php
namespace Elementor;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WL_Checkout_Billing_Form_Element extends Widget_Base {

    public function get_name() {
        return 'wl-checkout-billing-form';
    }
    
    public function get_title() {
        return __( 'WL: Checkout Billing Form', 'woolentor-pro' );
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
        return ['checkout form','billing form','billing field','checkout'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_billing_content',
            [
                'label' => esc_html__( 'Billing Form', 'woolentor-pro' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
            
            $this->add_control(
                'form_title',
                [
                    'label' => esc_html__( 'Title', 'woolentor-pro' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Billing details', 'woolentor-pro' ),
                    'placeholder' => esc_html__( 'Type your title here', 'woolentor-pro' ),
                    'label_block' => true,
                ]
            );

            $this->add_control(
                'form_createfield_label_title',
                [
                    'label' => esc_html__( 'Create an account label', 'woolentor-pro' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => esc_html__( 'Create an account?', 'woolentor-pro' ),
                    'placeholder' => esc_html__( 'Type your title here', 'woolentor-pro' ),
                    'label_block' => true,
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_billing_fields',
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
                    'default' => 'first_name',
                    'options' => [
                        'first_name'=> esc_html__( 'First Name', 'woolentor-pro' ),
                        'last_name' => esc_html__( 'Last Name', 'woolentor-pro' ),
                        'company'   => esc_html__( 'Company', 'woolentor-pro' ),
                        'country'   => esc_html__( 'Country', 'woolentor-pro' ),
                        'address_1' => esc_html__( 'Street address', 'woolentor-pro' ),
                        'address_2' => esc_html__( 'Apartment address', 'woolentor-pro' ),
                        'city'      => esc_html__( 'Town / City', 'woolentor-pro' ),
                        'state'     => esc_html__( 'District', 'woolentor-pro' ),
                        'postcode'  => esc_html__( 'Postcode / ZIP', 'woolentor-pro' ),
                        'phone'     => esc_html__( 'Phone', 'woolentor-pro' ),
                        'email'     => esc_html__( 'Email', 'woolentor-pro' ),
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
                    'default' => esc_html__( 'form-row-first' , 'woolentor-pro' ),
                    'description' => esc_html__( 'You can use ( form-row-first,form-row-last,form-row-wide )' , 'woolentor-pro' ),
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
                    'default' => 'text',
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
                    'return_value'  => 'yes',
                    'default'       => 'no',
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
                            'field_key'             => 'first_name',
                            'field_label'           => esc_html__( 'First Name', 'woolentor-pro' ),
                            'field_placeholder'     => '',
                            'field_default_value'   => '',
                            'field_validation'      => '',
                            'field_class'           => 'form-row-first',
                            'field_required'        => 'yes',
                        ],
                        [
                            'field_key'             => 'last_name',
                            'field_label'           => esc_html__( 'Last Name', 'woolentor-pro' ),
                            'field_placeholder'     => '',
                            'field_default_value'   => '',
                            'field_validation'      => '',
                            'field_class'           => 'form-row-last',
                            'field_required'        => 'yes',
                        ],
                        [
                            'field_key'             => 'company',
                            'field_label'           => esc_html__( 'Company name', 'woolentor-pro' ),
                            'field_placeholder'     => '',
                            'field_default_value'   => '',
                            'field_validation'      => '',
                            'field_class'           => 'form-row-wide',
                            'field_required'        => 'no',
                        ],
                        [
                            'field_key'             => 'country',
                            'field_label'           => esc_html__( 'Country', 'woolentor-pro' ),
                            'field_placeholder'     => '',
                            'field_default_value'   => '',
                            'field_validation'      => '',
                            'field_class'           => 'form-row-wide,address-field,update_totals_on_change',
                            'field_required'        => 'yes',
                        ],
                        [
                            'field_key'             => 'address_1',
                            'field_label'           => esc_html__( 'Street address', 'woolentor-pro' ),
                            'field_placeholder'     => '',
                            'field_default_value'   => '',
                            'field_validation'      => '',
                            'field_class'           => 'form-row-wide,address-field',
                            'field_required'        => 'no',
                        ],
                        [
                            'field_key'             => 'address_2',
                            'field_label'           => esc_html__( 'Apartment address','woolentor-pro'),
                            'field_placeholder'     => esc_html__( 'Apartment, suite, unit etc. (optional)', 'woolentor-pro' ),
                            'field_default_value'   => '',
                            'field_validation'      => '',
                            'field_class'           => 'form-row-wide,address-field',
                            'field_required'        => 'no',
                        ],
                        [
                            'field_key'             => 'city',
                            'field_label'           => esc_html__( 'Town / City', 'woolentor-pro' ),
                            'field_placeholder'     => '',
                            'field_default_value'   => '',
                            'field_validation'      => '',
                            'field_class'           => 'form-row-wide,address-field',
                            'field_required'        => 'yes',
                        ],
                        [
                            'field_key'             => 'state',
                            'field_label'           => esc_html__( 'State / County', 'woolentor-pro' ),
                            'field_placeholder'     => '',
                            'field_default_value'   => '',
                            'field_validation'      => ['state'],
                            'field_class'           => 'form-row-wide,address-field',
                            'field_required'        => 'no',
                        ],
                        [
                            'field_key'             => 'postcode',
                            'field_label'           => esc_html__( 'Postcode / ZIP', 'woolentor-pro' ),
                            'field_placeholder'     => '',
                            'field_default_value'   => '',
                            'field_validation'      => ['postcode'],
                            'field_class'           => 'form-row-wide,address-field',
                            'field_required'        => 'yes',
                        ],
                        [
                            'field_key'             => 'phone',
                            'field_label'           => esc_html__( 'Phone', 'woolentor-pro' ),
                            'field_placeholder'     => '',
                            'field_default_value'   => '',
                            'field_validation'      => ['phone'],
                            'field_class'           => 'form-row-wide',
                            'field_required'        => 'yes',
                        ],
                        [
                            'field_key'             => 'email',
                            'field_label'           => esc_html__( 'Email address', 'woolentor-pro' ),
                            'field_placeholder'     => '',
                            'field_default_value'   => '',
                            'field_validation'      => ['email'],
                            'field_class'           => 'form-row-wide',
                            'field_required'        => 'yes',
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
                    'selector'  => '{{WRAPPER}} .woocommerce-billing-fields > h3',
                )
            );

            $this->add_control(
                'form_heading_color',
                [
                    'label' => __( 'Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-billing-fields > h3' => 'color: {{VALUE}}',
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
                        '{{WRAPPER}} .woocommerce-billing-fields > h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                        '{{WRAPPER}} .woocommerce-billing-fields > h3' => 'text-align: {{VALUE}}',
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
                    'selector'  => '{{WRAPPER}} .woocommerce-billing-fields .form-row label',
                )
            );

            $this->add_control(
                'form_label_color',
                [
                    'label' => __( 'Label Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-billing-fields .form-row label' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'form_label_required_color',
                [
                    'label' => __( 'Required Color', 'woolentor-pro' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-billing-fields .form-row label abbr' => 'color: {{VALUE}}',
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
                        '{{WRAPPER}} .woocommerce-billing-fields .form-row label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                        '{{WRAPPER}} .woocommerce-billing-fields .form-row label' => 'text-align: {{VALUE}}',
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
                        '{{WRAPPER}} .woocommerce-billing-fields input.input-text' => 'color: {{VALUE}}',
                        '{{WRAPPER}} .woocommerce-billing-fields .input-text' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                array(
                    'name'      => 'form_input_box_typography',
                    'label'     => esc_html__( 'Typography', 'woolentor-pro' ),
                    'selector'  => '{{WRAPPER}} .woocommerce-billing-fields input.input-text, {{WRAPPER}} .form-row select, {{WRAPPER}} .form-row .select2-container .select2-selection,  {{WRAPPER}} .form-row .select2-container .select2-selection .select2-selection__rendered, {{WRAPPER}} .woocommerce-billing-fields .input-text',
                )
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'form_input_box_border',
                    'label' => __( 'Border', 'woolentor-pro' ),
                    'selector' => '{{WRAPPER}} .woocommerce-billing-fields input.input-text, {{WRAPPER}} .form-row select, {{WRAPPER}} .form-row .select2-container .select2-selection, {{WRAPPER}} .woocommerce-billing-fields .input-text',
                ]
            );

            $this->add_responsive_control(
                'form_input_box_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'woolentor-pro' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%'],
                    'selectors' => [
                        '{{WRAPPER}} .woocommerce-billing-fields input.input-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .form-row select, {{WRAPPER}} .form-row .select2-container .select2-selection' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .woocommerce-billing-fields .input-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                        '{{WRAPPER}} .woocommerce-billing-fields input.input-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .form-row select, {{WRAPPER}} .form-row .select2-container .select2-selection' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; box-sizing: content-box;',
                        '{{WRAPPER}} .form-row .select2-container .select2-selection .select2-selection__arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0; box-sizing: content-box;',
                        '{{WRAPPER}} .woocommerce-billing-fields .input-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0; box-sizing: content-box;',
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
                        '{{WRAPPER}} .woocommerce-billing-fields input.input-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .woocommerce-billing-fields .input-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );


        $this->end_controls_section();

    }

    protected function render() {
        $settings   = $this->get_settings_for_display();
        $field_list = $this->get_settings_for_display( 'field_list' );

        $items = array();

        if( $settings['modify_field'] == 'yes' ){
            if( isset( $field_list ) ){

                $priority = 0;

                foreach ( $field_list as $key => $field ) {

                    $fkey = 'billing_'.$field['field_key'];

                    if( $field['field_key'] == 'customadd' ){
                        $fkey = 'billing_'.$field['field_key_custom'];
                    }
                    $items[$fkey] = array(
                        'label'       => $field['field_label'],
                        'required'    => ( $field['field_required'] == 'yes' ? true : false ),
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

            if( !empty( get_option( 'woolentor_wc_fields_billing' ) ) || get_option( 'woolentor_wc_fields_billing' ) ){
                update_option( 'woolentor_wc_fields_billing', $items );
            }else{
                add_option( 'woolentor_wc_fields_billing', $items );
            }

        }else{
            delete_option( 'woolentor_wc_fields_billing' );
        }

        if ( Plugin::instance()->editor->is_edit_mode() ) {
            $checkout = wc()->checkout();
            if( sizeof( $checkout->checkout_fields ) > 0 ){

                ?>
                    <form>
                        <div class="woocommerce-billing-fields">

                            <?php
                                if( !empty( $settings['form_title'] ) ){
                                    echo '<h3>'.esc_html__( $settings['form_title'], 'woolentor-pro' ).'</h3>';
                                }
                            ?>

                            <?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

                            <div class="woocommerce-billing-fields__field-wrapper">
                                <?php
                                    $fields = $checkout->get_checkout_fields( 'billing' );
                                    foreach ( $fields as $key => $field ) {
                                        woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                                    }
                                ?>
                            </div>

                            <?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
                        </div>
                    </form>

                <?php

            }
        }else{
            if( is_checkout() ){
                $checkout = wc()->checkout();
                if( sizeof( $checkout->checkout_fields ) > 0 ){
                    
                    ?>
                        <div class="woocommerce-billing-fields">

                            <?php
                                if( !empty( $settings['form_title'] ) ){
                                    echo '<h3>'.esc_html__( $settings['form_title'], 'woolentor-pro' ).'</h3>';
                                }
                            ?>

                            <?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

                            <div class="woocommerce-billing-fields__field-wrapper">
                                <?php
                                    $fields = $checkout->get_checkout_fields( 'billing' );
                                    foreach ( $fields as $key => $field ) {
                                        woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                                    }
                                ?>
                            </div>

                            <?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
                        </div>

                        <?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
                            <div class="woocommerce-account-fields">
                                <?php if ( ! $checkout->is_registration_required() ) : ?>

                                    <p class="form-row form-row-wide create-account">
                                        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                                            <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ); ?> type="checkbox" name="createaccount" value="1" /> <span><?php esc_html_e( $settings['form_createfield_label_title'], 'woolentor-pro' ); ?></span>
                                        </label>
                                    </p>

                                <?php endif; ?>

                                <?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

                                <?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

                                    <div class="create-account">
                                        <?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
                                            <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
                                        <?php endforeach; ?>
                                        <div class="clear"></div>
                                    </div>

                                <?php endif; ?>

                                <?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
                            </div>
                        <?php endif; ?>

                    <?php
                }
            }
        }
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new WL_Checkout_Billing_Form_Element() );
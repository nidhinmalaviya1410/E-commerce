<?php
namespace Elementor;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WL_Myaccount_Download_ELement extends Widget_Base {

    public function get_name() {
        return 'wl-myaccount-download';
    }

    public function get_title() {
        return __( 'WL: Myaccount Download', 'woolentor-pro' );
    }

    public function get_icon() {
        return 'eicon-download-button';
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
        return ['my account page','account page','my account download','download'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_content',
            array(
                'label' => __( 'My Account Download', 'woolentor' ),
            )
        );

            $this->add_control(
                'html_notice',
                array(
                    'label' => __( 'Element Information', 'woolentor' ),
                    'show_label' => false,
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => __( 'My Account Download', 'woolentor' ),
                )
            );

        $this->end_controls_section();

    }

    protected function render() {
        if ( Plugin::instance()->editor->is_edit_mode() ) {
            do_action('woocommerce_account_downloads_endpoint');
        }else{
            if ( is_account_page() ) {
                do_action('woocommerce_account_downloads_endpoint');
            }
        }
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new WL_Myaccount_Download_ELement() );
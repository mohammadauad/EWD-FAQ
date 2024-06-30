<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

/**
 * The MXEFEnqueueScriptsFrontend class.
 *
 * Here you can enqueue CSS and JS files 
 * on the frontend part.
 */
class MXEFEnqueueScriptsFrontend
{

    /*
    * Registration of styles and scripts.
    */
    public static function registerScripts()
    {

        add_action( 'wp_enqueue_scripts', ['MXEFEnqueueScriptsFrontend', 'enqueue'] );
    }

    public static function enqueue()
    {

        wp_enqueue_style('mxef_style_front', MXEF_PLUGIN_URL . 'includes/frontend/assets/build/index.css', [], MXEF_PLUGIN_VERSION, 'all');
     
        $args = array(
            'post_type' => 'mxef_faqs',
            'posts_per_page' => -1, 
        );
        $custom_styles = '';
        $query = new WP_Query($args);
        if ($query->have_posts()) :

            while ($query->have_posts()) : $query->the_post();
                $ref = get_the_ID();

                $title_color = !empty(get_post_meta($ref, '_title_color', true)) ? get_post_meta($ref, '_title_color', true) : '#000';
                $text_color = !empty(get_post_meta($ref, '_text_color', true)) ? get_post_meta($ref, '_text_color', true) : '#000';
                $background_title = !empty(get_post_meta($ref, '_background_title', true)) ? get_post_meta($ref, '_background_title', true) : '222';
                $background_text = !empty(get_post_meta($ref, '_background_text', true)) ? get_post_meta($ref, '_background_text', true) : '#fff';
                $title_color_active = !empty(get_post_meta($ref, '_title_color_active', true)) ? get_post_meta($ref, '_title_color_active', true) : '#000';
                $background_title_active = !empty(get_post_meta($ref, '_background_title_active', true)) ? get_post_meta($ref, '_background_title_active', true) : '#fff';
                $padding_top = !empty(get_post_meta($ref, '_padding_top', true)) ? get_post_meta($ref, '_padding_top', true).'px' : 0;
                $padding_bottom = !empty(get_post_meta($ref, '_padding_bottom', true)) ? get_post_meta($ref, '_padding_bottom', true).'px' : 0;
                $padding_left = !empty(get_post_meta($ref, '_padding_left', true)) ? get_post_meta($ref, '_padding_left', true).'px' : 0;
                $padding_right = !empty(get_post_meta($ref, '_padding_right', true)) ? get_post_meta($ref, '_padding_right', true).'px' : 0;
                $padding_top_title = !empty(get_post_meta($ref, '_padding_top_title', true)) ? get_post_meta($ref, '_padding_top_title', true).'px' : 0;
                $padding_bottom_title = !empty(get_post_meta($ref, '_padding_bottom_title', true)) ? get_post_meta($ref, '_padding_bottom_title', true).'px' : 0;
                $padding_left_title = !empty(get_post_meta($ref, '_padding_left_title', true)) ? get_post_meta($ref, '_padding_left_title', true).'px' : 0;
                $padding_right_title = !empty(get_post_meta($ref, '_padding_right_title', true)) ? get_post_meta($ref, '_padding_right_title', true).'px' : 0;
                $title_size = !empty(get_post_meta($ref, '_title_size', true)) ? get_post_meta($ref, '_title_size', true).'px' : '18px';
                $text_size = !empty(get_post_meta($ref, '_text_size', true)) ? get_post_meta($ref, '_text_size', true).'px' : '16px';
                $radius = !empty(get_post_meta($ref, '_radius', true)) ? get_post_meta($ref, '_radius', true).'px' : '0px';
                $icon_color = !empty(get_post_meta($ref, '_icon_color', true)) ? get_post_meta($ref, '_icon_color', true) : '#000';
                $icon_color_active = !empty(get_post_meta($ref, '_icon_color_active', true)) ? get_post_meta($ref, '_icon_color_active', true) : '#000';
                $icon_size = !empty(get_post_meta($ref, '_icon_size', true)) ? get_post_meta($ref, '_icon_size', true).'px' : '22ppx';
                $custom_styles .= "[data-ref='{$ref}'] .accordion-header {color:{$title_color};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-header * {color:{$title_color};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-header {background-color:{$background_title};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-header {padding-top:{$padding_top_title};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-header {padding-bottom:{$padding_bottom_title};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-header {padding-left:{$padding_left_title};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-header {padding-right:{$padding_right_title};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-body.active {color:{$text_color};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-body.active {background-color:{$background_text};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-body.active {padding-top:{$padding_top};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-body.active {padding-bottom:{$padding_bottom};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-body.active {padding-left:{$padding_left};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-body.active {padding-right:{$padding_right};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-header.active {color:{$title_color_active};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-header.active * {color:{$title_color_active};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-header.active {background-color:{$background_title_active};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-header {font-size:{$title_size};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-header * {font-size:{$title_size};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-body {font-size:{$text_size};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-header {border-radius:{$radius};}";
                $radius2= $radius.' '.$radius.' 0 0';
                $custom_styles .= "[data-ref='{$ref}'] .accordion-header.active {border-radius:{$radius2};}";
                $radius2= '0 0 '.$radius.' '.$radius;
                $custom_styles .= "[data-ref='{$ref}'] .accordion-body.active {border-radius:{$radius2};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-header svg {width:{$icon_size};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-header svg {fill:{$icon_color};}";
                $custom_styles .= "[data-ref='{$ref}'] .accordion-header.active svg {fill:{$icon_color_active};}";
            endwhile;
        endif;
        wp_add_inline_style('mxef_style_front', $custom_styles);

        wp_enqueue_script('jquery');
        wp_enqueue_script('mxef_script', MXEF_PLUGIN_URL . 'includes/frontend/assets/build/index.js', array('jquery'), null, true);
        wp_localize_script( 'faq-script', 'afp_vars', array(
            'afp_nonce' => wp_create_nonce( 'afp_nonce' ), 
            'afp_ajax_url' => admin_url( 'admin-ajax.php' ),
        ));





    }

}

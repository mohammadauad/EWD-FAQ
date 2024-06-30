<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

/**
 * The MXEFCPTGenerator class.
 *
 * Here you can generate CPT, Taxonomies and Metaboxes
 */
class MXEFCPTGenerator
{
    static $post_type = 'mxef_faqs';
    static $taxonomy  = 'mxef_faq_type';

    public static function createCPT()
    {
        $post_type = self::$post_type;

        // Add CPT.
        add_action('init', ['MXEFCPTGenerator', 'addCTPs']);

        // Add metaboxes.
        add_action('add_meta_boxes', ['MXEFCPTGenerator', 'addMetaboxes']);
        add_action('add_meta_boxes', ['MXEFCPTGenerator', 'add_custom_meta_boxes']);

        // Manage columns.
        add_filter("manage_{$post_type}_posts_columns", ['MXEFCPTGenerator', 'addIdColumn'], 20, 1);
        add_action("manage_{$post_type}_posts_custom_column", ['MXEFCPTGenerator', 'faqsColumnRow'], 20, 2);
        add_filter("manage_edit-{$post_type}_sortable_columns", ['MXEFCPTGenerator', 'sortableColumns'], 20, 1);
        add_filter('pre_get_posts', ['MXEFCPTGenerator', 'viewColumnsOrder']);
    }

    public static function faqsColumnRow($column, $post_id)
    {
        $post_type = self::$post_type;

        if ($column === 'faq_id') {
            echo __('FAQ ID', 'ewd-faq') . ' = ' . $post_id;
        }

        if ($column === 'faq_author') {
            echo get_post_meta($post_id, "_mx_text-metabox_{$post_type}_id", true);
        }
    }

    public static function addIdColumn($columns)
    {
        $newColumns = [
            'faq_id' => __('FAQ ID', 'ewd-faq'),
            'faq_author' => __('FAQ Author', 'ewd-faq')
        ];

        $newColumns = mxefInsertNewColumnToPosition($columns, 3, $newColumns);

        return $newColumns;
    }

    public static function addCTPs()
    {
        register_post_type(self::$post_type, [
            'labels' => [
                'name' => __('FAQs', 'ewd-faq'),
                'singular_name' => __('FAQ', 'ewd-faq'),
                'add_new' => __('Add a new one', 'ewd-faq'),
                'add_new_item' => __('Add a new FAQ', 'ewd-faq'),
                'edit_item' => __('Edit the FAQ', 'ewd-faq'),
                'new_item' => __('New FAQ', 'ewd-faq'),
                'view_item' => __('See the FAQ', 'ewd-faq'),
                'search_items' => __('Find a FAQ', 'ewd-faq'),
                'not_found' => __('FAQs not found', 'ewd-faq'),
                'not_found_in_trash' => __('No FAQs found in the trash', 'ewd-faq'),
                'parent_item_colon' => __('Parent Pages:', 'ewd-faq'),
                'menu_name' => __('FAQs', 'ewd-faq')
            ],
            'menu_icon' => 'dashicons-editor-help',
            'show_in_rest' => true,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'faqs'],
            'capability_type' => 'page',
            'capability' => 'manage_options',
            'has_archive' => true,
            'hierarchical' => true,
            'menu_position' => null,
            'supports' => ['title', 'author', 'thumbnail', 'page-attributes']
        ]);

        // Rewrite rules.
        if (is_admin() && get_option('mxef_flush_rewrite_rules') == 'go_flush_rewrite_rules') {
            delete_option('mxef_flush_rewrite_rules');
            flush_rewrite_rules();
        }
    }

    public static function addTaxonomies() {}

    public static function addMetaboxes()
    {
        add_meta_box(
            'faq_questions_responses',
            __('FAQ Questions & Responses', 'ewd-faq'),
            ['MXEFCPTGenerator', 'faqs_callback'],
            self::$post_type,
            'normal',
            'high'
        );
    }

    public static function faqs_callback($post) {
        $questions_responses = get_post_meta($post->ID, '_mxef_faqs', true);
    
        $question_label = __('Question', 'ewd-faq');
        $response_label = __('Response', 'ewd-faq');
        $remove_label = __('Remove', 'ewd-faq');
        $add_item_label = __('Add an item', 'ewd-faq');
        ?>
        <div class="faq-metabox">
            <div id="faq_questions_responses_bloc">
                <?php
                if (!empty($questions_responses)) {
                    $i = 0;
                    foreach ($questions_responses as $qa) {
                        echo '<div class="faq-item">';
                        echo '<div class="faq-item-b">';
                        echo '<div class="faq-item-question">';
                        echo '<label>' . esc_html($question_label) . ':</label>';
                        echo '<textarea id="wysiwyg_editor_question_' . esc_attr($i) . '" name="_mxef_faqs[' . esc_attr($i) . '][question]" rows="3" cols="50">' . esc_textarea(wp_kses_post($qa['question'])) . '</textarea>';
                        echo '</div>';
                        echo '<div class="faq-item-response">';
                        echo '<label>' . esc_html($response_label) . ':</label>';
                        echo '<textarea id="wysiwyg_editor_response_' . esc_attr($i) . '" name="_mxef_faqs[' . esc_attr($i) . '][response]" rows="3" cols="50">' . esc_textarea(wp_kses_post($qa['response'])) . '</textarea>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="faq-item-b">';
                        echo '<button type="button" class="remove_faq_item">' . esc_html($remove_label) . '</button>';
                        echo '</div>';
                        echo '</div>';
                        $i++;
                    }
                } else {
                    echo '<div class="faq-item">';
                    echo '<div class="faq-item-b">';
                    echo '<div class="faq-item-question">';
                    echo '<label>' . esc_html($question_label) . ':</label>';
                    echo '<textarea id="wysiwyg_editor_question_0" name="_mxef_faqs[0][question]" rows="3" cols="50"></textarea>';
                    echo '</div>';
                    echo '<div class="faq-item-response">';
                    echo '<label>' . esc_html($response_label) . ':</label>';
                    echo '<textarea id="wysiwyg_editor_response_0" name="_mxef_faqs[0][response]" rows="3" cols="50"></textarea>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="faq-item-b">';
                    echo '<button type="button" class="remove_faq_item">' . esc_html($remove_label) . '</button>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
            <button type="button" class="button" id="add_faq_item"><?php echo esc_html($add_item_label); ?></button>
        </div>
        <?php
    }
    

    public static function add_custom_meta_boxes()
    {
        add_meta_box(
            'custom_settings_meta_box',
            __('Custom Settings', 'ewd-faq'),
            ['MXEFCPTGenerator', 'custom_settings_callback'],
            self::$post_type,
            'normal',
            'high'
        );
    }

    public static function custom_settings_callback($post)
    {
        $title_color = get_post_meta($post->ID, '_title_color', true);
        $text_color = get_post_meta($post->ID, '_text_color', true);
        $background_title = get_post_meta($post->ID, '_background_title', true);
        $background_text = get_post_meta($post->ID, '_background_text', true);
        $title_color_active = get_post_meta($post->ID, '_title_color_active', true);
        $background_title_active = get_post_meta($post->ID, '_background_title_active', true);
        $padding_top = get_post_meta($post->ID, '_padding_top', true);
        $padding_bottom = get_post_meta($post->ID, '_padding_bottom', true);
        $padding_left = get_post_meta($post->ID, '_padding_left', true);
        $padding_right = get_post_meta($post->ID, '_padding_right', true);
        $padding_top_title = get_post_meta($post->ID, '_padding_top_title', true);
        $padding_bottom_title = get_post_meta($post->ID, '_padding_bottom_title', true);
        $padding_left_title = get_post_meta($post->ID, '_padding_left_title', true);
        $padding_right_title = get_post_meta($post->ID, '_padding_right_title', true);
        $title_size = get_post_meta($post->ID, '_title_size', true);
        $text_size = get_post_meta($post->ID, '_text_size', true);
        $radius = get_post_meta($post->ID, '_radius', true);
        $icon_color = get_post_meta($post->ID, '_icon_color', true);
        $icon_color_active = get_post_meta($post->ID, '_icon_color_active', true);
        $icon_size = get_post_meta($post->ID, '_icon_size', true);

        $style_label = __('Style', 'ewd-faq');
        $title_color_label = __('Title Color', 'ewd-faq');
        $text_color_label = __('Text Color', 'ewd-faq');
        $background_title_label = __('Title Background', 'ewd-faq');
        $background_text_label = __('Text Background', 'ewd-faq');
        $title_color_active_label = __('Active Title Color', 'ewd-faq');
        $background_title_active_label = __('Active Title Background', 'ewd-faq');
        $padding_top_title_label = __('Title Padding Top (px)', 'ewd-faq');
        $padding_bottom_title_label = __('Title Padding Bottom (px)', 'ewd-faq');
        $padding_left_title_label = __('Title Padding Left (px)', 'ewd-faq');
        $padding_right_title_label = __('Title Padding Right (px)', 'ewd-faq');
        $padding_top_label = __('Text Padding Top (px)', 'ewd-faq');
        $padding_bottom_label = __('Text Padding Bottom (px)', 'ewd-faq');
        $padding_left_label = __('Text Padding Left (px)', 'ewd-faq');
        $padding_right_label = __('Text Padding Right (px)', 'ewd-faq');
        $title_size_label = __('Title Size (px)', 'ewd-faq');
        $text_size_label = __('Text Size (px)', 'ewd-faq');
        $radius_label = __('Radius (px)', 'ewd-faq');
        $icon_color_label = __('Icon Color', 'ewd-faq');
        $icon_color_active_label = __('Active Icon Color', 'ewd-faq');
        $icon_size_label = __('Icon Size', 'ewd-faq');
        ?>
        <div class="reg-faq-item">
            <h3><?php echo esc_html($style_label); ?></h3>
            <div class="reg-faq">
                <label for="title_color"><?php echo esc_html($title_color_label); ?>:</label>
                <input type="color" id="title_color" name="title_color" value="<?php echo esc_attr($title_color); ?>">
                <label for="text_color"><?php echo esc_html($text_color_label); ?>:</label>
                <input type="color" id="text_color" name="text_color" value="<?php echo esc_attr($text_color); ?>">
                <label for="background_title"><?php echo esc_html($background_title_label); ?>:</label>
                <input type="color" id="background_title" name="background_title" value="<?php echo esc_attr($background_title); ?>">
                <label for="background_text"><?php echo esc_html($background_text_label); ?>:</label>
                <input type="color" id="background_text" name="background_text" value="<?php echo esc_attr($background_text); ?>">
            </div>
            <div class="reg-faq">
                <label for="title_color_active"><?php echo esc_html($title_color_active_label); ?>:</label>
                <input type="color" id="title_color_active" name="title_color_active" value="<?php echo esc_attr($title_color_active); ?>">
                <label for="background_title_active"><?php echo esc_html($background_title_active_label); ?>:</label>
                <input type="color" id="background_title_active" name="background_title_active" value="<?php echo esc_attr($background_title_active); ?>">
            </div>
            <div class="reg-faq">
                <label for="padding_top_title"><?php echo esc_html($padding_top_title_label); ?>:</label>
                <input type="number" id="padding_top_title" name="padding_top_title" value="<?php echo esc_attr($padding_top_title); ?>">
                <label for="padding_bottom_title"><?php echo esc_html($padding_bottom_title_label); ?>:</label>
                <input type="number" id="padding_bottom_title" name="padding_bottom_title" value="<?php echo esc_attr($padding_bottom_title); ?>">
                <label for="padding_left_title"><?php echo esc_html($padding_left_title_label); ?>:</label>
                <input type="number" id="padding_left_title" name="padding_left_title" value="<?php echo esc_attr($padding_left_title); ?>">
                <label for="padding_right_title"><?php echo esc_html($padding_right_title_label); ?>:</label>
                <input type="number" id="padding_right_title" name="padding_right_title" value="<?php echo esc_attr($padding_right_title); ?>">
            </div>
            <div class="reg-faq">
                <label for="padding_top"><?php echo esc_html($padding_top_label); ?>:</label>
                <input type="number" id="padding_top" name="padding_top" value="<?php echo esc_attr($padding_top); ?>">
                <label for="padding_bottom"><?php echo esc_html($padding_bottom_label); ?>:</label>
                <input type="number" id="padding_bottom" name="padding_bottom" value="<?php echo esc_attr($padding_bottom); ?>">
                <label for="padding_left"><?php echo esc_html($padding_left_label); ?>:</label>
                <input type="number" id="padding_left" name="padding_left" value="<?php echo esc_attr($padding_left); ?>">
                <label for="padding_right"><?php echo esc_html($padding_right_label); ?>:</label>
                <input type="number" id="padding_right" name="padding_right" value="<?php echo esc_attr($padding_right); ?>">
            </div>
            <div class="reg-faq">
                <label for="title_size"><?php echo esc_html($title_size_label); ?>:</label>
                <input type="number" id="title_size" name="title_size" value="<?php echo esc_attr($title_size); ?>">
                <label for="text_size"><?php echo esc_html($text_size_label); ?>:</label>
                <input type="number" id="text_size" name="text_size" value="<?php echo esc_attr($text_size); ?>">
            </div>
            <div class="reg-faq">
                <label for="radius"><?php echo esc_html($radius_label); ?>:</label>
                <input type="number" id="radius" name="radius" value="<?php echo esc_attr($radius); ?>">
            </div>
            <div class="reg-faq">
                <label for="icon_color"><?php echo esc_html($icon_color_label); ?>:</label>
                <input type="color" id="icon_color" name="icon_color" value="<?php echo esc_attr($icon_color); ?>">
                <label for="icon_color_active"><?php echo esc_html($icon_color_active_label); ?>:</label>
                <input type="color" id="icon_color_active" name="icon_color_active" value="<?php echo esc_attr($icon_color_active); ?>">
                <label for="icon_size"><?php echo esc_html($icon_size_label); ?>:</label>
                <input type="number" id="icon_size" name="icon_size" value="<?php echo esc_attr($icon_size); ?>">
            </div>
        </div>
        <?php
    }

    public static function sortableColumns($columns)
    {
        if (!empty($_GET['s'])) return $columns;

        $columns['faq_author'] = __('FAQ Author', 'ewd-faq');

        return $columns;
    }

    public static function viewColumnsOrder($query)
    {
        if (!is_admin() || empty($_GET['post_type']) || $_GET['post_type'] !== self::$post_type || empty($_GET['orderby'])) return;

        $post_type = self::$post_type;

        if ($_GET['orderby'] == 'faq_id') {
            $query->set('orderby', 'meta_value');
            $query->set('meta_key', "_mx_text-metabox_{$post_type}_id");
            $query->set('meta_type', 'numeric');
        }
    }
}

MXEFCPTGenerator::createCPT();
?>

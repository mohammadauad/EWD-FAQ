<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

if (!function_exists('mxefRequireClassFileAdmin')) {
    /**
     * Require class for admin panel.
     * 
     * @param string $file   File name in \wp-content\plugins\ewd-faq\includes/admin/classes/ folder.
     *
     * @return void
     */
    function mxefRequireClassFileAdmin( $file ) {

        require_once MXEF_PLUGIN_ABS_PATH . 'includes/admin/classes/' . $file;
    }
}

if (!function_exists('mxefRequireClassFileFrontend')) {
    /**
     * Require class for frontend part.
     * 
     * @param string $file   File name in \wp-content\plugins\ewd-faq\includes/frontend/classes/ folder.
     *
     * @return void
     */
    function mxefRequireClassFileFrontend( $file ) {

        require_once MXEF_PLUGIN_ABS_PATH . 'includes/frontend/classes/' . $file;
    }
}

if (!function_exists('mxefUseModel')) {
    /**
     * Require a Model.
     * 
     * @param string $model   File name in \wp-content\plugins\ewd-faq/includes/admin/models/ folder without ".php".
     *
     * @return void
     */
    function mxefUseModel( $model ) {

        require_once MXEF_PLUGIN_ABS_PATH . 'includes/admin/models/' . $model . '.php';
    }
}

/*
* Debugging
*/
if (!function_exists('mxefDebugToFile')) {
    /**
     * Debug anything. The result will be collected 
     * in \wp-content\plugins\ewd-faq/mx-debug/mx-debug.txt file in the root of
     * the plugin.
     * 
     * @param string $content   List of parameters (coma separated).
     *
     * @return void
     */
    function mxefDebugToFile( ...$content ) {

        $content = mxefContentToString( ...$content );

        $dir = MXEF_PLUGIN_ABS_PATH . 'mx-debug';

        $file = $dir . '/mx-debug.txt';

        if (!file_exists($dir)) {

            mkdir($dir, 0777, true);

            $current = '>>>' . date('Y/m/d H:i:s', time()) . ':' . "\n";

            $current .= $content . "\n";

            $current .= '_____________________________________' . "\n";

            file_put_contents($file, $current);
        } else {

            $current = '>>>' . date('Y/m/d H:i:s', time()) . ':' . "\n";

            $current .= $content . "\n";
            
            $current .= '_____________________________________' . "\n";          

            $current .= file_get_contents($file) . "\n";

            file_put_contents($file, $current);
        }
    }
}

if (!function_exists('mxefContentToString')) {
    /**
     * This function is helpers for the
     * mxefDebugToFile function.
     * 
     * @param string $content   List of parameters (coma separated).
     *
     * @return string
     */
    function mxefContentToString( ...$content ) {

        ob_start();

        var_dump( ...$content );

        return ob_get_clean();
    }
}

if (!function_exists('mxefInsertNewColumnToPosition')) {
    /**
     * Manage posts columns. Add column to a position.
     * 
     * @param array $columns     Existing columns returned by 
     * "manage_{$post_type}_posts_columns" filter.
     * 
     * @param int $position      Position of new columns.
     * @param array $newColumn   List of new columns.
     * Eg. [
     *  'book_id'     => 'Book ID',
     *  'book_author' => 'Book Author'
     * ]
     *
     * @return string
     */
    function mxefInsertNewColumnToPosition( array $columns, int $position, array $newColumn ) {

        $chunkedArray = array_chunk( $columns, $position, true );

        $result = array_merge( $chunkedArray[0], $newColumn, $chunkedArray[1] );

        return $result;
    }
}

if (!function_exists('mxefAdminRedirect')) {
    /**
     * Redirect from admin panel.
     * 
     * @param string $url   An url where you want to redirect to.
     *
     * @return void
     */
    function mxefAdminRedirect( $url ) {

        if (!$url) return;

        add_action( 'admin_footer', function() use ( $url ) {
            printf("<script>window.location.href = '%s';</script>", esc_url_raw($url));
        } );
    }
}

if (!function_exists('mxefRequireViewFileFrontend')) {
    /*
    * Require view for frontend panel
    */
    function mxefRequireViewFileFrontend($file, $data = NULL) {

        $data = $data;

        include MXEF_PLUGIN_ABS_PATH . 'includes/frontend/views/' . $file;
    }
}

function mxefSave_faqs($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['_mxef_faqs'])) {
        $questions_responses = array();
        $current_pair = array();
        foreach ($_POST['_mxef_faqs'] as $qa) {
            $question = wp_kses_post($qa['question']);
            $response = wp_kses_post($qa['response']);
            if (!empty($question) || !empty($response)) {
                $current_pair['question'] = $question;
                $current_pair['response'] = $response;
                $questions_responses[] = $current_pair;
                $current_pair = array(); // Reset for the next iteration
            }
        }
        update_post_meta($post_id, '_mxef_faqs', $questions_responses);
    }
}
add_action('save_post_mxef_faqs', 'mxefSave_faqs');


function mxefSave_custom_settings($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (isset($_POST['title_color'])) {
        update_post_meta($post_id, '_title_color', sanitize_hex_color($_POST['title_color']));
    }
    if (isset($_POST['text_color'])) {
        update_post_meta($post_id, '_text_color', sanitize_hex_color($_POST['text_color']));
    }
    if (isset($_POST['background_title'])) {
        update_post_meta($post_id, '_background_title', sanitize_hex_color($_POST['background_title']));
    }
    if (isset($_POST['background_text'])) {
        update_post_meta($post_id, '_background_text', sanitize_hex_color($_POST['background_text']));
    }
    if (isset($_POST['title_color_active'])) {
        update_post_meta($post_id, '_title_color_active', sanitize_hex_color($_POST['title_color_active']));
    }
    if (isset($_POST['background_title_active'])) {
        update_post_meta($post_id, '_background_title_active', sanitize_hex_color($_POST['background_title_active']));
    }
    if (isset($_POST['padding_top_title'])) {
        update_post_meta($post_id, '_padding_top_title', ($_POST['padding_top_title']));
    }
    if (isset($_POST['padding_bottom_title'])) {
        update_post_meta($post_id, '_padding_bottom_title', ($_POST['padding_bottom_title']));
    }
    if (isset($_POST['padding_left_title'])) {
        update_post_meta($post_id, '_padding_left_title', ($_POST['padding_left_title']));
    }
    if (isset($_POST['padding_right_title'])) {
        update_post_meta($post_id, '_padding_right_title', ($_POST['padding_right_title']));
    }
    if (isset($_POST['padding_top'])) {
        update_post_meta($post_id, '_padding_top', ($_POST['padding_top']));
    }
    if (isset($_POST['padding_bottom'])) {
        update_post_meta($post_id, '_padding_bottom', ($_POST['padding_bottom']));
    }
    if (isset($_POST['padding_left'])) {
        update_post_meta($post_id, '_padding_left', ($_POST['padding_left']));
    }
    if (isset($_POST['padding_right'])) {
        update_post_meta($post_id, '_padding_right', ($_POST['padding_right']));
    }
    if (isset($_POST['title_size'])) {
        update_post_meta($post_id, '_title_size', ($_POST['title_size']));
    }
    if (isset($_POST['text_size'])) {
        update_post_meta($post_id, '_text_size', ($_POST['text_size']));
    }
    if (isset($_POST['radius'])) {
        update_post_meta($post_id, '_radius', ($_POST['radius']));
    }
    if (isset($_POST['icon_color'])) {
        update_post_meta($post_id, '_icon_color', ($_POST['icon_color']));
    }
    if (isset($_POST['icon_color_active'])) {
        update_post_meta($post_id, '_icon_color_active', ($_POST['icon_color_active']));
    }
    if (isset($_POST['icon_size'])) {
        update_post_meta($post_id, '_icon_size', ($_POST['icon_size']));
    }
}
add_action('save_post', 'mxefSave_custom_settings');


add_action('edit_form_after_title', 'mxefShow_shortcode');
function mxefShow_shortcode($post) {
    if ($post->post_type == 'mxef_faqs') {
        echo '<div id="faq_questions_responses_bloc_shortcode">
        <span>[premium-faq ref="'. get_the_ID() .'"]</span>
    </div>';
    }
}


<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;

/**
 * The MXEFAddShortcode class.
 *
 * This class is an example of 
 * how to create a short code
 * and run vue.js on it.
 */
class MXEFAddShortcode
{
    public function shortcodeDisplayApp() {

        add_shortcode('premium-faq', [$this, 'displayFaqs']);
    }

    function displayFaqs($atts) {

        $args = shortcode_atts(array(
            'ref' => '',
            'id' => '',
        ), $atts);
        $ref = $args['ref'];
        $id = $args['id'];
    
        $questions_responses = get_post_meta($ref, '_mxef_faqs', true);

        if (!is_array($questions_responses)) {
            $questions_responses = maybe_unserialize($questions_responses);
        }

        if (empty($questions_responses) || !is_array($questions_responses)) {
            return '<p>No FAQs found.</p>';
        }
     

        ob_start(); 
        ?>
            <div class="accordion-faq" id="<?= esc_attr($id) ?>" data-ref="<?= esc_attr($ref) ?>">
            <?php foreach ($questions_responses as $qa) :
                
           
                ?>
                <div class="accordion">
                    <button class="accordion-header">
                        <span><?= wp_kses_post(nl2br($qa['question'])); ?></span>
                        <svg width="22" class="arrow" xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 512 299.283">
                            <path d="M75.334 286.691c-64.764 36.929-96.186-15.595-60.203-51.975L215.997 25.104c33.472-33.472 46.534-33.472 80.006 0l200.866 209.612c35.983 36.38 4.561 88.904-60.203 51.975L256 189.339 75.334 286.691z"/>
                        </svg>
                    </button>
                    <div class="accordion-body">
                        <?= wp_kses_post(nl2br($qa['response'])); ?>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        <?php
        $output = ob_get_clean(); 
        return $output;
    }
}


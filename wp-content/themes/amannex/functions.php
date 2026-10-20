<?php
/**
 * AmanneX Theme Functions
 * Headless WordPress Configuration
 */

// Enable essential theme supports
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
});

// Require Custom Post Types
require_once get_template_directory() . '/inc/cpt-projects.php';

// Expose Featured Image URL in WP REST API Post & Project payloads
add_action('rest_api_init', function () {
    register_rest_field(['post', 'project'], 'featured_image_url', [
        'get_callback' => function ($post_arr) {
            $image_id = get_post_thumbnail_id($post_arr['id']);
            if ($image_id) {
                return wp_get_attachment_image_url($image_id, 'full');
            }
            return null;
        },
        'schema' => null,
    ]);
});

// Flush rewrite rules on theme activation
add_action('after_switch_theme', function () {
    amannex_register_projects_cpt();
    flush_rewrite_rules();
});

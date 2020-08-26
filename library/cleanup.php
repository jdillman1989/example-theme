<?php
function wp_head_cleanup () {
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
    remove_action('wp_head', 'adjacent_posts_rel_link', 10);
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'parent_post_rel_link', 10);
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_head', 'rel_canonical');
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'start_post_rel_link', 10);
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
    remove_action('wp_head', 'wp_oembed_add_host_js');
    remove_action('wp_head', 'wp_resource_hints', 2);
    remove_action('wp_head', 'wp_shortlink_wp_head', 10);
    remove_action('wp_print_styles', 'print_emoji_styles');
}

if (!is_admin_bar_showing()) {
    add_action('after_setup_theme', 'wp_head_cleanup');
}

/**
 * Disable Scripts and Styles
 */
function remove_scripts_and_styles() {
    wp_dequeue_style('wp-block-library');

    if (!is_admin()) {
      wp_deregister_script('l10n');
    }
}

add_action('wp_enqueue_scripts', 'remove_scripts_and_styles', 100);

<?php
/**
 * Render a style with MD5 hash of the file.
 */
function render_style($name, $path) {
    if (preg_match('/^(\/\/|http)/', $path)) {
        wp_enqueue_style($name, $path);
    } else if (file_exists(get_template_directory() . $path)) {
        $hash = md5_file(get_template_directory() . $path);
        $path = get_template_directory_uri() . $path;

        wp_enqueue_style($name, $path, array(), null);
    } else {
        echo "<!-- Style {$name} not loaded -->";
    }
}

/**
 * Render a script with MD5 hash of the file.
 */
function render_script($name, $path) {
    if (preg_match('/^(\/\/|http)/', $path)) {
        wp_enqueue_script($name, $path);
    } else if (file_exists(get_template_directory() . $path)) {
        $hash = md5_file(get_template_directory() . $path);
        $path = get_template_directory_uri() . $path;

        wp_enqueue_script($name, $path, array(), null);
    } else {
        echo "<!-- Script {$name} not loaded -->";
    }
}

<?php
add_action( 'init', 'core_load_content_types' );
function core_load_content_types() {

	include_once MODEL_DIR . '/content/content-types.php';
}

add_action( 'acf/init', 'core_load_custom_fields' );
function core_load_custom_fields() {

	$cf_dir = MODEL_DIR . '/custom-fields';
	$custom_fields = scandir( $cf_dir );

	if( !$custom_fields ) {
		return;
	}

	foreach( $custom_fields as $field_set ) {

		$file_info = pathinfo( $cf_dir . '/' . $field_set );

		if( $file_info['extension'] == 'php' ) {
			include $cf_dir . '/' . $field_set;
		}
	}
}

add_filter( 'timber_context', 'core_timber_custom_options' );
function core_timber_custom_options( $context ) {
	$context['options'] = get_fields('option');
	return $context;
}

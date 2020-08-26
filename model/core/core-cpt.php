<?php

function core_default( $key='', $args=array(), $default='' ) {

    if( !array_key_exists( $key, $args ) ) {
		return $default;
	}

    return $args[$key];

}

function core_post_type( $label='', $args=[] ) {

	$args['label'] = $label;

	// Set defaults.
	$args['slug']   = core_default( 'slug', $args, sanitize_title( $label ) );
	$args['public'] = core_default( 'public', $args, true );

	register_post_type( $args['slug'], $args );

}

function core_taxonomy( $singular='', $plural='', $post_type='', $args=[] ) {

	$args['label'] = $singular;

	$args['labels'] = [
		'name' => $plural,
		'singular_name' => $plural,
		'search_items' => "Search ".$plural,
		'popular_items' => NULL,
		'all_items' => $plural,
		'parent_item' => "Parent ".$singular,
		'parent_item_colon' => "Parent ".$singular.":",
		'edit_item' => "Edit ".$singular,
		'view_item' => "View ".$singular,
		'update_item' => "Update ".$singular,
		'add_new_item' => "Add New ".$singular,
		'new_item_name' => "New ".$singular." Name",
		'separate_items_with_commas' => NULL,
		'add_or_remove_items' => NULL,
		'choose_from_most_used' => NULL,
		'not_found' => "No ".$plural." found.",
		'no_terms' => "No ".$plural,
		'items_list_navigation' => $plural." list navigation",
		'items_list' => $plural." list",
		'most_used' => "Most Used",
		'back_to_items' => "← Back to ".$plural,
		'menu_name' => $plural,
		'name_admin_bar' => $plural,
		'archives' => $plural
	];

	// Set defaults.
	$args['id'] = core_default( 'id', $args, true);
	$args['slug'] = core_default( 'slug', $args, sanitize_title( $singular ) );
	$args['public'] = core_default( 'public', $args, true );
	$args['hierarchical'] = core_default( 'hierarchical', $args, true );
	$args['show_admin_column'] = core_default( 'show_admin_column', $args, true );

	register_taxonomy( $args['id'], $post_type, $args );

}

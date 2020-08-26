<?php

if(function_exists('acf_add_options_page')) :
	/**
	 * Global Page.
	 */
	$global_page = array(
		'page_title'    => 'Global',
		'menu_title'    => 'Global',
		'menu_slug'     => 'global',
		'capability'    => 'edit_posts'
	);

	acf_add_options_page($global_page);

	/**
	 * Global Sections.
	 */
	$sections_subpage = array(
		'parent_slug'   => 'global',
		'page_title'    => 'Global Sections',
		'menu_title'    => 'Global Sections',
		'menu_slug'     => 'global-sections',
	);

	acf_add_options_sub_page($sections_subpage);

	/**
	 * Mega Menu.
	 */
	$menu_subpage = array(
		'parent_slug'   => 'global',
		'page_title'    => 'Navigation',
		'menu_title'    => 'Navigation',
		'menu_slug'     => 'site-navigation',
	);

	acf_add_options_sub_page($menu_subpage);

	/**
	 * Global Options.
	 */
	function acf_global($context) {
		$context['options'] = get_fields('option');

		return $context;
	}

	add_filter('timber_context', 'acf_global');

endif;

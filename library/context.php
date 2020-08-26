<?php
function add_to_context( $context ) {
		/**
		 * Include isPhone, isTablet and isDesktop variables to Timber context.
		 */
    $detect = new Mobile_Detect;

    $context['isPhone'] = $detect->isMobile() && !$detect->isTablet();
    $context['isTablet'] = $detect->isTablet();
	$context['isDesktop'] = !$detect->isMobile() && !$detect->isTablet();
	
	$get_menu = get_field('menu_items', 'option');
	$menu = [];
	foreach ($get_menu as $nav) {

		$submenu = false;
		if ($nav['sub_menu_items']) {
			$submenu = $nav['sub_menu_items'];
		}

		$menu[] = [
			'top' => $nav['top_level_link'],
			'submenu' => $submenu,
			'decoration' => $nav['decoration']
		];
	}

	$context['main_navigation'] = $menu;
	$context['secondary_navigation'] = get_field('secondary_menu_items', 'option');
	$context['social_links'] = get_field('social_links', 'option');

    return $context;
}
add_filter('timber_context', 'add_to_context');



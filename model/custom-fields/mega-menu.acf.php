<?php

$group_args = [
	'title' => 'Navigation',
	'location_is' => [ 'options_page', 'site-navigation' ],
	'hide_on_screen' => ['the_content']
];

$fields = [
	// Main Menu
	['tab', 'Top Menu', ['placement' => 'left']],
	['repeater', 'Menu Items', [
		'instructions' => 'The navigation items present here appear in the mobile menu and in the header of the desktop menu.',
		'sub_fields' => [
			['link', 'Top Level Link', ['return_format' => 'array', 'wrapper' => ['width' => '33.333']]],
			['radio', 'Does this link have a mega menu?', [
				'key' => 'field_nav_item_has_mega_menu',
				'name' => 'field_nav_item_has_mega_menu',
				'wrapper' => ['width' => '33.333'],
				'layout' => 'horizontal',
				'choices' => ['yes' => 'Yes', 'no' => 'No'],
				'default_value' => 'no',
			]],
			['image', 'Decoration', [
				'return_format' => 'array',
				'instructions' => 'Will only display if sub menu items set',
				'wrapper' => ['width' => '33.333'],
				'conditional_logic' => [
					[
						'field' => 'field_nav_item_has_mega_menu',
						'operator' => '==',
						'value' => 'yes',
					]
				],
			]],
			['repeater', 'Sub Menu Items', [
				'sub_fields' => [
					['link', 'Sub Link', ['return_format' => 'array', 'wrapper' => ['width' => '50']]],
					['image', 'Image', ['return_format' => 'array', 'wrapper' => ['width' => '50']]],
					['textarea', 'Description'],
					['text', 'Button Label'],
				],
				'min' => 0,
				'max' => 10,
				'layout' => 'block',
				'button_label' => 'Add Sub Menu Item',
				'conditional_logic' => [
					[
						'field' => 'field_nav_item_has_mega_menu',
						'operator' => '==',
						'value' => 'yes',
					]
				],
			]],
		],
		'min' => 1,
		'max' => 7,
		'layout' => 'block',
		'button_label' => 'Add Menu Item'
	]],

	// Secondary Menu
	['tab', 'Secondary Menu', ['placement' => 'left']],
	['repeater', 'Secondary Menu Items', [
		'instructions' => 'The navigation items present here appear in the mobile menu and at the top of the footer menu.',
		'sub_fields' => [
			['link', 'Link', ['return_format' => 'array']],
		],
		'min' => 0,
		'max' => 7,
		'layout' => 'block',
		'button_label' => 'Add Secondary Menu Item'
	]],


	// Social Menu
	['tab', 'Social Menu', ['placement' => 'left']],
	['repeater', 'Social Links', [
		'sub_fields' => [
			['link', 'Link', ['return_format' => 'array', 'wrapper' => ['width' => '33.333']]],
			['image', 'Social Icon', ['return_format' => 'id', 'wrapper' => ['width' => '33.333']]],
			['image', 'White Social Icon', ['return_format' => 'id', 'wrapper' => ['width' => '33.333']]]
		],
		'min' => 0,
		'max' => 7,
		'layout' => 'block',
		'button_label' => 'Add Social Link'
	]],

	// Action Menu
	['tab', 'Action Menu', ['placement' => 'left']],
	['link', 'Login Button'],
	['link', 'Signup Button'],

	// Footer Menu
	['tab', 'Footer Menu', ['placement' => 'left']],
	['repeater', 'Footer Menu Items', [
		'instructions' => 'The navigation items present here appear in the middle of the footer.',
		'sub_fields' => [
			['text', 'Nav Group Heading'],
			['repeater', 'Nav Group Items', [
				'sub_fields' => [
					['link', 'Link', ['return_format' => 'array']],
				],
				'min' => 1,
				'layout' => 'block',
				'button_label' => 'Add Nav Group Item'
			]]
		],
		'min' => 0,
		'layout' => 'block',
		'button_label' => 'Add Footer Menu Item'
	]],
	['repeater', 'Footer App Links', [
		'sub_fields' => [
			['link', 'App Link', ['wrapper' => ['width' => '50']]],
			['image', 'App Image', ['return_format' => 'id', 'wrapper' => ['width' => '50']]]
		],
		'min' => 2,
		'max' => 2,
		'layout' => 'block',
	]]
];

$field_group = core_register_field_group('Menu', $group_args, $fields);

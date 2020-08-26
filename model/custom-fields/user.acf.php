<?php

$group_args = [
	'title' => 'Blog Profile Info',
	'location' => [
		[
			[
				'param' => 'user_role',
				'operator' => '==',
				'value' => 'all',
			],
		]
	],
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
];

$fields = [
	// User Avatar
	['image', 'User Profile Image', ['return_format' => 'id', 'preview_size' => 'thumbnail']],

];


$field_group = core_register_field_group('Blog Profile Info', $group_args, $fields);

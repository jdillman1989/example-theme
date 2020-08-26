<?php
$group_args = [
	'title' => 'Resource Listings Page Fields',
	'location' => [
		[
			[
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'template/resource-catalog.php'
			],
		],
	],
	'hide_on_screen' => ['the_content']
];

$fields = [
	['image', 'Youtube Section Icon', ['return_form' => 'id', 'wrapper' => ['width' => '50']]],
	['link', 'Youtube Channel Link', ['wrapper' => ['width' => '50']]],
	['textarea', 'Youtube Section Heading', [
		'rows' => '2',
		'new_lines' => 'br',
	]],
	['textarea', 'Youtube Section Content', [
		'rows' => '2',
		'new_lines' => 'br',
	]],
];

$field_group = core_register_field_group('Archives', $group_args, $fields);

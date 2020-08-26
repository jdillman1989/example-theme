<?php
$group_args = [
	'title' => 'Archive Page Fields',
	'location' => [
		[
			[
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'template/post-catalog.php'
			],
		],
		[
			[
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'template/resource-catalog.php'
			],
		],
		[
			[
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'category',
			],
		],
		[
			[
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'audiences',
			],
		],
		[
			[
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'topics',
			],
		],
		[
			[
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'content-type',
			],
		],
	],
	'hide_on_screen' => ['the_content']
];

$fields = [
	['relationship', 'Featured Post Selection', [
		'return_format' => 'id',
		'min' => 0, 'max' => 1,
		'post_type' => [
			0 => 'post',
			1 => 'resource',
		],
		'filters' => [
			0 => 'search',
			1 => 'post_type',
			2 => 'taxonomy',
		],
		'elements' => [
			0 => 'featured_image',
		]
	]]
];

$field_group = core_register_field_group('Archives', $group_args, $fields);

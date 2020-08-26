<?php

$group_args = [
	'title' => 'Resource CPT',
	'location' => [
		[
			[
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'resource',
			],
		]
	],
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => ''
];

$fields = [
	['textarea', 'Featured Resource Excerpt', [
		'name' => 'post_excerpt',
		'wrapper' => [
			'width' => '40'
		]
	]],
	[
		'url',
		'External Link',
		[
			'name' => 'external_link',
			'instructions' => 'Add a link to the resource',
			'wrapper' => [
				'width' => '30'
			]
		],
	],
	[
		'taxonomy',
		'Primary Type',
		[
			'name' => 'primary_type',
			'instructions' => 'This field is used to denote the primary category (shown in blue) on the card',
			'taxonomy' => 'content-type',
			'field_type' => 'radio',
			'allow_null' => 0,
			'add_term' => 0,
			'save_terms' => 0,
			'load_terms' => 0,
			'return_format' => 'object',
			'multiple' => 0,
			'wrapper' => [
				'width' => '30'
			]
		],
	],
];

$field_group = core_register_field_group('resource-cpt', $group_args, $fields);

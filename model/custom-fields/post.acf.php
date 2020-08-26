<?php

$group_args = [
	'title' => 'Post Options',
	'location' => [
	    [
	        [
	            'param' => 'post_type',
	            'operator' => '==',
	            'value' => 'post'
	        ],
	    ],
	]
];

$fields = [
	['textarea', 'Featured Post Excerpt', ['name' => 'post_excerpt',]],
	['radio', 'Add Related Content', [
		'key' => 'field_5f1ac70157739',
		'choices' => [
			'yes' => 'Yes',
			'no' => 'No',
		],
		'default_value' => 'yes',
		'layout' => 'horizontal',
		'return_format' => 'value',
	]],
	['text', 'Related Content Header', [
		'conditional_logic' => [
			[
				'field' => 'field_5f1ac70157739',
				'operator' => '==',
				'value' => 'yes',
			]
		],
		'default_value' => 'Related Content',
	]],
	['relationship', 'Related Content', [
		'conditional_logic' => [
			[
				'field' => 'field_5f1ac70157739',
				'operator' => '==',
				'value' => 'yes',
			]
		],
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
		],
		'max' => '4',
		'return_format' => 'id',
	]]
];

$field_group = core_register_field_group('Post', $group_args, $fields);

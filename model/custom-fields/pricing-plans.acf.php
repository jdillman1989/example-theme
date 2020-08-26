<?php

$group_args = [
	'title' => 'Plan Info',
	'location' => [
	    [
	        [
	            'param' => 'post_type',
	            'operator' => '==',
	            'value' => 'pricing_plans'
	        ],
	    ],
	],
	'hide_on_screen' => ['the_content']
];

$fields = [
	['image', 'Icon', ['return_format' => 'array']],
	['image', 'Logo', ['return_format' => 'array']],
	['textarea', 'Description'],
	['repeater', 'Features', [
		'sub_fields' => [
			['wysiwyg', 'Feature Description'],
		],
		'min' => 1,
		'max' => 24,
		'layout' => 'block',
		'button_label' => 'Add Feature'
	]],
	['text', 'Price Prefix'],
	['text', 'Price'],
	['text', 'Price Suffix'],
	['wysiwyg', 'Price Info'],
];

$field_group = core_register_field_group('Plan', $group_args, $fields);
<?php

$group_args = [
	'title' => 'Solutions Template',
	'location' => [
	    [
	        [
	            'param' => 'page_template',
	            'operator' => '==',
	            'value' => 'template/solutions.php'
	        ],
	    ]
	],
	'hide_on_screen' => ['the_content']
];

$fields = [
	// Hero
	['tab', 'Hero', ['placement' => 'left']],
	['text', 'Hero Text'],
	['image', 'Video Image', ['return_format' => 'array']],
	['oembed', 'Hero Video iframe'],

	// Benefits
	['tab', 'Benefits', ['placement' => 'left']],
	['repeater', 'Benefits List', [
		'sub_fields' => [
			['wysiwyg', 'List Content', ['media_upload' => 0]],
		],
		'min' => 1,
		'max' => 6,
		'layout' => 'block',
		'button_label' => 'Add List Item'
	]],
	['image', 'Benefits Image', ['return_format' => 'array']],

	// Features
	['tab', 'Features', ['placement' => 'left']],
	['text', 'Features Title', ['wrapper' => ['width' => '50']]],
	['image', 'Features Image Decoration', ['return_format' => 'id', 'wrapper' => ['width' => '50']]],
	['wysiwyg', 'Features Subtitle', ['media_upload' => 0]],
	['wysiwyg', 'Features Content', ['media_upload' => 0, 'instructions' => 'ul and li elements are styled to look as shown in approved design.']],
	['image', 'Features Image', ['return_format' => 'array']],

	// Remote Learning
	['tab', 'Remote Learning', ['placement' => 'left']],
	['text', 'Remote Learning Title'],
	['text', 'Remote Learning Subtitle'],
	['wysiwyg', 'Remote Learning Content', ['media_upload' => 0]],
	['image', 'Remote Learning Image', ['return_format' => 'array', 'wrapper' => ['width' => '50']]],
	['link', 'Remote Learning Button', ['wrapper' => ['width' => '50']]],

	// Mobile
	['tab', 'Mobile', ['placement' => 'left']],
	['text', 'Mobile Title', ['wrapper' => ['width' => '50']]],
	['image', 'Mobile Image', ['return_format' => 'id', 'wrapper' => ['width' => '50']]],
	['wysiwyg', 'Mobile Item 1', ['media_upload' => 0]],
	['wysiwyg', 'Mobile Item 2', ['media_upload' => 0]],
	['wysiwyg', 'Mobile Item 3', ['media_upload' => 0]],
	['wysiwyg', 'Mobile Item 4', ['media_upload' => 0]],

	// Portfolio
	['tab', 'Portfolio', ['placement' => 'left']],
	['text', 'Portfolio Title', ['wrapper' => ['width' => '50']]],
	['image', 'Portfolio Image', ['return_format' => 'array', 'wrapper' => ['width' => '50']]],
	['repeater', 'Portfolio Items', [
		'sub_fields' => [
			['wysiwyg', 'Item Content', ['media_upload' => 0]],
			['link', 'Item Button'],
		],
		'min' => 1,
		'max' => 6,
		'layout' => 'block',
		'button_label' => 'Add Portfolio Item'
	]],

	// Percentage
	['tab', 'Percentage', ['placement' => 'left']],
	['number', 'Percentage', [
		'min' => 0,
		'max' => 100,
		'step' => 1,
		'wrapper' => ['width' => '33.3333']
	]],
	['image', 'Percentage Image', ['return_format' => 'id', 'wrapper' => ['width' => '33.3333']]],
	['image', 'Percentage Users Image', ['return_format' => 'id', 'wrapper' => ['width' => '33.3333']]],
	['wysiwyg', 'Percentage Content'],
];
$fields = array_merge($fields, $resource_center_cta);

$field_group = core_register_field_group('Solutions', $group_args, $fields);

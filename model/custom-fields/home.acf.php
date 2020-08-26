<?php

$group_args = [
	'title' => 'Homepage',
	'location' => [
	    [
	        [
	            'param' => 'page_type',
	            'operator' => '==',
	            'value' => 'front_page'
	        ],
	    ]
	],
	'hide_on_screen' => ['the_content']
];

$fields = [
	// Hero
	['tab', 'Hero', ['placement' => 'left']],
	['text', 'Hero Top Label'],
	['text', 'Hero Title'],
	['link', 'Hero Button 1', ['return_format' => 'array']],
	['link', 'Hero Button 2', ['return_format' => 'array']],
	['image', 'Hero Image', ['return_format' => 'array']],

	// Partners
	['tab', 'Partners', ['placement' => 'left']],
	['text', 'Partners Title'],
	['gallery', 'Partner Logos', [
		'min' => 3,
		'max' => 12,
		'preview_size' => 'thumbnail',
		'library' => 'all',
	]],

	// Portfolio Types
	['tab', 'Portfolio Types', ['placement' => 'left']],
	['text', 'Portfolio Vertical Label'],
	['repeater', 'Portfolio Items', [
		'sub_fields' => [
			['text', 'Item Title', ['wrapper' => ['width' => '50']]],
			['text', 'Item Button Link', ['wrapper' => ['width' => '50']]],
			['wysiwyg', 'Item Content'],
			['image', 'Item Image', ['return_format' => 'array']]
		],
		'min' => 1,
		'max' => 7,
		'layout' => 'block',
		'button_label' => 'Add Portfolio Item'
	]],

	// Remote Learning
	['tab', 'Remote Learning', ['placement' => 'left']],
	['message', 'Remote Learning', ['message' => 'The content for this section stays the same throughout the site. You can configure the content at Global -> Global Sections -> Remote Learning.']],

	// Features
	['tab', 'Features', ['placement' => 'left']],
	['text', 'Features Title', ['wrapper' => ['width' => '50']]],
	['image', 'Features Image Decoration', ['return_format' => 'id', 'wrapper' => ['width' => '50']]],
	['wysiwyg', 'Features Subtitle', ['media_upload' => 0]],
	['wysiwyg', 'Features Content', ['media_upload' => 0, 'instructions' => 'ul and li elements are styled to look as shown in approved design.']],
	['image', 'Features Image', ['return_format' => 'array']],

	// Post Slider
	['tab', 'Post Slider', ['placement' => 'left']],
	['text', 'Post Slider Vertical Label'],
	['text', 'Post Slider Title'],
	['link', 'Post Slider Button'],
	['relationship', 'Post Slider Items', [
		'post_type' => array('post', 'resource'),
		'filters' => ['search', 'taxonomy', 'post_type'],
		'elements' => ['featured_image'],
		'min' => 3,
		'max' => 24,
		'return_format' => 'id'
	]],

	// Pricing Plans
	['tab', 'Pricing Plans', ['placement' => 'left']],
	['text', 'Pricing Plans Vertical Label'],
	['text', 'Pricing Plans Title'],
	['textarea', 'Pricing Plans Description', ['rows' => '4',]],
	['link', 'Pricing Plans Button'],
	['repeater', 'Pricing Plans Items', [
		'sub_fields' => [
			['image', 'Background Image', ['name' => 'pricing_background_image', 'return_format' => 'id', 'wrapper' => ['width' => '50']]],
			['image', 'Logo', ['name' => 'pricing_plan_logo', 'return_format' => 'id', 'wrapper' => ['width' => '50']]],
			['text', 'Plan Title', ['name' => 'pricing_plan_title']],
			['textarea', 'Description', ['name' => 'pricing_plan_description', 'rows' => '4', 'new_lines' => 'br']],
			['repeater', 'Features', [
				'name' => 'pricing_plan_features',
				'sub_fields' => [
					['text', 'Feature Descriptions', [
						'name' => 'feature_description',
						'instructions' => 'Surround text you would like to underlined with a ' . htmlspecialchars('<strong></strong>') . ' html tag '
					]],
				],
				'min' => 1,
				'max' => 24,
				'layout' => 'table',
				'button_label' => 'Add Feature'
			]],
			['checkbox', 'Best Used For', [
				'name' => 'pricing_usage',
				'choices' => [
					'students' => 'Students',
					'professionals' => 'Professionals',
					'administrators' => 'Administrators',
					'educators' => 'Educators',
					'parents' => 'Parents',
				],
				'return_format' => 'array',
				'layout' => 'horizontal',
				'wrapper' => ['width' => '50'],
			]],
			['link', 'CTA Button', ['name' => 'pricing_plan_button', 'wrapper' => ['width' => '50']]]
		],
		'min' => 1,
		'max' => 3,
		'layout' => 'block',
		'button_label' => 'Add Plan'
	]]
];

$fields = array_merge($fields, $case_studies_fields);

$field_group = core_register_field_group('Home', $group_args, $fields);

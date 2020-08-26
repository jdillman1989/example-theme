<?php

$group_args = [
	'title' => 'Pricing Template',
	'location' => [
	    [
	        [
	            'param' => 'page_template',
	            'operator' => '==',
	            'value' => 'template/pricing.php'
	        ],
	    ]
	],
	'hide_on_screen' => ['the_content']
];

$fields = [
	// Hero
	['tab', 'Hero', ['placement' => 'left']],
	['text', 'Hero Title'],
	['textarea', 'Hero Description'],
	['image', 'Hero Image', ['return_format' => 'array']],

	// Pricing Plans
	['tab', 'Pricing Plans', ['placement' => 'left']],
	['repeater', 'Pricing Plans Items', [
		'sub_fields' => [
			['image', 'Background Image', ['name' => 'pricing_background_image', 'return_format' => 'id', 'wrapper' => ['width' => '50']]],
			['image', 'Logo', ['name' => 'pricing_plan_logo', 'return_format' => 'id', 'wrapper' => ['width' => '50']]],
			['repeater', 'Plan Pricing', [
				'sub_fields' => [
					['text', 'Currency Sign', ['default_value' => '$', 'wrapper' => ['width' => '25']]],
					['text', 'Cost', ['wrapper' => ['width' => '25']]],
					['text', 'Billing Frequency', ['default_value' => 'yr', 'wrapper' => ['width' => '25']]],
					['text', 'Side Note', ['default_value' => 'International prices vary by country.', 'wrapper' => ['width' => '25']]],
					['text', 'Bottom Note']
				],
				'min' => 1,
				'max' => 1,
				'layout' => 'block',
			]],
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
	]],
	['text', 'Pricing Plans CTA Title', ['name'=> 'pricing_plans_cta_title', 'instructions' => 'Used for footer CTA for the pricing page']],

	// Accordion
	['tab', 'Accordion', ['placement' => 'left']],
	['image', 'Accordion Title Image', ['return_format' => 'id', 'wrapper' => ['width' => '50']]],
	['radio', 'Is this an FAQ Accordion', [
		'key' => 'field_is_faq_accordion',
		'name' => 'is_faq_accordion',
		'choices' => [
			'yes' => 'Yes',
			'no' => 'No',
		],
		'default_value' => 'no',
		'layout' => 'horizontal',
		'return_format' => 'value',
		'wrapper' => ['width' => '50']
	]],
	['text', 'Accordion Title'],
	['repeater', 'Accordion Elements', [
		'sub_fields' => [
			['text', 'Accordion Title'],
			['wysiwyg', 'Accordion Content', ['media_upload' => 0,]],
		],
		'min' => 1,
		'max' => 20,
		'layout' => 'block',
		'button_label' => 'Add Accordion Item'
	]],

	// Callout
	['tab', 'Callout', ['placement' => 'left']],
	['text', 'Callout Title'],
	['wysiwyg', 'Callout Content', ['media_upload' => 0,]],
];
$fields = array_merge($fields, $case_studies_fields);
$fields = array_merge($fields, $resource_center_cta);

$field_group = core_register_field_group('Solutions', $group_args, $fields);

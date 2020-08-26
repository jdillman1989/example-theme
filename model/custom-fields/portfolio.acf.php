<?php

$group_args = [
	'title' => 'Portfolio Template',
	'location' => [
	    [
	        [
	            'param' => 'page_template',
	            'operator' => '==',
	            'value' => 'template/portfolio.php'
	        ],
	    ]
	],
	'hide_on_screen' => ['the_content']
];

$connection_options = [
	'students' => 'Students',
	'educators' => 'Educators',
	'admin' => 'Admin',
	'parents' => 'Parents',
];

$fields = [
	// Hero
	['tab', 'Hero', ['placement' => 'left']],
	['image', 'Hero Image', [
		'return_format' => 'array',
		'wrapper' => ['width' => '50'],
	]],
	['image', 'Hero Text Decoration Image', [
		'return_format' => 'id',
		'wrapper' => ['width' => '50'],
	]],
	['textarea', 'Hero Title', [
		'rows' => '2',
		'new_lines' => 'br',
	]],
	['wysiwyg', 'Hero Content'],



	// Benefits
	['tab', 'Benefits', ['placement' => 'left']],
	['text', 'Benefits Title'],
	['repeater', 'Benefits Items', [
		'sub_fields' => [
			['image', 'Item Image', ['return_format' => 'array']],
			['textarea', 'Item Heading', [
				'rows' => '2',
				'new_lines' => 'br',
			]],
			['textarea', 'Item Content', [
				'rows' => '4',
				'new_lines' => 'br',
			]],
		],
		'min' => 1,
		'max' => 4,
		'layout' => 'block',
		'button_label' => 'Add Benefits Item'
	]],

	// Features
	['tab', 'Features', ['placement' => 'left']],
	['text', 'Features Title', ['wrapper' => ['width' => '50']]],
	['image', 'Features Phone Image', ['return_format' => 'id', 'wrapper' => ['width' => '50']]],
	['repeater', 'Features List Left', [
		'sub_fields' => [
			['text', 'List Text'],
		],
		'min' => 1,
		'max' => 10,
		'layout' => 'block',
		'button_label' => 'Add Left List Item',
		['wrapper' => ['width' => '50']]
	]],
	['repeater', 'Features List Right', [
		'sub_fields' => [
			['text', 'List Text'],
		],
		'min' => 0,
		'max' => 10,
		'layout' => 'block',
		'button_label' => 'Add Right List Item',
		['wrapper' => ['width' => '50']]
	]],

	// Ecosystem
	// Weird layout for 'default_value' is to take into account line breaks automatically
	['tab', 'Ecosystem', ['placement' => 'left']],
	['radio', 'Hide Ecosystem Section?', [
		'key' => 'field_hide_ecosystem_chart',
		'name' => 'hide_ecosystem_chart',
		'layout' => 'horizontal',
		'choices' => ['yes' => 'Yes', 'no' => 'No'],
		'default_value' => 'no',
	]],
	['textarea', 'Ecosystem Title', [
		'rows' => '2',
		'new_lines' => 'br',
		'default_value' => 'bulb connects
students, teachers,
schools & families.',
		'conditional_logic' => [
			[
				'field' => 'field_hide_ecosystem_chart',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],
	['wysiwyg', 'Ecosystem Content', [
		'default_value' => 'See how bulb connects people by clicking through the interactive graphic to your right.',
		'conditional_logic' => [
			[
				'field' => 'field_hide_ecosystem_chart',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],
		// Default
	['textarea', 'Default Title', [
		'rows' => '2',
		'new_lines' => 'br',
		'default_value' => 'bulb Ecosystem',
		'conditional_logic' => [
			[
				'field' => 'field_hide_ecosystem_chart',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],
	['textarea', 'Default Content', [
		'rows' => '4',
		'new_lines' => 'br',
		'default_value' => 'Click on a name to see how they connect',
		'conditional_logic' => [
			[
				'field' => 'field_hide_ecosystem_chart',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],
		// Students
	['message', 'Student Data', [
		'message' => 'Set up graphical connections and text for Students',
		'conditional_logic' => [
			[
				'field' => 'field_hide_ecosystem_chart',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],
	['checkbox', 'Students Connections', [
		'choices' => $connection_options,
		'default_value' => [
			'parents',
			'educators'
		],
		'conditional_logic' => [
			[
				'field' => 'field_hide_ecosystem_chart',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],
	['textarea', 'Students Title', [
		'rows' => '2',
		'new_lines' => 'br',
		'default_value' => 'Student',
		'conditional_logic' => [
			[
				'field' => 'field_hide_ecosystem_chart',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],
	['textarea', 'Students Text', [
		'rows' => '4',
		'new_lines' => 'br',
		'default_value' => 'Show their smarts to parents & educators.',
		'conditional_logic' => [
			[
				'field' => 'field_hide_ecosystem_chart',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],
		// Admin
	['message', 'Admin Data', [
		'message' => 'Set up graphical connections and text for Admins',
		'conditional_logic' => [
			[
				'field' => 'field_hide_ecosystem_chart',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],
	['checkbox', 'Admin Connections', [
		'choices' => $connection_options,
		'default_value' => [
			'educators'
		],
		'conditional_logic' => [
			[
				'field' => 'field_hide_ecosystem_chart',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],
	['textarea', 'Admin Title', [
		'rows' => '2',
		'new_lines' => 'br',
		'default_value' => 'Admin',
		'conditional_logic' => [
			[
				'field' => 'field_hide_ecosystem_chart',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],
	['textarea', 'Admin Text', [
		'rows' => '4',
		'new_lines' => 'br',
		'default_value' => 'Communicate & share resources with educators.',
		'conditional_logic' => [
			[
				'field' => 'field_hide_ecosystem_chart',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],
		// Parents
	['message', 'Parent Data', [
		'message' => 'Set up graphical connections and text for Parents',
		'conditional_logic' => [
			[
				'field' => 'field_hide_ecosystem_chart',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],
	['checkbox', 'Parents Connections', [
		'choices' => $connection_options,
		'default_value' => [
			'students',
			'educators'
		],
		'conditional_logic' => [
			[
				'field' => 'field_hide_ecosystem_chart',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],
	['textarea', 'Parent Title', [
		'rows' => '2',
		'new_lines' => 'br',
		'default_value' => 'Parents',
		'conditional_logic' => [
			[
				'field' => 'field_hide_ecosystem_chart',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],
	['textarea', 'Parents Text', [
		'rows' => '4',
		'new_lines' => 'br',
		'default_value' => 'Engage in classroom work & conversations with educators.',
		'conditional_logic' => [
			[
				'field' => 'field_hide_ecosystem_chart',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],
		// Educators
	['message', 'Educators Data', [
		'message' => 'Set up graphical connections and text for Educators',
		'conditional_logic' => [
			[
				'field' => 'field_hide_ecosystem_chart',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],
	['checkbox', 'Educators Connections', [
		'choices' => $connection_options,
		'default_value' => [
			'parents',
			'students',
			'admin'
		],
		'conditional_logic' => [
			[
				'field' => 'field_hide_ecosystem_chart',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],
	['textarea', 'Educators Title', [
		'rows' => '2',
		'new_lines' => 'br',
		'default_value' => 'Educator',
		'conditional_logic' => [
			[
				'field' => 'field_hide_ecosystem_chart',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],
	['textarea', 'Educators Text', [
		'rows' => '4',
		'new_lines' => 'br',
		'default_value' => 'Update parents, teach students, & share with admins.',
		'conditional_logic' => [
			[
				'field' => 'field_hide_ecosystem_chart',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],

	// Resource Info
	['tab', 'Resource Info', ['placement' => 'left']],
	['image', 'Resource Info Image', ['return_format' => 'array', 'wrapper' => ['width' => '50']]],
	['image', 'Resource Info Text Decoration', ['return_format' => 'id', 'wrapper' => ['width' => '50']]],
	['textarea', 'Resource Info Title', [
		'rows' => '2',
		'new_lines' => 'br',
	]],
	['wysiwyg', 'Resource Info Left Content', ['media_upload' => 0]],
	['link', 'Resource Info Left Button'],
	['wysiwyg', 'Resource Info Right Content', ['media_upload' => 0, 'instructions' => 'All ul and li html elements are styled to include checkmarks within this specific content area.']],

	// Remote Learning
	['tab', 'Remote Learning', ['placement' => 'left']],
	['message', 'Remote Learning', ['message' => 'The content for this section stays the same throughout the site. You can configure the content at Global -> Global Sections -> Remote Learning.']],
	['radio', 'Hide Remove Learning Section?', [
		'key' => 'field_hide_remote_learning_section',
		'name' => 'hide_remote_learning_section',
		'layout' => 'horizontal',
		'choices' => ['yes' => 'Yes', 'no' => 'No'],
		'default_value' => 'no',
	]],
];
$fields = array_merge($fields, $case_studies_fields);

$field_group = core_register_field_group('Portfolio', $group_args, $fields);

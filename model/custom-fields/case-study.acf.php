<?php

$group_args = [
	'title' => 'Case Study CTA Options',
	'location' => [
	    [
		    [
			    'param' => 'post_type',
			    'operator' => '==',
			    'value' => 'post'
		    ],
	        [
	            'param' => 'post_taxonomy',
	            'operator' => '==',
	            'value' => 'content-type:case-studies'
	        ],
	    ],
		[
			[
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post'
			],
			[
				'param' => 'post_taxonomy',
				'operator' => '==',
				'value' => 'content-type:user-stories'
			],
		],
	]
];

$fields = [
	['image', 'Profile Image', ['return_format' => 'array', 'wrapper' => ['width' => '50'], 'required' => 0]],
	['image', 'Icon', ['return_format' => 'array', 'wrapper' => ['width' => '50'], 'required' => 0]],
	['text', 'User Name', ['wrapper' => ['width' => '50'], 'required' => 0]],
	['text', 'User Role', ['wrapper' => ['width' => '50'], 'required' => 0]],
	['textarea', 'Quote', ['required' => 0]],
];

$field_group = core_register_field_group('Study', $group_args, $fields);

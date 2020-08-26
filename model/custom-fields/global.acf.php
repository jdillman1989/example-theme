<?php

$group_args = [
	'title' => 'Global Site Sections',
	'location_is' => [ 'options_page', 'global-sections' ],
	'hide_on_screen' => ['the_content']
];

$fields = [
	// Site Scripts
	['tab', 'Site Scripts', ['placement' => 'left']],
	['textarea', 'Scripts Right After Opening Header Tag'],
	['textarea', 'Scripts Right After Opening Body Tag'],
	['textarea', 'Scripts Right Before Closing Body Tag'],

	// Remote Learning
	['tab', 'Remote Learning', ['placement' => 'left']],
	['text', 'Remote Learning Title'],
	['repeater', 'Remote Learning Items', [
		'sub_fields' => [
			['image', 'Item Icon', ['return_format' => 'array', 'wrapper' => ['width' => '50']]],
			['text', 'Item Label', ['wrapper' => ['width' => '50']]],
			['wysiwyg', 'Item Content'],
			['link', 'Item Button', ['return_format' => 'array', 'wrapper' => ['width' => '50']]],
			['image', 'Item Image', ['return_format' => 'array', 'wrapper' => ['width' => '50']]]
		],
		'min' => 1,
		'max' => 3,
		'layout' => 'block',
		'button_label' => 'Add Remote Learning Item'
	]],

	// Footer
	['tab', 'Contact Bar', ['placement' => 'left']],
	['textarea', 'Title', ['name' => 'contact_bar_title', 'rows' => '2', 'new_lines' => 'br']],
	['textarea', 'Subtitle', ['name' => 'contact_bar_subtitle', 'rows' => '2', 'new_lines' => 'br']],
	['link', 'CTA Button', ['return_format' => 'array', 'name' => 'contact_bar_cta']],

	// Footer
	['tab', 'Footer', ['placement' => 'left']],
	['text', 'Left Title'],
	['link', 'Left Button', ['return_format' => 'array']],
];

$field_group = core_register_field_group('global-sections', $group_args, $fields);

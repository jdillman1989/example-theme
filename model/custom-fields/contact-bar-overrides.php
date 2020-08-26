<?php
$group_args = [
	'title' => 'Contact Bar Overrides',
	'menu_order' => 999,
	'location' => [
		[
			[
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			],
		],
		[
			[
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			],
			[
				'param' => 'page_template',
				'operator' => '!=',
				'value' => 'template/resource-catalog.php',
			],
			[
				'param' => 'page_template',
				'operator' => '!=',
				'value' => 'template/post-catalog.php',
			],
		],
	]
];

$fields = [
	['radio', 'Hide Contact Bar?', [
		'key' => 'field_override_hide_contact_bar',
		'name' => 'field_override_hide_contact_bar',
		'wrapper' => ['width' => '50'],
		'layout' => 'horizontal',
		'choices' => ['yes' => 'Yes', 'no' => 'No'],
		'default_value' => 'no',
	]],
	['radio', 'Override Contact Bar Elements?', [
		'key' => 'field_override_contact_bar_elements',
		'name' => 'field_override_contact_bar_elements',
		'wrapper' => ['width' => '50'],
		'layout' => 'horizontal',
		'choices' => ['yes' => 'Yes', 'no' => 'No'],
		'default_value' => 'no',
		'conditional_logic' => [
			[
				'field' => 'field_override_hide_contact_bar',
				'operator' => '==',
				'value' => 'no',
			]
		],
	]],
	['textarea', 'Title', [
		'name' => 'field_override_contact_bar_title',
		'rows' => '2',
		'new_lines' => 'br',
		'conditional_logic' => [
			[
				'field' => 'field_override_hide_contact_bar',
				'operator' => '==',
				'value' => 'no',
			],
			[
				'field' => 'field_override_contact_bar_elements',
				'operator' => '==',
				'value' => 'yes',
			]
		],
	]],
	['textarea', 'Subtitle', [
		'name' => 'field_override_contact_bar_subtitle',
		'rows' => '2',
		'new_lines' => 'br',
		'conditional_logic' => [
			[
				'field' => 'field_override_hide_contact_bar',
				'operator' => '==',
				'value' => 'no',
			],
			[
				'field' => 'field_override_contact_bar_elements',
				'operator' => '==',
				'value' => 'yes',
			]
		],
	]],
	['link', 'CTA Button', [
		'return_format' => 'array',
		'name' => 'field_override_contact_bar_cta',
		'wrapper' => ['width' => '50'],
		'conditional_logic' => [
			[
				'field' => 'field_override_hide_contact_bar',
				'operator' => '==',
				'value' => 'no',
			],
			[
				'field' => 'field_override_contact_bar_elements',
				'operator' => '==',
				'value' => 'yes',
			]
		],
	]],
	['radio', 'Add Chat Icon?', [
		'key' => 'field_override_contact_bar_add_chat_icon',
		'name' => 'field_override_contact_bar_add_cat_icon',
		'wrapper' => ['width' => '50'],
		'layout' => 'horizontal',
		'choices' => ['yes' => 'Yes', 'no' => 'No'],
		'default_value' => 'no',
		'conditional_logic' => [
			[
				'field' => 'field_override_hide_contact_bar',
				'operator' => '==',
				'value' => 'no',
			],
			[
				'field' => 'field_override_contact_bar_elements',
				'operator' => '==',
				'value' => 'yes',
			]
		],
	]],
	['textarea', 'Chat Bot Script', [
		'instructions' => 'Place the JavaScript snippet for your chat bot here. Note: The chat icon html will have an ID of `chat-icon-js-trigger` which should be used to trigger/toggle opening the chat bot.',
		'conditional_logic' => [
			[
				'field' => 'field_override_contact_bar_add_chat_icon',
				'operator' => '==',
				'value' => 'yes',
			],
		]
	]]
];

$field_group = core_register_field_group('Contact-Overrides', $group_args, $fields);

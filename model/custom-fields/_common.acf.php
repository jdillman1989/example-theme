<?php

$case_studies_fields = [
	['tab', 'Case Studies', ['placement' => 'left']],
	['text', 'Case Studies Vertical Label', ['default_value' => 'Case Studies', 'instructions' => 'Optional, remove to hide element']],
	['text', 'Case Studies Title', ['wrapper' => ['width' => '50'], 'default_value' => 'Case Studies']],
	['link', 'Case Studies CTA Button', ['name' => 'case_studies_cta', 'wrapper' => ['width' => '50']]],
	['relationship', 'Case Study Items', [
		'instructions' => 'Posts selected from this list are specifically tied to either the case-studies or user-stories taxonomies. If a post is added to this section and elements do not show up on the front end, edit the post and fill in the Case Study CTA Options to properly display content.',
		'post_type' => array('post'),
		'taxonomy' => ['content-type:case-studies', 'content-type:user-stories'],
		'filters' => ['search', 'taxonomy'],
		'elements' => ['featured_image'],
		'min' => 3,
		'max' => 24,
		'return_format' => 'id'
	]],
];

$resource_center_cta = [
	['tab', 'Resource Center CTA', ['placement' => 'left']],
	['text', 'Resource Center CTA Title'],
	['wysiwyg', 'Resource Center CTA Content', ['media_upload' => 0,]],
	['link', 'Resource Center CTA Button', ['wrapper' => ['width' => '50']]],
	['image', 'Resource Center Image', ['return_format' => 'array', 'wrapper' => ['width' => '50']]],
];

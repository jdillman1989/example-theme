<?php
/** Register Resources Post Type */
core_post_type('Resources', [
		'slug' => 'resource',
		'supports' => ['title', 'thumbnail'],
		'taxonomies' => ['audiences', 'content-type', 'topics'],
		'hierarchical' => false,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-portfolio',
		'can_export' => false,
		'has_archive' => false,
		'publicly_queryable' => false,
		'capability_type' => 'page'
	]
);

/** Register Taxonomies */
core_taxonomy('Audiences', 'Audiences', ['post', 'resource'], [
	'id' => 'audiences',
	'rewrite' => [
		'slug' => 'h/audiences',
		'with_front' => true,
		'pages' => true,
		'feeds' => true
	]
]);
core_taxonomy('Topics', 'Topics', ['post', 'resource'], [
	'id' => 'topics',
	'rewrite' => [
		'slug' => 'h/topics',
		'with_front' => true,
		'pages' => true,
		'feeds' => true
	]
]);
core_taxonomy('Content Types', 'Types', ['post', 'resource'], [
	'id' => 'content-type',
	'rewrite' => [
		'slug' => 'h/content-type',
		'with_front' => true,
		'pages' => true,
		'feeds' => true
	]
]);

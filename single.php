<?php
/**
 * The Template for displaying all single posts
 */

$context = Timber::context();
$timber_post = Timber::query_post();
$context['post'] = $timber_post;

$topics_terms = get_the_terms( $post->ID, 'topics');
$topics_term_ids = [];

if ($topics_terms) {
	foreach ( $topics_terms as $term ) {
		$topics_term_ids[] = $term->term_id;
	}
}

$category_terms = get_the_terms( $post->ID, 'category');
$category_term_ids = [];

if ($category_terms) {
	foreach ( $category_terms as $term ) {
		$category_term_ids[] = $term->term_id;
	}
}



$user_set_related_posts = get_field('related_content');
$query_user_posts = [];
$query_related_tax_posts = [];
if ( $user_set_related_posts ) {
	$query_user_posts = Timber::get_posts([
		'post_status' => 'publish',
		'post_type' => ['post', 'resource'],
		'post__in' => $user_set_related_posts,
		'orderby' => 'post__in'
	]);


	if (count($query_user_posts) < 4) {
		$query_related_tax_posts = Timber::get_posts([
			'post_status' => 'publish',
			'post_type' => ['post', 'resource'],
			'posts_per_page' => 4 - count($query_user_posts),
			'post__not_in' => array_merge($user_set_related_posts, [$post->ID]),
			'orderby' => 'rand',
			'tax_query' => [
				'relation' => 'OR',
				[
					'taxonomy' => 'topics',
					'field' => 'id',
					'terms' => $topics_term_ids,
					'operator' => 'IN'
				],
				[
					'taxonomy' => 'category',
					'field' => 'id',
					'terms' => $category_term_ids,
					'operator' => 'IN'
				]
			]
		]);
	}

} else {
	$query_related_tax_posts = Timber::get_posts([
		'post_status' => 'publish',
		'post_type' => ['post', 'resource'],
		'posts_per_page' => 4,
		'post__not_in' => [$post->ID],
		'orderby' => 'rand',
		'tax_query' => [
			'relation' => 'OR',
			[
				'taxonomy' => 'topics',
				'field' => 'id',
				'terms' => $topics_term_ids,
				'operator' => 'IN'
			],
			[
				'taxonomy' => 'category',
				'field' => 'id',
				'terms' => $category_term_ids,
				'operator' => 'IN'
			]
		]
	]);
}


$context['related_content'] = array_merge($query_user_posts, $query_related_tax_posts);


Timber::render( array( 'pages/single-' . $timber_post->ID . '.twig', 'pages/single-' . $timber_post->post_type . '.twig', 'pages/single-' . $timber_post->slug . '.twig', 'pages/single.twig' ), $context );

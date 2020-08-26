<?php
/* Template Name: Solutions */

$context = Timber::get_context();

$context['post'] = new TimberPost();

$context['posts'] = Timber::get_posts(array(
	'post_type' => 'post'
));

Timber::render('pages/solutions.twig', $context);

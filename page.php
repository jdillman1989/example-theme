<?php
/**
 * The template for displaying all pages.
 *
 */

$context = Timber::context();

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
Timber::render( 'pages/default.twig', $context );

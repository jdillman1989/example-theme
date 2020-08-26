<?php /* Template Name: Front Page */
$context = Timber::get_context();

$context['post'] = new TimberPost();

$context = get_case_studies($context);

Timber::render('pages/home.twig', $context);

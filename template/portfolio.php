<?php
/* Template Name: Portfolio */

$context = Timber::get_context();

$context['post'] = new TimberPost();
$context = get_case_studies($context);

$context['eco_options'] = ['educators', 'students', 'parents', 'admin'];

Timber::render('pages/portfolio.twig', $context);

<?php
/* Template Name: Resource Catalog */

$context = Timber::get_context();

$context['post'] = new TimberPost();

$context = archive_page_template($context, 'resource');

Timber::render('pages/catalog.twig', $context);
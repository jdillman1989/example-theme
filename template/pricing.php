<?php
/* Template Name: Pricing */

$context = Timber::get_context();

$context['post'] = new TimberPost();
$context = get_case_studies($context);
//$context = get_pricing_plans($context);

$context['preselected'] = isset($_GET['selected_plan']) ? $_GET['selected_plan'] : '-1';

Timber::render('pages/pricing.twig', $context);

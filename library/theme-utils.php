<?php

/**
 * assetUrl
 *
 * Return the formated static asset URL
 * from inside the theme directory.
 *
 * @type function
 * @since 0.0.1
 *
 * @param string $path
 * @return string
 */
function assetUrl(string $path) {
	return TPL_URL."/src/assets/{$path}";
}

if( !function_exists('log_data') ) {
	function log_data($data, $label=false) {
		if ($label) {
			echo '<pre style="'
				.'padding: 15px;'
				.'background: #667;'
				.'color: #FEE;'
				.'border-radius: 3px;'
				.'margin: 5px;'
				.'font-size: 18px;'
				.'">';
			echo $label;
			echo '</pre>';
		}
		echo '<pre style="'
			.'padding: 15px;'
			.'background: #335;'
			.'color: #FEE;'
			.'border-radius: 3px;'
			.'margin: 5px;'
			.'font-size: 12px;'
			.'">';
		print_r($data);
		echo '</pre>';
	}
}

/**
 * archive_filter_get_data
 *
 * Return posts for archive filter ajax requests
 *
 * @type function
 * @since 0.0.1
 *
 */
add_action( 'wp_ajax_archive_filter', 'archive_filter_get_data' );
add_action( 'wp_ajax_nopriv_archive_filter', 'archive_filter_get_data' );

function archive_filter_get_data() {
	$data_args = ['post_type' => $_GET['type']];
	$data_args['paged'] = (isset($_GET['next'])) ? intval($_GET['next']) : 1;
	$data_args['posts_per_page'] = (isset($_GET['s'])) ? -1 : $_GET['ppp'];
	$data_args['s'] = (isset($_GET['s'])) ? $_GET['s'] : null;
	$data_args['orderby'] = 'date title';
    $data_args['order'] = 'DESC';

	if (isset($_GET['tax'])) {
		foreach ($_GET['tax'] as $tax => $term) {
			if ($term != 'all' ) {
				$data_args['tax_query']['relation'] = 'AND';
				$data_args['tax_query'][] = [
          			'taxonomy' => $tax,
          			'field' => 'slug',
          			'terms' => $term
				];
			}
		}
	}

	$post_data = new WP_Query($data_args);

	$post_results = ['max' => $post_data->max_num_pages];
	if ($post_data->have_posts()) {

		while($post_data->have_posts()) {
			$post_data->the_post();

			$primary_category = ( get_field('primary_type') ) ? get_field('primary_type') : get_the_terms( get_the_ID(), 'content-type' )[0];
			$this_post = [];
			$this_post['image'] = false;
			if (has_post_thumbnail()){
				$this_post['image'] = get_the_post_thumbnail_url();
			}

			$this_post['title'] = get_the_title();
			$this_post['url'] = ( get_field('external_link') ) ? get_field('external_link') : get_permalink();
			$this_post['date'] = get_the_date('F j, Y');
			$this_post['categoryName'] = $primary_category ? $primary_category->name : '';
			$this_post['categoryUrl'] = $primary_category ? get_term_link( $primary_category->term_id ) : '';

			$post_results['data'][] = $this_post;
		}
		wp_reset_postdata();
	}
	else{
		$post_results['data'] = [];
	}

	$response = json_encode($post_results);

    echo $response;
    wp_die();
}

/**
 * archive_page_template
 *
 * Build post archive page templates
 *
 * @type function
 * @since 0.0.1
 *
 * @param array $context
 * @param boolean $is_archive
 * @return array
 */
function archive_page_template($context, $type = 'post', $is_archive = false) {

	$tax_query = ($is_archive) ? get_query_var('taxonomy') : 'all';
	$term_query = ($is_archive) ? get_query_var('term') : 'all';
	$type = ($is_archive) ? get_post_type() : $type;
	if (is_category()) {
		$tax_query = 'category';
		$term_query = get_query_var('category_name');
	}
	$term_label = ($is_archive) ? get_term_by('slug', $term_query, $tax_query)->name : 'All';
	$context['tax_query'] = $tax_query;
	$context['term_query'] = $term_query;
	$context['term_label'] = $term_label;

	// Taxonomy Data
	$taxonomies = get_object_taxonomies($type, 'objects');
	$context['hide_filter'] = '';
	$context['taxonomies'] = [];
	$tax_page = [];
	foreach ($taxonomies as $tax) {

		$tax_page[$tax->name] = 'all';
		$hidden_class = '';
		if ($is_archive && $tax->name == $tax_query) {
			$tax_page[$tax->name] = $term_query;
			$hidden_class = 'hidden';
			$context['hide_filter'] = 'hidden-filter';
		}

		if ($tax->name == 'category' || $tax->name == 'post_tag' || $tax->name == 'post_format') {
			continue;
		}

		$terms = get_terms(['taxonomy' => $tax->name, 'hide_empty' => true]);
		$context_terms = [];
		foreach ($terms as $term) {
			$term_link = get_term_link($term);
			if (is_wp_error($term_link)) {
				continue;
			}
			$context_terms[] = [
				'label' => $term->name,
				'slug' => $term->slug,
				'link' => $term_link
			];
		}

		$context['taxonomies'][] = [
			'label' => $tax->label,
			'slug' => $tax->name,
			'terms' => $context_terms,
			'hidden_class' => $hidden_class
		];
	}

	// Post List
	$ppp = 8;
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$posts_args = [
		'post_type' => $type,
		'posts_per_page' => $ppp,
		'paged' => $paged,
		'orderby' => 'date title',
		'order' => 'DESC'
	];
	if ($is_archive) {
		$posts_args['tax_query'] = [
			[
				'taxonomy' => $tax_query,
				'field'    => 'slug',
				'terms'    => $term_query,
			],
		];
	}
	$posts = new WP_Query($posts_args);
	$context['posts'] = Timber::get_posts($posts);

	// Pagination
	$tax_page_data = json_encode($tax_page);
	$next = $paged + 1;
	$next_link_disabled = ($next > $posts->max_num_pages) ? 'disabled' : '';
	$admin_ajax = admin_url('admin-ajax.php');
	$next_button = '<button id="morePosts"'
						.'data-type="'.$type.'" '
						.'data-next="'.$next.'" '
						.'data-ppp="'.$ppp.'" '
						.'data-max="'.$posts->max_num_pages.'" '
						.'data-tax=\''.$tax_page_data.'\' '
						.'data-action="'.$admin_ajax.'?action=archive_filter" '
						.'data-s="" '
						.'class="more-posts '.$next_link_disabled.'">'
						.'Load More Listings'
					.'</button>';

	$context['next_button'] = $next_button;

	return $context;
}

/**
 * get_case_studies
 *
 * Build case studies data for any twig context
 *
 * @type function
 * @since 0.0.1
 *
 * @param array $context
 * @return array
 */
function get_case_studies($context) {

	$context['case_studies_vertical_label'] = get_field('case_studies_vertical_label');
	$context['case_studies_title'] = get_field('case_studies_title');
	$context['case_studies_cta'] = get_field('case_studies_cta');

	$case_studies = get_field('case_study_items');
	$studies = [];
	foreach ($case_studies as $post_id) {
		$studies[] = [
			'profile_image' => get_field('profile_image', $post_id),
			'icon' => get_field('icon', $post_id),
			'user_name' => get_field('user_name', $post_id),
			'user_role' => get_field('user_role', $post_id),
			'quote' => get_field('quote', $post_id),
			'url' => get_permalink($post_id),
		];
	}

	$context['case_studies'] = $studies;

	return $context;
}

/**
 * get_pricing_plans
 *
 * Build pricing plans data for any twig context
 *
 * @type function
 * @since 0.0.1
 *
 * @param array $context
 * @param boolean $full
 * @return array
 */
function get_pricing_plans($context, $full = true) {

	$plans = get_field('pricing_plans_items');
	$pricing_plans = [];
	foreach ($plans as $plan) {
		$this_post = $plan['select_pricing_plan'];
		$get_uses = get_the_terms($this_post, 'use');
		$uses = [];
		foreach ($get_uses as $use) {
			$uses[] = [
				'slug' => $use->slug,
				'label' => $use->name
			];
		}

		$pricing_plans[] = [
			'title' => $this_post->post_title,
			'icon' => get_field('icon', $this_post),
			'logo' => get_field('logo', $this_post),
			'description' => get_field('description', $this_post),
			'features' => get_field('features', $this_post),
			'uses' => $uses,
			'price' => [
				'prefix' => get_field('price_prefix', $this_post),
				'value' => get_field('price', $this_post),
				'suffix' => get_field('price_suffix', $this_post),
				'info' => get_field('price_info', $this_post),
			],
			'button' => $plan['pricing_plan_button']
		];
	}

	$context['pricing_plans'] = $pricing_plans;

	return $context;
}

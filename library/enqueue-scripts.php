<?php
if ( ! function_exists( 'jd_scaffold_scripts' ) ) :
	function jd_scaffold_scripts() {

		// Deregister the jquery version bundled with WordPress.
		wp_deregister_script( 'jquery' );

		// CDN hosted jQuery placed in the header, as some plugins require that jQuery is loaded in the header.
		wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js', array(), '3.5.1', false );

		// Deregister the jquery-migrate version bundled with WordPress.
		wp_deregister_script( 'jquery-migrate' );

		// CDN hosted jQuery migrate for compatibility with jQuery 3.x
		wp_register_script( 'jquery-migrate', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.3.0/jquery-migrate.min.js', array('jquery'), '3.3.0', false );

		// Enqueue jQuery migrate. Uncomment the line below to enable.
		// wp_enqueue_script( 'jquery-migrate' );

		// Add the comment-reply library on pages where it is necessary
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Register jQuery Bez
		wp_register_script( 'jquery-bez', TPL_URL.'/vendor-js/bez/jquery.bez.js', array('jquery'), '1.0.11', false );

		// Enqueue jQuery Bez
		wp_enqueue_script( 'jquery-bez' );

		// Register Owl Carousel
		wp_register_script( 'owl-carousel', TPL_URL.'/vendor-js/owl-carousel/owl.carousel.min.js', array('jquery'), '2.3.4', false );
		wp_register_style( 'owl-carousel', TPL_URL.'/vendor-js/owl-carousel/owl.carousel.min.css', array(), '2.3.4' );

		// Enqueue Owl Carousel
		if (is_front_page() ||
			is_singular('post') ||
			is_page_template(['template/solutions.php', 'template/portfolio.php', 'template/pricing.php'])) {
			wp_enqueue_script( 'owl-carousel' );
			wp_enqueue_style( 'owl-carousel' );
		}
	}

	add_action( 'wp_enqueue_scripts', 'jd_scaffold_scripts' );
endif;

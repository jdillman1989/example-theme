<?php

/**
 * bulb_button_shortcode
 *
 * create any variation of site buttons with [bulb_button]
 *
 * @type function
 * @since 0.0.1
 *
 * @param array $atts
 * @param string $content
 * @return string
 */
function bulb_button_shortcode($atts, $content = null) {

	$a = shortcode_atts([
		'variation' => 'filled',
		'size' => 'normal',
		'style' => 'primary',
		'href' => '#',
		'external' => false
	], $atts);

	$btn_classes = [ 
		'btn',
		'btn--var-'.$a['variation'],
		'btn--size-'.$a['size'],
		'btn--style-'.$a['style']
	];
	$external = ($a['external']) ? 'target="_blank" rel="noopener noreferrer"' : '';
	$icon = file_get_contents( __DIR__ . '/../src/assets/img/dev/general/button-arrow.svg' );

	return '<a class="'.implode(" ", $btn_classes).'" href="'.$a['href'].'" '.$external.'>'
				.'<span class="btn__text">'.$content.'</span>'
				.'<span class="btn__icon">'.$icon.'</span>'
			.'</a>';
}

add_shortcode('bulb_button', 'bulb_button_shortcode');
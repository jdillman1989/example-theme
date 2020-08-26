<?php
/*removing default submit tag*/
remove_action('wpcf7_init', 'wpcf7_add_form_tag_submit');
/*adding action with function which handles our button markup*/
add_action('wpcf7_init', 'jd_scaffold_cf7_button');
/*adding out submit button tag*/
if (!function_exists('jd_scaffold_cf7_button')) {
	function jd_scaffold_cf7_button() {
		wpcf7_add_form_tag('submit', 'jd_scaffold_cf7_button_handler');
	}
}
/*out button markup inside handler*/
if (!function_exists('jd_scaffold_cf7_button_handler')) {
	function jd_scaffold_cf7_button_handler($tag) {
		$tag = new WPCF7_FormTag($tag);
		$class = wpcf7_form_controls_class($tag->type);
		$atts = array();
		$atts['class'] = $tag->get_class_option($class);
		$atts['class'] .= 'contact-form-7-submit';
		$atts['id'] = $tag->get_id_option();
		$atts['tabindex'] = $tag->get_option('tabindex', 'int', true);
		$value = isset($tag->values[0]) ? $tag->values[0] : '';
		if (empty($value)) {
			$value = esc_html__('Send', 'twentysixteen');
		}
		$atts['type'] = 'submit';
		$atts = wpcf7_format_atts($atts);
		$html = sprintf('<button class="btn btn--var-filled btn--size-normal btn--style-primary"><span class="btn__text">%2$s</span><span class="btn__icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="22px" height="21px" viewBox="0 0 22 21"><path fill-rule="evenodd" d="M3.071,20.972 L17.555,5.779 L16.772,18.489 L19.900,18.180 L21.020,0.022 L3.143,1.789 L2.947,4.967 L15.461,3.730 L0.976,18.923 L3.071,20.972 Z"></path></svg>
	</span></button>', $atts, $value);
		return $html;
	}
}

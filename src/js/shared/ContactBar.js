export default class {

	/**
	 * setup
	 *
	 * Adds the sticky functionality to the
	 * contact bar component.
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	setup() {
		const contactBarElement = document.getElementById( 'contact-bar' );
		if ( ! contactBarElement ) return;

		/** Toggles the sticky state */
		const toggleSticky = () => {
			const { scrollY, innerHeight } = window;
			const { offsetTop: footerOffsetTop } = document.getElementById( 'footer' );

			const a = ( scrollY + innerHeight ) > footerOffsetTop ? 'add' : 'remove';
			contactBarElement.classList[a]( 'contact-bar--sticky' );
		};

		// Listen for the [scroll] event
		// on the window.
		window.addEventListener( 'scroll', toggleSticky );
		window.addEventListener( 'resize', toggleSticky );

		// Run on page load
		toggleSticky();
	}
}

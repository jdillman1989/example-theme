export default class {

	/**
	 * setup
	 *
	 * Adds the modal functionality to the
	 * video buttons.
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	setup() {
		document.querySelectorAll( '.js-modal-button' ).forEach( ( el ) => {
			el.addEventListener( 'click', ( ev ) => {
				ev.preventDefault();

				const el = ev.target.nextElementSibling;

				if ( ! el ) {
					return;
				}

				const modal = Object.assign( document.createElement( 'div' ), {
					className: 'modal-overlay js-overlay',
					innerHTML: el.outerHTML,
					onclick( ev ) {
						if (
							! document.body.classList.contains( 'is-modal-active' ) ||
							ev.target !== ev.currentTarget
						) {
							return;
						}

						document.body.classList.remove( 'is-modal-active' );
						document.body.removeChild( document.querySelector( '.modal-overlay' ) );
					}
				});

				document.body.classList.add( 'is-modal-active' );
				document.body.appendChild( modal );
			});
		});
	}
}

export default class {

	constructor() {
		this.mediaGalleries = document.querySelectorAll( '.elementor-media-gallery' );
	}

	/**
	 * setup
	 *
	 * Prepares the FAQ accordion.
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	setup() {
		this.mediaGalleries.forEach( gallery => {
			const featuredImgContainer = gallery.querySelector( '.media-img' );
			const modalButton = gallery.querySelector( '.js-modal-button' );
			const modalContentContainer = gallery.querySelector( '.js-modal-content' );
			const previews = gallery.querySelectorAll( '.media-preview' );

			previews.forEach( ( preview, index ) => {
				if ( 0 === index ) {
					if ( preview.classList.contains( 'is-video' ) ) {
						modalButton.style.display = 'block';
						modalContentContainer.innerHTML = preview.querySelector( '.video-content' ).innerHTML;
					}
				}

				preview.addEventListener( 'click', ( event ) => {
					const { target } = event;

					previews.forEach( notSelected => {
						notSelected.classList.remove( 'selected' );
					});

					target.classList.add( 'selected' );
					featuredImgContainer.src = target.querySelector( '.fullsize' ).src;
					modalButton.style.display = 'none';
					if ( target.classList.contains( 'is-video' ) ) {
						modalButton.style.display = 'block';
						modalContentContainer.innerHTML = target.querySelector( '.video-content' ).innerHTML;
					}
				});
			});
		});
	}
}

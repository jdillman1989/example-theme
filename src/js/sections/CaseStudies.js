export default class {

	constructor() {
		this.slider = $( document.getElementById( 'case-studies-slider' ) );
	}

	/**
	 * setup
	 *
	 * Adds slider functionalities to the section.
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	setup() {

		// Instantiate the slider.
		const sliderCarousel = this.slider.find( '.slider__items' );

		/** Initializes the slider functionality. */
		const init = () => {
			manage();

			let timeout = false;
			window.addEventListener( 'resize', () => {
				clearTimeout( timeout );
				timeout = setTimeout( manage, 200 );
			});
		};

		/** Manages the slider functionality. */
		const manage = () => {
			switch ( true ) {

			// Tablet
			case 1023 < window.innerWidth:
				destroy();
				mount({
					items: 2,
					rtl: true,
					placeholder: true
				});
				break;

			// Phone
			default:
				destroy();
				mount({
					stagePadding: 4,
					items: 2,
					rtl: false,
					placeholder: true
				});
				break;
			}
		};

		/** Mounts the slider. */
		const mount = options => {
			sliderCarousel.addClass( 'owl-carousel' );

			sliderCarousel
				.owlCarousel({
					items: options.items,
					rtl: options.rtl,
					loop: true
				});

			// Update the indicator.
			updateIndicator();
			sliderCarousel.on( 'changed.owl.carousel', updateIndicator );
		};

		/** Destroys the slider. */
		const destroy = () => {
			sliderCarousel
				.removeClass( 'owl-carousel' )
				.trigger( 'destroy.owl.carousel' );

			// Unbind event listeners.
			sliderCarousel.off( 'changed.owl.carousel', updateIndicator );
		};

		/** Updates the indicator. */
		const updateIndicator = () => {
			const owl = sliderCarousel.data( 'owl.carousel' );
			const activeIndex = owl.relative( owl.current() );

			this.slider.find( '.slider__indicator-current' )
				.text( activeIndex + 1 );
		};

		// Initialize the slider.
		init();

		// Bind click event to the arrows
		this.slider.find( '.slider__arrow' ).on( 'click', function() {
			const { direction } = this.dataset;
			sliderCarousel.trigger( `${direction}.owl.carousel` );
		});
	}
}

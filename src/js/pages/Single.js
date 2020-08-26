import Page from '../classes/Page';

export default class extends Page {
	constructor() {
		super({
			element: '.related-content',
			elements: {
				mobileSliders: '.mobile-only-slider'
			},
			sliderActive: false
		});
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
	setupMobileSliders() {

		const responsiveSlider = ( slider ) => {
			const checkWidth = $( window ).width();

			// Get the slider elements
			let sliderCarousel = slider.find( '.slider__items' );

			if ( 767 < checkWidth ) {
				if ( 'undefined' !== typeof sliderCarousel.data( 'owl.carousel' ) ) {
					sliderCarousel.data( 'owl.carousel' ).destroy();
				}
				sliderCarousel.removeClass( 'owl-carousel' );
				$( this.element ).find( '.related-content__arrow' ).off();
				sliderCarousel.off();
				this.sliderActive = false;
			} else if ( ! this.sliderActive ) {
				sliderCarousel.addClass( 'owl-carousel' );

				// Instantiate the first slider
				sliderCarousel.owlCarousel({
					items: 2,
					loop: true
				});

				// Bind click event to the arrows
				$( this.element ).find( '.related-content__arrow' ).on( 'click', function() {
					const { direction } = this.dataset;
					sliderCarousel.trigger( `${direction}.owl.carousel` );
				});

				this.sliderActive = true;
			}
		};

		const slider = $( this.elements.mobileSliders );

		responsiveSlider( slider );
		$( window ).resize( () => {
			responsiveSlider( slider );
		});
	}


	create() {
		super.create();

		this.setupMobileSliders();
	}

	destroy() {
		super.destroy();
	}
}

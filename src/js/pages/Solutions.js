import Page from '../classes/Page';

export default class extends Page {
	constructor() {
		super({
			element: '#solutions',
			elements: {
				mobileSection: '#mobile',
				sliderItems: '#slider-items',
				sliderArrows: '.slider__arrow',
				sliderIndicatorCurrent: '#slider-indicator-current'
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
	setupMobileSlider() {

		const responsiveSlider = () => {
			const checkWidth = $( window ).width();

			// Get the slider elements
			const sliderCarousel = $( this.elements.sliderItems );
			const sliderArrows = $( this.elements.sliderArrows );
			const sliderIndicatorCurrent = $( this.elements.sliderIndicatorCurrent );

			if ( 767 < checkWidth ) {
				if ( 'undefined' != typeof sliderCarousel.data( 'owl.carousel' ) ) {
					sliderCarousel.data( 'owl.carousel' ).destroy();
				}
				sliderCarousel.removeClass( 'owl-carousel' );
				sliderArrows.off();
				sliderCarousel.off();
				this.sliderActive = false;
			} else if ( ! this.sliderActive ) {
				sliderCarousel.addClass( 'owl-carousel' );

				// Instantiate the first slider
				sliderCarousel.owlCarousel({
					items: 2,
					stagePadding: 4,
					loop: true
				});

				// Bind click event to the arrows
				sliderArrows.on( 'click', function() {
					const { direction } = this.dataset;
					sliderCarousel.trigger( `${direction}.owl.carousel` );
				});

				// Update the indicator.
				sliderCarousel.on( 'changed.owl.carousel', e => {
					const { relatedTarget } = e;
					const activeIndex = relatedTarget.relative( relatedTarget.current() );

					sliderIndicatorCurrent.text( activeIndex + 1 );
				});

				this.sliderActive = true;
			}
		};

		responsiveSlider();
		$( window ).resize( () => {
			responsiveSlider();
		});
	}

	create() {
		super.create();
		this.setupMobileSlider();
	}

	destroy() {
		super.destroy();
	}
}

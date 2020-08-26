import Page from '../classes/Page';
import CaseStudies from '../sections/CaseStudies';

export default class extends Page {
	constructor() {
		super({
			element: '#pricing',
			elements: {
				plansCta: '.plans-cta'
			}
		});
	}

	/**
	 * setupPlansCta
	 *
	 * Prepares the Plans CTA slider.
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	setupPlansCta() {
		const section = $( this.elements.plansCta );

		// Get the slider elements
		const slider = section.find( '.plans-cta__slider' );
		const sliderCarousel = slider.find( '.slider__items' );
		let sliderEnabled = false;

		/** Initializes the slider functionality. */
		const init = () => {
			manage();

			let timeout = false;
			$( window ).on( 'resize', () => {
				clearTimeout( timeout );
				timeout = setTimeout( manage, 200 );
			});
		};

		/** Manages the slider functionality. */
		const manage = () => {
			const isMobile = 768 >= window.innerWidth;

			if ( isMobile && ! sliderEnabled ) {
				mount();
			} else if ( ! isMobile && sliderEnabled ) {
				destroy();
			}
		};

		/** Mounts the slider. */
		const mount = () => {
			sliderEnabled = true;
			sliderCarousel
				.addClass( 'owl-carousel' )
				.owlCarousel({
					items: 2,
					stagePadding: 16,
					loop: true
				});

			// Update the indicator.
			sliderCarousel.on( 'changed.owl.carousel', updateIndicator );
		};

		/** Destroys the slider. */
		const destroy = () => {
			sliderEnabled = false;
			sliderCarousel
				.removeClass( 'owl-carousel' )
				.trigger( 'destroy.owl.carousel' );

			// Unbind event listeners.
			sliderCarousel.off( 'changed.owl.carousel', updateIndicator );
		};

		/** Updates the indicator. */
		const updateIndicator = ({ relatedTarget }) => {
			const activeIndex = relatedTarget.relative( relatedTarget.current() );

			// Update the indicator.
			slider.find( '.slider__indicator-current' )
				.text( activeIndex + 1 );
		};

		// Initialize the slider.
		init();

		// Bind click event to the arrows
		slider.find( '.slider__arrow' ).on( 'click', function() {
			const { direction } = this.dataset;
			sliderCarousel.trigger( `${direction}.owl.carousel` );
		});
	}

	create() {
		super.create();

		this.caseStudies = new CaseStudies();
		this.caseStudies.setup();

		this.setupPlansCta();
	}

	destroy() {
		super.destroy();
	}
}

import Page from '../classes/Page';
import RemoteLearning from '../sections/RemoteLearning';
import CaseStudies from '../sections/CaseStudies';

export default class extends Page {
	constructor() {
		super({
			element: '#portfolio',
			elements: {
				mobileSliders: '.mobile-only-slider'
			},
			sliderActive: false
		});

		this.defaultText = document.getElementById( 'defaultText' );
		this.updatedText = document.getElementById( 'updated-text-elements' );
		this.updatedTextHeading = document.getElementById( 'updated-text-heading' );
		this.updatedTextContent = document.getElementById( 'updated-text-content' );
	}

	/**
	 * setup
	 *
	 * Ecosystem graphic states
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	setupEcosystem() {
		document.querySelectorAll( '.eco-button' ).forEach( button => {
			button.addEventListener( 'click', ( event ) => {
				const { target } = event;
				this.defaultText.style.display = 'none';
				const thisConnections = target.dataset.connections.split( ',' );

				this.updatedText.style.display = 'block';
				this.updatedTextHeading.innerText = target.dataset.option;
				this.updatedTextContent.innerText = target.dataset.text;
				document.querySelectorAll( '.connection-line' ).forEach( line => {
					line.classList.remove( 'drawn' );
				});
				thisConnections.forEach( connection => {
					document.getElementById( connection + 'Connection' ).classList.add( 'drawn' );
				});
			});
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
				if ( 'undefined' != typeof sliderCarousel.data( 'owl.carousel' ) ) {
					sliderCarousel.data( 'owl.carousel' ).destroy();
				}
				sliderCarousel.removeClass( 'owl-carousel' );
				slider.find( '.slider__arrow' ).off();
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
				slider.find( '.slider__arrow' ).on( 'click', function() {
					const { direction } = this.dataset;
					sliderCarousel.trigger( `${direction}.owl.carousel` );
				});

				// Update the indicator.
				sliderCarousel.on( 'changed.owl.carousel', e => {
					const { relatedTarget } = e;
					const activeIndex = relatedTarget.relative( relatedTarget.current() );

					slider.find( '.slider__indicator-current' )
						.text( activeIndex + 1 );
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
		this.setupEcosystem();

		this.remoteLearning = new RemoteLearning();
		this.remoteLearning.setup();

		this.caseStudies = new CaseStudies();
		this.caseStudies.setup();
	}

	destroy() {
		super.destroy();
	}
}

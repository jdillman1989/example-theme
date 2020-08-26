export default class {

	constructor() {
		this.sliderOne = $( document.getElementById( 'remote-learning-slider-one' ) );
		this.sliderTwo = $( document.getElementById( 'remote-learning-slider-two' ) );
		this.sliderThree = $( document.getElementById( 'remote-learning-slider-three' ) );
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

		// Get each slider element.
		const sliderOneCarousel = this.sliderOne.find( '.slider-one__items' );
		const sliderTwoCarousel = this.sliderTwo.find( '.slider-two__items' );
		const sliderThreeCarousel = this.sliderThree.find( '.slider-three__items' );

		/** Initializes the first slider. */
		let sliderOneEnabled = false;

		const init = () => {
			manage();

			let timeout = false;
			$( window ).on( 'resize', () => {
				clearTimeout( timeout );
				timeout = setTimeout( manage, 200 );
			});
		};

		/** Manages the first slider. */
		const manage = () => {
			const isMobile = 768 >= window.innerWidth;

			if ( isMobile && ! sliderOneEnabled ) {
				mount();
			} else if ( ! isMobile && sliderOneEnabled ) {
				destroy();
			}
		};

		/** Mounts the first slider. */
		const mount = () => {
			sliderOneEnabled = true;
			sliderOneCarousel
				.addClass( 'owl-carousel' )
				.owlCarousel({
					items: 2,
					stagePadding: 20,
					loop: true
				});

			// Change the active item on the second and third
			// sliders to match the one on the first slider.
			//
			// Also update the indicator.
			sliderOneCarousel.on( 'changed.owl.carousel', updateSlides );
		};

		/** Destroys the first slider. */
		const destroy = () => {
			sliderOneEnabled = false;
			sliderOneCarousel
				.removeClass( 'owl-carousel' )
				.trigger( 'destroy.owl.carousel' );

			// Unbind event listeners.
			sliderOneCarousel.off( 'changed.owl.carousel', updateSlides );
		};

		/**
		 * Updates the active item on the second and third
		 * sliders to match the one on the first slider.
		 *
		 * Also update the indicator.
		 */
		const updateSlides = ({ relatedTarget }) => {
			const activeIndex = relatedTarget.relative( relatedTarget.current() );

			sliderTwoCarousel.trigger( 'to.owl.carousel', activeIndex );
			sliderThreeCarousel.trigger( 'to.owl.carousel', activeIndex );

			// Update the indicator.
			this.sliderOne.find( '.slider-one__indicator-current' )
				.text( activeIndex + 1 );
		};


		// Initialize the first slider.
		init();

		// Bind click event to the arrows.
		this.sliderOne.find( '.slider-one__arrow' ).on( 'click', function() {
			const { direction } = this.dataset;
			sliderOneCarousel.trigger( `${direction}.owl.carousel` );
		});

		// Instantiate the second slider.
		sliderTwoCarousel.owlCarousel({
			items: 1,
			mouseDrag: false,
			touchDrag: false,
			loop: true
		});

		// Instantiate the third slider.
		sliderThreeCarousel.owlCarousel({
			items: 1,
			animateIn: 'fadeIn',
			animateOut: 'fadeOut',
			mouseDrag: false,
			touchDrag: false,
			loop: true
		});

		// Bind click event to the navigation items.
		this.sliderOne.find( '.slider-one__item .item__button' )
			.on( 'click', function() {
				const { index } = $( this ).parent().data();

				sliderTwoCarousel.trigger( 'to.owl.carousel', index );
				sliderThreeCarousel.trigger( 'to.owl.carousel', index );
			});
	}
}

import Page from '../classes/Page';
import RemoteLearning from '../sections/RemoteLearning';
import CaseStudies from '../sections/CaseStudies';

export default class extends Page {
	constructor() {
		super({
			element: '#home',
			elements: {
				portfolioTypesSliderOne: '#portfolio-slider-one',
				portfolioTypesSliderTwo: '#portfolio-slider-two',
				newsNav: '#news-nav',
				newsSlider: '#news-slider',
				plansSlider: '#plans-slider'
			}
		});
	}

	/**
	 * setupMobilePortfolioTypes
	 *
	 * Prepares the Portfolio Types sliders on mobile.
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	setupMobilePortfolioTypes() {

		// Get the first slider elements
		const sliderOne = $( this.elements.portfolioTypesSliderOne );
		const sliderOneCarousel = sliderOne.find( '.slider-one__items' );

		// Instantiate the first slider's carousel
		sliderOneCarousel.owlCarousel({
			items: 1,
			animateIn: 'fadeIn',
			animateOut: 'fadeOut',
			mouseDrag: false,
			touchDrag: false,
			loop: true
		});

		// Get the second slider elements.
		const sliderTwo = $( this.elements.portfolioTypesSliderTwo );
		const sliderTwoCarousel = sliderTwo.find( '.slider-two__items' );
		let sliderTwoEnabled = false;

		/** Initializes second slider. */
		const init = () => {
			manage();

			let timeout = false;
			$( window ).on( 'resize', () => {
				clearTimeout( timeout );
				timeout = setTimeout( manage, 200 );
			});
		};

		/** Manages the second slider. */
		const manage = () => {
			const isMobile = 768 >= window.innerWidth;

			if ( isMobile && ! sliderTwoEnabled ) {
				mount();
			} else if ( ! isMobile && sliderTwoEnabled ) {
				destroy();
			}
		};

		/** Mounts the second slider. */
		const mount = () => {
			sliderTwoEnabled = true;
			sliderTwoCarousel
				.addClass( 'owl-carousel' )
				.owlCarousel({
					items: 2,
					loop: true
				});

			sliderTwoCarousel.on( 'translated.owl.carousel', checkClasses );
			checkClasses();

			// Change the active item on the first slider
			// to match the one on the second slider.
			//
			// Also update the indicator.
			sliderTwoCarousel.on( 'changed.owl.carousel', updateSlides );
		};

		/** Destroys the second slider. */
		const destroy = () => {
			sliderTwoEnabled = false;
			sliderTwoCarousel
				.removeClass( 'owl-carousel' )
				.trigger( 'destroy.owl.carousel' );

			// Unbind event listeners.
			sliderTwoCarousel.off( 'translated.owl.carousel', checkClasses );
			sliderTwoCarousel.off( 'changed.owl.carousel', updateSlides );
		};

		/**
		 * Adds a class to the first active item
		 * on the second slider.
		 */
		const checkClasses = () => {
			sliderTwoCarousel.find( '.owl-item' ).removeClass( 'current' );
			sliderTwoCarousel.find( '.owl-item.active' )
				.get( 0 )
				.classList.add( 'current' );
		};

		/**
		 * Updates the active item on the first slider
		 * to match the one on the second slider.
		 *
		 * Also update the indicator.
		 */
		const updateSlides = ({ relatedTarget }) => {
			const activeIndex = relatedTarget.relative( relatedTarget.current() );
			sliderOneCarousel.trigger( 'to.owl.carousel', activeIndex );

			// Update the indicator.
			sliderTwo.find( '.slider-two__indicator-current' )
				.text( activeIndex + 1 );
		};

		// Initialize the second slider.
		init();

		// Bind click event to the arrows
		sliderTwo.find( '.slider-two__arrow' ).on( 'click', function() {
			const { direction } = this.dataset;
			sliderTwoCarousel.trigger( `${direction}.owl.carousel` );
		});
	}

	/**
	 * setupDesktopPortfolioTypes
	 *
	 * Prepares the Portfolio Types accordion on desktop.
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	setupDesktopPortfolioTypes() {
		const nav = $( this.elements.portfolioTypesSliderTwo ).find( '.slider-two__items' );
		const sliderOneCarousel = $( this.elements.portfolioTypesSliderOne ).find( '.slider-one__items' );
		let accordionEnabled = false;

		/** Initializes the accordion functionality. */
		const init = () => {
			manage();

			let timeout = false;
			$( window ).on( 'resize', () => {
				clearTimeout( timeout );
				timeout = setTimeout( manage, 200 );
			});
		};

		/** Manages the active item. */
		const manage = () => {
			const isMobile = 768 >= window.innerWidth;

			if ( ! isMobile && ! accordionEnabled ) {
				mount();
			} else if ( isMobile && accordionEnabled ) {
				destroy();
			}
		};

		/** Mounts the accordion functionality. */
		const mount = () => {
			accordionEnabled = true;

			const firstItem = nav.find( '.item[data-index="0"]' );

			nav
				.find( '.item' )
				.not( firstItem )
				.each( function() {
					deactivateItem( $( this ) );
				});

			activateItem( firstItem );
		};

		/** Destroys the accordion functionality. */
		const destroy = () => {
			accordionEnabled = false;

			nav.find( '.item' )
				.removeClass( 'item--active' )
				.find( '.item__description' )
				.removeAttr( 'style' );
		};

		/** Deactivates an item. */
		const deactivateItem = item => {
			item
				.removeClass( 'item--active' )
				.find( '.item__description' )
				.animate({
					height: 0
				}, {
					duration: 150,
					ease: $.bez([ 0.5, 0, 0, 1 ])
				});
		};

		/** Activates an item. */
		const activateItem = item => {
			const descriptionHeight = item.find( '.item__description-wrapper' ).outerHeight();

			item
				.addClass( 'item--active' )
				.find( '.item__description' )
				.animate({
					height: descriptionHeight
				}, {
					duration: 150,
					ease: $.bez([ 0.5, 0, 0, 1 ])
				});

			const { index } = item.data();
			sliderOneCarousel.trigger( 'to.owl.carousel', index );
		};

		// Initialize the accordion functionality.
		init();

		/** Updates the active item's description height. */
		const updateDescriptionHeight = () => {
			const activeItem = nav.find( '.item--active' );
			const descriptionHeight = activeItem.find( '.item__description-wrapper' ).outerHeight();
			activeItem.find( '.item__description' ).height( descriptionHeight );
		};

		/** Initializes the description heights updates. */
		const initDescriptionUpdates = () => {
			let timeout = false;
			$( window ).on( 'resize', function() {
				clearTimeout( timeout );
				timeout = setTimeout( updateDescriptionHeight, 200 );
			});
		};

		// Initialize the description heights updates.
		initDescriptionUpdates();

		// Bind click event to the nav items
		nav.find( '.item .item__title-button' )
			.on( 'click', function() {
				const item = $( this ).parents( '.item' );

				nav.find( '.item' ).not( item ).each( function() {
					deactivateItem( $( this ) );
				});

				activateItem( item );
			});
	}

	/**
	 * setupNews
	 *
	 * Prepares the News slider.
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	setupNews() {

		// Get the main slider elements
		const nav = $( this.elements.newsNav );
		const slider = $( this.elements.newsSlider );
		const sliderCarousel = slider.find( '.slider__items' );

		// Instantiate the carousel
		sliderCarousel.owlCarousel({
			items: 2,
			loop: true,
			responsive: {
				640: {
					items: 3
				},
				1023: {
					items: 4
				},
				1919: {
					items: 4,
					margin: 100
				}
			}
		});

		// Bind click event to the arrows
		nav.find( '.news__arrow' ).on( 'click', function() {
			const { direction } = this.dataset;
			sliderCarousel.trigger( `${direction}.owl.carousel` );
		});
	}

	/**
	 * setupPlans
	 *
	 * Prepares the Plans slider.
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	setupPlans() {

		// Get the main slider elements
		const slider = $( this.elements.plansSlider );
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
			const isMobile = 1024 >= window.innerWidth;

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
					stagePadding: 4,
					loop: true,
					responsive: {
						650: {
							items: 3
						}
					}
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
		this.setupMobilePortfolioTypes();
		this.setupDesktopPortfolioTypes();

		this.remoteLearning = new RemoteLearning();
		this.remoteLearning.setup();

		this.setupNews();

		this.caseStudies = new CaseStudies();
		this.caseStudies.setup();

		this.setupPlans();
	}

	destroy() {
		super.destroy();
	}
}

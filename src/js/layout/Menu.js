export default class {

	constructor() {
		this.header = $( document.getElementById( 'header' ) );
		this.mobileMenu = $( document.getElementById( 'mobile-menu' ) );
	}

	/**
	 * setupMegamenus
	 *
	 * Prepares the desktop megamenus.
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	setupMegamenus() {
		const megamenus = $( '.megamenu' );

		// Toggle a megamenu when hovering a
		// main navigation item.
		this.header.find( '.header__nav .nav__item--has-megamenu' )
			.on( 'mouseenter mouseleave', function({ type }) {
				const { index } = this.dataset;
				const megamenu = $( `.megamenu[data-index="${index}"]` );

				// Toggle the megamenu
				let { timeout } = $( this ).data();

				if ( 'mouseenter' === type ) {
					clearTimeout( timeout );
					$( '.megamenu' ).removeClass( 'megamenu--active' );
					megamenu.addClass( 'megamenu--active' );
				} else {
					timeout = setTimeout( () => {
						megamenu.removeClass( 'megamenu--active' );
					}, 1000 );

					$( this ).data( 'timeout', timeout );
				}
			});

		// Set tabs height.

		/** Sets tabs height based on their content. */
		const setTabsHeight = () => {
			megamenus.each( function() {
				const tabsWrapper = $( this ).find( '.megamenu__tabs' );

				// Set the height to each tab
				tabsWrapper.find( '.tab' ).each( function() {
					const h = $( this ).children( '.tab__wrapper' ).outerHeight();
					$( this ).height( h );
				});

				// Set the height to the tabs wrapper
				// based on the active tab
				const activeH = $( this ).find( '.megamenu__tabs .tabs__tab--active' ).outerHeight();
				$( this ).find( '.megamenu__tabs' ).height( activeH );
			});
		};

		let timeout = false;
		$( window ).on( 'resize', () => {
			clearTimeout ( timeout );
			timeout = setTimeout( setTabsHeight, 200 );
		});

		setTabsHeight();

		// Bind mouseenter event to megamenu items.
		megamenus.find( '.megamenu__nav .nav__item' )
			.on( 'mouseenter', function() {
				const megamenu = $( this ).parents( '.megamenu' );
				const { index } = this.dataset;

				megamenu.find( '.megamenu__nav .nav__item' ).removeClass( 'nav__item--active' );
				$( this ).addClass( 'nav__item--active' );

				megamenu.find( '.megamenu__tabs .tab' ).removeClass( 'tabs__tab--active' );
				megamenu.find( `.megamenu__tabs .tab[data-index="${index}"]` ).addClass( 'tabs__tab--active' );

				setTabsHeight();
			});
	}

	/**
	 * setupMobile
	 *
	 * Prepares the mobile menu.
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	setupMobile() {
		const $this = this;
		const menuToggler = $( document.getElementById( 'menu-toggler' ) );

		// Bind click event to the menu toggler
		menuToggler.on( 'click', function() {
			$this.mobileMenu.toggleClass( 'mobile-menu--open' );
			$( this ).toggleClass( 'menu-toggler--active' );
		});

		// Bind click event to the megamenu togglers
		this.mobileMenu.find( '.mobile-menu__main-nav .main-nav__item--has-megamenu .main-nav__item-link' )
			.on( 'click', function() {
				const { index: submenuIndex } = $( this ).parent().data();

				// Open the specified submenu
				$this.mobileMenu.find( `.mobile-menu__submenu[data-index="${submenuIndex}"]` )
					.addClass( 'mobile-menu__submenu--open' );
			});

		// Bind click event to the back button
		this.mobileMenu.find( '.mobile-menu__submenu .submenu__back' )
			.on( 'click', function() {
				$( this ).parents( '.submenu' ).removeClass( 'mobile-menu__submenu--open' );
			});

		// Bind click event to the close button
		this.mobileMenu.find( '.mobile-menu__submenu .submenu__close' )
			.on( 'click', function() {
				$( this ).parents( '.submenu' ).removeClass( 'mobile-menu__submenu--open' );
				$this.mobileMenu.removeClass( 'mobile-menu--open' );
				$this.header.find( '.menu-toggler' ).removeClass( 'menu-toggler--active' );
			});
	}

	/**
	 * setStickyActive
	 *
	 * Sets an active state when the user has scrolled the page.
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	setStickyActive() {
		window.addEventListener( 'scroll', function() {
			if ( 5 < ( window.pageYOffset ) ) {
				this.header.classList.add( 'header__sticky-active' );
			} else {
				this.header.classList.remove( 'header__sticky-active' );
			}
		});
	}
}


export default class {

	/**
	 * setup
	 *
	 * Prepares the Accordion.
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	setup() {
		const section = $( '.accordion-section' );
		const accordion = section.find( '.accordion' );

		/** Deactivates an item. */
		const deactivateItem = item => {
			item
				.removeClass( 'item--active' )
				.find( '.item__content' )
				.animate({
					height: 0
				}, {
					duration: 150,
					ease: $.bez([ 0.5, 0, 0, 1 ])
				});
		};

		/** Activates an item. */
		const activateItem = item => {
			const contentHeight = item.find( '.item__content-wrapper' ).outerHeight();
			item
				.addClass( 'item--active' )
				.find( '.item__content' )
				.animate({
					height: contentHeight
				}, {
					duration: 150,
					ease: $.bez([ 0.5, 0, 0, 1 ])
				});
		};

		/** Updates the active item's content height. */
		const updateContentHeight = () => {
			const activeItem = accordion.find( '.item--active' );
			const descriptionHeight = activeItem.find( '.item__content-wrapper' ).outerHeight();
			activeItem.find( '.item__content' ).height( descriptionHeight );
		};

		/** Initializes the description heights updates. */
		const initContentUpdates = () => {
			let timeout = false;
			$( window ).on( 'resize', function() {
				clearTimeout( timeout );
				timeout = setTimeout( updateContentHeight, 200 );
			});
		};

		// Activate the first item on initialization
		const firstItem = accordion.find( '.item[data-index="0"]' );
		activateItem( firstItem );

		// Initialize the description heights updates.
		initContentUpdates();

		// Bind click event to the nav items
		accordion.find( '.item .item__header-button' )
			.on( 'click', function() {
				const item = $( this ).parents( '.item' );

				accordion.find( '.item' ).not( item ).each( function() {
					deactivateItem( $( this ) );
				});

				activateItem( item );
			});
	}
}

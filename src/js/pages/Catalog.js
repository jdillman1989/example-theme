import Page from '../classes/Page';

export default class extends Page {
	constructor() {
		super({
			element: '#catalog',
			elements: {
				filterButtons: '.filter-button'
			}
		});
		this.scrollLoaderReady = true;
		this.headerHeight = this.setHeaderHeight();
		this.archiveWrapper = document.getElementById( 'archive-filters-wrapper' );
		if ( this.archiveWrapper ) {
			this.archiveWrapperOffset = this.getElementOffsetTop( this.archiveWrapper );
		}
	}

	/**
	 * setupFilterPosition
	 *
	 * Filter bar position fix on scroll
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	setupFilterPosition() {
		const filterBar = document.querySelector( '.archive__filters' );

		window.addEventListener( 'scroll', () => {
			const headerHeightOffset = document.documentElement.scrollTop + this.headerHeight;

			if ( this.archiveWrapperOffset <= headerHeightOffset ) {
				filterBar.classList.add( 'fixed' );
				filterBar.style.top = this.headerHeight + 'px';
			} else {
				filterBar.classList.remove( 'fixed' );
				filterBar.style.top = null;
			}
		});

		window.addEventListener( 'resize', () => {
			this.headerHeight = this.setHeaderHeight();
			this.archiveWrapperOffset = this.getElementOffsetTop( this.archiveWrapper );
		});
	}

	/**
	 * setHeaderHeight
	 *
	 * Sets the height of the header in a hardcoded manner so that it doesn't have
	 * to be calculated repeatedly. This is to handle the "scrolled" height of the header.
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return number
	 */
	setHeaderHeight() {
		const currentWidth = window.innerWidth;
		let height = 60;

		if ( 768 <= currentWidth && 820 > currentWidth ) {
			height = 45;
		} else if ( 820 <= currentWidth && 1024 > currentWidth ) {
			height = 55;
		} else if ( 1024 <= currentWidth ) {
			height = 60;
		}

		return height;
	}

	/**
	 *
	 * getElementOffsetTop
	 *
	 * Gets the top offset of an element relative to the page rather than parent
	 *
	 */
	getElementOffsetTop( elem ) {
		let location = 0;
		if ( elem.offsetParent ) {
			do {
				location += elem.offsetTop;
				elem = elem.offsetParent;
			} while ( elem );
		}
		return 0 <= location ? location : 0;
	}

	/**
	 * setupDropdowns
	 *
	 * Display term lists on filter button click
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	setupDropdowns() {

		const taxonomySelector = '.filter-button';
		const taxonomyButtons = document.querySelectorAll( taxonomySelector );

		document.addEventListener( 'click', ( event ) => {
			const { target } = event;

			if ( target.classList.contains( 'displayed' ) ) {
				target.classList.remove( 'displayed' );
				return;
			}

			taxonomyButtons.forEach( button => {
				button.classList.remove( 'displayed' );
			});

			if ( target.classList.contains( 'filter-button' ) ) {
				target.classList.add( 'displayed' );
			}
		});
	}

	/**
	 * setupTerms
	 *
	 * Display term name and call posts
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	setupTerms() {
		const nextButton = document.getElementById( 'morePosts' );

		document.querySelectorAll( '.term-item' ).forEach( listItem => {
			listItem.addEventListener( 'click', ( event ) => {
				const { target } = event;
				const taxonomy = target.dataset.tax;
				const term = target.dataset.term;
				const label = target.innerText;

				document.getElementById( 'searchQuery' ).value = '';

				document.getElementById( taxonomy + '-current' ).innerText = label;

				let currentFilter = JSON.parse( nextButton.dataset.tax );
				currentFilter[taxonomy] = term;
				currentFilter.category = 'all';
				nextButton.dataset.tax = JSON.stringify( currentFilter );

				this.filterPosts( nextButton.dataset );
			});
		});
	}

	/**
	 * setupNextButton
	 *
	 * Load more posts button
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	setupNextButton() {
		const nextButton = document.getElementById( 'morePosts' );

		nextButton.addEventListener( 'click', ( event ) => {
			const { target } = event;
			this.filterPosts( target.dataset, true );
		});

		window.addEventListener( 'scroll', () => {
			const scrolledToButton = nextButton.getBoundingClientRect().top <= window.innerHeight + 250;
			const buttonEnabled = ! nextButton.classList.contains( 'disabled' );

			if ( scrolledToButton && buttonEnabled && this.scrollLoaderReady ) {
				this.scrollLoaderReady = false;
				nextButton.click();
			}
		});
	}

	/**
	 * setupSearchForm
	 *
	 * Search posts form filtering
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	setupSearchForm( resetButtonData ) {
		const searchForm = document.getElementById( 'searchPosts' );
		const nextButton = document.getElementById( 'morePosts' );

		searchForm.addEventListener( 'submit', ( event ) => {
			event.preventDefault();

			const taxFilters = document.querySelectorAll( '.filter-button__text span' );
			taxFilters.forEach( filter => {
				filter.innerText = '(ALL)';
			});
			nextButton.dataset.tax = resetButtonData;

			const searchQuery = document.getElementById( 'searchQuery' ).value;
			const searchFilter = { type: nextButton.dataset.type, s: searchQuery };

			this.filterPosts( searchFilter, false, true );
		});
	}

	/**
	 * filterPosts
	 *
	 * Display term name and call posts
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	filterPosts( filterParams, isAppended = false, isSearch = false ) {

		const nextButton = document.getElementById( 'morePosts' );
		const postsSection = document.querySelector( '.archive__posts' );
		const postsWrapper = document.querySelector( '.archive__posts--wrapper' );

		postsSection.classList.add( 'faded' );

		const requestData = ( isSearch ) ? filterParams :
			{
				tax: JSON.parse( filterParams.tax ),
				next: ( isAppended ) ? filterParams.next : 1,
				ppp: filterParams.ppp,
				type: filterParams.type
			};

		$.ajax({
			type: 'GET',
			url: nextButton.dataset.action,
			data: requestData,
			complete: ( response ) => {

				if ( '' === response.responseText.trim() ) {
					const error = '<p class="error">Error: No post data response</p>';
					postsWrapper.parentNode.replaceChild( error, postsWrapper );
					postsSection.classList.remove( 'faded' );
					return;
				}

				const data = JSON.parse( response.responseText );

				const next = ( isAppended ) ? parseInt( nextButton.dataset.next ) + 1 : 2;
				nextButton.dataset.next = next;
				nextButton.dataset.max = data.max;

				if ( next > data.max || isSearch ) {
					nextButton.classList.add( 'disabled' );
				} else {
					nextButton.classList.remove( 'disabled' );
				}

				const dataHTML = this.getPostsMarkup( postsWrapper, data.data );

				if ( ! isAppended ) {
					postsWrapper.parentNode.replaceChild( dataHTML, postsWrapper );
				} else {
					dataHTML.replaceWith( ...dataHTML.childNodes );
					postsWrapper.appendChild( dataHTML );
				}

				postsSection.classList.remove( 'faded' );
				this.scrollLoaderReady = true;
			}
		});
	}

	/**
	 * getPostsMarkup
	 *
	 * Apply post data to view markup
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @return NA
	 * @param wrapper
	 * @param postData
	 */
	getPostsMarkup( wrapper, postData ) {
		const getTemplate = wrapper.firstElementChild;

		const html = wrapper.cloneNode();

		if ( ! postData.length ) {
			const template = getTemplate.cloneNode( true );
			template.style.display = 'none';

			html.appendChild( template );

			const noPosts = document.createElement( 'p' );
			noPosts.classList.add( 'error' );
			noPosts.innerText = 'No posts found.';
			html.appendChild( noPosts );

			return html;
		}

		postData.forEach( post => {
			const template = getTemplate.cloneNode( true );

			const title = template.querySelector( '[data-title]' );
			const date = template.querySelector( '[data-date]' );
			const links = template.querySelectorAll( '[data-url]' );
			const img = template.querySelector( '[data-img]' );
			const category = template.querySelector( '[data-category]' );

			title.innerText = this.decodeHtmlEntities( post.title );
			date.innerText = post.date;
			category.innerText = post.categoryName;
			category.href = post.categoryUrl;

			links.forEach( link => {
				link.href = post.url;
			});

			if ( post.image ) {
				img.src = post.image;
			} else {
				img.src = '/wp-content/themes/bulb-app/src/assets/img/prod/general/blog-placeholder.jpg';
			}
			img.style.display = 'block';

			template.style.display = 'block';

			html.appendChild( template );
		});

		return html;
	}

	create() {
		super.create();
		this.setupFilterPosition();
		this.setupDropdowns();
		this.setupTerms();
		this.setupNextButton();
		this.setupSearchForm( document.getElementById( 'morePosts' ).dataset.tax );
	}

	decodeHtmlEntities( string ) {
		return string.replace( /&#(\d+);/g, function( match, dec ) {
			return String.fromCharCode( dec );
		});
	}

	destroy() {
		super.destroy();
	}
}

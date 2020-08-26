import './utils/polyfills';
import './utils/lazyloading';

import Menu from './layout/Menu';
import ContactBar from './shared/ContactBar';
import Modal from './shared/Modal';
import Accordion from './shared/Accordion';
import MediaGallery from './sections/MediaGallery';

import Home from './pages/Home';
import Pricing from './pages/Pricing';
import Solutions from './pages/Solutions';
import Portfolio from './pages/Portfolio';
import Catalog from './pages/Catalog';
import Single from './pages/Single';

class App {
	constructor() {
		this.content = document.querySelector( '#main-content' );
		this.template = this.content.dataset.template;

		this.createMenu();
		this.createPages();

		this.setupComponents();
	}

	/**
	 * Load Component Classes
	 */
	createMenu() {
		this.menu = new Menu();
		this.menu.setupMegamenus();
		this.menu.setupMobile();
		this.menu.setStickyActive();
	}

	/**
	 * Load Page Classes
	 */
	createPages() {
		this.content = document.querySelector( '#main-content' );

		this.pages = new Map();

		this.pages.set( 'home', new Home() );
		this.pages.set( 'pricing', new Pricing() );
		this.pages.set( 'solutions', new Solutions() );
		this.pages.set( 'portfolio', new Portfolio() );
		this.pages.set( 'catalog', new Catalog() );
		this.pages.set( 'single', new Single() );

		this.page = this.pages.get( this.template ) || this.pages.get( 'not-found' );
		if ( this.page ) {
			this.page.create();
		}
	}

	/**
	 * setupComponents
	 *
	 * Initializes the main components.
	 *
	 * @type function
	 * @since 0.0.1
	 *
	 * @param NA
	 * @return NA
	 */
	setupComponents() {
		this.contactBar = new ContactBar();
		this.contactBar.setup();

		this.modal = new Modal();
		this.modal.setup();

		this.accordion = new Accordion();
		this.accordion.setup();

		this.mediaGallery = new MediaGallery();
		this.mediaGallery.setup();
	}
}

window.addEventListener( 'load', function() {
	window.APP = new App();
});

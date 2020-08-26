import EventEmitter from 'events';

import each from 'lodash/each';

export default class extends EventEmitter {
	constructor({ element, elements }) {
		super();

		this.selectors = {
			element,
			elements
		};
	}

	// Select all elements from the DOM that are called on when the Class is instantiated.
	create() {
		this.element = document.querySelector( this.selectors.element );
		this.elements = {};

		each( this.selectors.elements, ( selector, key ) => {
			if ( selector instanceof window.HTMLElement || selector instanceof window.NodeList ) {
				this.elements[key] = selector;
			} else if ( Array.isArray( selector ) ) {
				this.elements[key] = selector;
			} else if ( this.element ) {

				this.elements[key] = this.element.querySelectorAll( selector );

				if ( 1 === this.elements[key].length ) {
					this.elements[key] = this.element.querySelector( selector );
				}
			}
		});
	}

	addEventListeners() {

	}

	removeEventListeners() {

	}

	destroy() {

	}
}

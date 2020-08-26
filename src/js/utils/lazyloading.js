import lazySizes from 'lazysizes';

/* eslint-disable */
lazySizes.cfg.preloadAfterLoad = true
lazySizes.cfg.expFactor = 2
/* eslint-enable */

document.addEventListener( 'lazybeforeunveil', ({ target }) => {
	let background = target.getAttribute( 'data-bg' );

	if ( background ) {
		target.style.backgroundImage = `url(${background})`;
	}
});

# WP Custom Theme Scaffold

## Getting Started

You need to have [Node.js](https://nodejs.org/en/) and [npm](https://www.npmjs.com/) installed in your machine, these are the dependencies to run the theme.

```
# Install Composer Dependencies
composer install

# Install Node Dependencies
npm install
```

```
# Build all assets of the website.
npm run build

# Start development environment.
npm start
```

## Structure

### Front End

We're using [Gulp](https://gulpjs.com/) to generate our static files into the `dist` folder. Besides that, we're also using some other tools such as:

- [Babel](https://babeljs.io/)
- [ESLint](https://eslint.org/)
- [StandardJS](https://standardjs.com/)
- [SASS](https://sass-lang.com/)
- [Sytlelint](https://stylelint.io/)

Our preference of plugins is usually the following, but feel free to always recommend and explore new technologies and techniques:

- [Event Emitter](https://nodejs.org/api/events.html)
- [GreenSock](https://greensock.com/)
- [Lodash](https://lodash.com/)
- [Pixi.js](https://www.pixijs.com/)
- [Three.js](https://threejs.org/)

We prefer to use plain JavaScript using ES2015+ syntax, so most of the times try to follow our standards present in the code of this boilerplate by extending `EventEmitter` and creating Object-Oriented Classes that can be reusable accross the applications.

### Back End

We're using [Timber](https://www.upstatement.com/timber/) in our theme, take a look into it's documentation to see the best practices of using it. Timber also uses [Twig](https://twig.symfony.com/) as the template engine for our views, they are present in the `views` folder.

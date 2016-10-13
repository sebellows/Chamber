<?php

return [

    /*
	|--------------------------------------------------------------------------
	| Department names
	|--------------------------------------------------------------------------
	|
	| Individual breakdown of organization. These names will be used to 
	| organize employees, create menus, and register pages.
	|
	*/
	'departments' => [
		'executive',
		'communications',
		'convention & visitors bureau',
		'economic development',
		'education & training',
		'grants',
		'human resources',
		'information technology',
		'marketing',
		'member services',
		'operations',
		'shared services',
		'contract employees & consultants'
	],

    /*
	|--------------------------------------------------------------------------
	| Google Fonts
	|--------------------------------------------------------------------------
	|
	| Embedded font families from Google Fonts (https://fonts.google.com).
	| @see lib/Setup.php
	|
	*/
	'fonts' => [
		'Roboto:400italic,700italic,400,700',
		'Roboto Slab:400,700'
	],

    /*
	|--------------------------------------------------------------------------
	| Site Menus
	|--------------------------------------------------------------------------
	|
	| Menus registered for use in the site. This includes main navigation,
	| sub-site navigation, and complimentary menus for services.
	| @see lib/Setup.php
	|
	*/
	'menus' => [
		// Global/main navigation [location: header.php]
		'site_navigation',

		// Widget-area menus [location: sidebar-primary]
		'quick_links',

		// Global complimentary links [location: sidebar-footer in footer.php]
		'site_information',
		'social_links'
	],

    /*
	|--------------------------------------------------------------------------
	| Post Formats
	|--------------------------------------------------------------------------
	|
	| Post formats to be enabled in WordPress.
	| @see lib/Setup.php
	|
	*/
	'post-formats' => [
		'aside',
		'audio',
		'chat',
		'gallery',
		'image',
		'link',
		'quote',
		'status',
		'video'
	],

    /*
	|--------------------------------------------------------------------------
	| Post Types
	|--------------------------------------------------------------------------
	|
	| Custom post types registered in the Chamber-CMS plugin.
	| @see plugins/chamber-cms/app/PostTypes/
	|
	*/
	'posttypes' => [
		'attraction',
		'business',
		'community',
		'person',
		'project',
		'testimonial'
	],

    /*
	|--------------------------------------------------------------------------
	| Sidebars
	|--------------------------------------------------------------------------
	|
	| The registered sidebars used in the site. They are used to display
	| widgets and menus.
	| @see lib/Setup.php
	|
	*/
	'sidebars' => [
		// news uses the home.php template
		'column' => [
			'class' => 'widget column-widget',
			'container' => 'section',
			'title_tag' => 'h3'
		],
		// footer widgets
		'footer' => [
			'class' => 'widget footer-widget',
			'container' => 'section',
			'title_tag' => 'h4'
		],
		// top-level navigation menu container
		'navigation' => [
			'class' => 'section-navigation',
			'container' => 'nav',
			'title_tag' => 'h2'
		],
		// front page
		'primary' => [
			'class' => 'widget',
			'container' => 'section',
			'title_tag' => 'h3'
		],
		// displays social at bottom of single post
		'post-footer' => [
			'class' => 'widget post-footer-widget',
			'container' => 'section',
			'title_tag' => 'h3'
		],
		// for displaying either a tertiary menu or share buttons on default page template
		'page-header' => [
			'class' => 'widget page-header-widget',
			'container' => 'nav',
			'title_tag' => 'h2'
		],
	],

    /*
	|--------------------------------------------------------------------------
	| Taxonomies
	|--------------------------------------------------------------------------
	|
	| Custom taxonomies registered in the Chamber-CMS plugin.
	| @see plugins/chamber-cms/app/PostTypes/
	|
	*/
	'taxonomies' => [
		'attraction-category',
		'business_type',
		'department'
	],

    /*
	|--------------------------------------------------------------------------
	| Sections (Top-Level Pages)
	|--------------------------------------------------------------------------
	|
	| The main sections of the site.
	|
	*/
	'sections' => [
		'about'                => ['About'],
		'news'                 => ['News'],
		'cvb'                  => ['CVB'],
		'economic-development' => ['Economic Development'],
		'education-training'   => ['Education & Training'],
		'member-services'      => ['Member Services'],
		'shared-services'      => ['Shared Services']
	],

    /*
	|--------------------------------------------------------------------------
	| Isotope Archive Post Types
	|--------------------------------------------------------------------------
	|
	| Post types and terms that will be filterable using Isotope.js.
	|
	*/
	'isotope' => [
		'attraction' => 'attraction_category'
	],

    /*
	|--------------------------------------------------------------------------
	| Attraction Categories
	|--------------------------------------------------------------------------
	|
	| Filterable categories for the Attractions archive using Isotope.js.
	|
	*/
	'attraction' => [
		[
			'term'  => 'arts-and-culture',
			'label' => 'Arts & Culture',
			'icon'  => 'arts-culture'
		],
		[
			'term'  => 'indoor-recreation',
			'label' => 'Indoors',
			'icon'  => 'indoors'
		],
		[
			'term'  => 'outdoor-recreation',
			'label' => 'Outdoors',
			'icon'  => 'outdoors'
		],
		[
			'term'  => 'shopping',
			'label' => 'Shopping',
			'icon'  => 'shopping-bag'
		],
		[
			'term'  => 'dining',
			'label' => 'Dining',
			'icon'  => 'coffee'
		],
		[
			'term'  => 'lodging',
			'label' => 'Lodging',
			'icon'  => 'home'
		]
	],

];
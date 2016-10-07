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
		'sidebar-primary',
		'sidebar-post-footer',
		'sidebar-footer'
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
	| Landing Pages
	|--------------------------------------------------------------------------
	|
	| Sections that use the `landing-page.php` template
	|
	*/
	'landing-pages' => [
		'cvb',
		'economic-development',
		'education-training',
		'member-services',
		'shared-services'
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

];

/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

	// Use this variable to set up the common and page specific functions. If you
	// rename this variable, you will also need to rename the namespace below.
	var Chamber = {
		// All pages
		'common': {
			init: function() {
				// JavaScript to be fired on all pages
				
				// toggle the searchform in the global header
				if ($("#searchForm").length > 0) {
				  new Foundation.Toggler($("#searchForm"));
				}

				// toggle the phone number in the header on mobile
				if ($('#phoneNumber').length > 0 && $('.no-touchevents')) {
					new Foundation.Toggler($("#phoneNumber"));
				}
			},
			finalize: function() {
				// JavaScript to be fired on all pages, after page specific JS is fired
			}
		},
		// Home page
		'home': {
			init: function() {
				// JavaScript to be fired on the home page
			},
			finalize: function() {
				// JavaScript to be fired on the home page, after the init JS
			}
		},
		'blog': {
			init: function() {
				// Make click on social sharing buttons open up small pop-up window instead of another tab.
				$('body').on('click', 'a[m-button~="share"]', function(event) {
					console.log('It was clicked!');
				  event.preventDefault();
				  var url = $(this).attr('href');
				  window.open(url, 'social_share_window', 'height=320, width=560, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');
				});

				// Set images in `.entry-content` to non-floating blocks if they're horizontal
				$('.entry-content img').each( function ( $w, $h ) {
					$w = $(this).width();
					$h = $(this).height();
					($w > $h) ? $(this).addClass('inline-image-h') : $(this).addClass('inline-image-v');
				});
			},
			finalize: function() {
				//
			}
		},
		'archive': {
			init: function() {
				// The ID for the list with all the blog posts
				var $container = $('.card-grid');

				//Isotope options, 'Card' matches the class in the PHP
				$container.isotope({
					itemSelector : '.Card', 
			  		layoutMode : 'masonry'
				});
			 
				// Add the class selected to the Card that is clicked, and remove from the others
				var $optionSets = $('.isotope-sortable-menu'),
				$optionLinks = $optionSets.find('a');
			 
				$optionLinks.click(function(){
				var $this = $(this);
				// don't proceed if already selected
				if ( $this.hasClass('is-selected') ) {
				  return false;
				}
				var $optionSet = $this.parents('.isotope-sortable-menu');
				$optionSets.find('.is-selected').removeClass('is-selected');
				$this.addClass('is-selected');
			 
				// When a Card is clicked, sort the items.
				 var selector = $(this).attr('data-filter');
				$container.isotope({ filter: selector });
			 
				return false;
				});
			},
			finalize: function() {
				//
			}
		},
		// About us page, note the change from about-us to about_us.
		'about_us': {
			init: function() {
				// JavaScript to be fired on the about us page
			}
		}
	};

	// The routing fires all common scripts, followed by the page specific scripts.
	// Add additional events for more control over timing e.g. a finalize event
	var UTIL = {
		fire: function(func, funcname, args) {
			var fire;
			var namespace = Chamber;
			funcname = (funcname === undefined) ? 'init' : funcname;
			fire = func !== '';
			fire = fire && namespace[func];
			fire = fire && typeof namespace[func][funcname] === 'function';

			if (fire) {
				namespace[func][funcname](args);
			}
		},
		loadEvents: function() {
			// Fire common init JS
			UTIL.fire('common');

			// Fire page-specific init JS, and then finalize JS
			$.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
				UTIL.fire(classnm);
				UTIL.fire(classnm, 'finalize');
			});

			// Fire common finalize JS
			UTIL.fire('common', 'finalize');
		}
	};

	// Load Events
	$(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.

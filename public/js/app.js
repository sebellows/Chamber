/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {

  const ROOT     = document.documentElement,
        BODY     = document.body,
        NAV      = document.querySelector( '.section-navigation' );

  if ( ! NAV ) {
    return;
  }

  /**
   * Sets or removes .focus class on an element.
   */
  const CLOSE_BUTTON = `
      <button class="menu-toggle-close" aria-controls="dept-menu" aria-expanded="true">
        <span class="screen-reader-text">Close menu</span>
        <span class="icon" m-Icon="close large" aria-hidden="true"><svg role="presentation" viewBox="0 1 24 24"><use xlink:href="#icon-close"></use></svg></span>
      </button>
  `;

  /**
   * Create a Close button for dismissing the menu modal.
   * 
   * @return object
   */
  function createCloseButton() {
    var toggleClose = document.createElement('div');

    toggleClose.style.cssText +=';'+ 'position:absolute;top:3rem;right:2rem;z-index:1201;';
    toggleClose.innerHTML = CLOSE_BUTTON;

    return toggleClose;
  }

  /**
   * Create the menu modal for displaying the section-navigation
   * on small screens.
   * 
   * @return object
   */
  function createModalBackground() {
    var modalBg = document.createElement('div');

    modalBg.classList.add('menu-modal');
    modalBg.setAttribute('aria-ignore', 'true');
    modalBg.style.cssText +=';'+ 'position:absolute;top:0;left:0;width:100vw;height:100vh;';

    return modalBg;
  }

  /**
   * Menu-related constants.
   *
   * @var mixed
   */
  const BUTTON   = document.querySelector( '.menu-toggle' ),
        MASTHEAD = document.querySelector( '#masthead' ),
        MENU     = NAV.getElementsByTagName( 'ul' )[0],
        LINKS    = MENU.getElementsByTagName( 'a' ),
        SUBMENUS = MENU.getElementsByTagName( 'ul' ),
        CLOSE    = createCloseButton(),
        MODAL    = createModalBackground();

  // Return early if the process if `section-navigation` is not present
  // or if the `menu-toggle` button is undefined.
  if ( ! NAV || 'undefined' === typeof BUTTON ) {
    return;
  }

  // Hide menu toggle button if `section-navigation` is empty and return early.
  if ( 'undefined' === typeof MENU ) {
    BUTTON.style.display = 'none';
    return;
  }

  MENU.setAttribute( 'aria-expanded', 'false' );
  if ( -1 === MENU.className.indexOf( 'nav-menu' ) ) {
    MENU.className += ' nav-menu';
  }

  /**
   * Onclick event handler for toggling OPEN the `section-navigation`.
   */
  BUTTON.onclick = function() {
    NAV.className += ' is-active';
    BODY.appendChild(MODAL);
    BUTTON.setAttribute( 'aria-expanded', 'true' );
    MENU.setAttribute( 'aria-expanded', 'true' );
    BODY.appendChild(CLOSE);
    BODY.className += ' navigation-is-open';
    MASTHEAD.style.zIndex = 'initial';
  };

  /**
   * Onclick event handler for toggling CLOSED the `section-navigation`.
   */
  CLOSE.onclick = function() {
    if ( -1 !== NAV.className.indexOf( 'is-active' ) ) {
      NAV.className = NAV.className.replace( ' is-active', '' );
      BODY.removeChild(MODAL);
      BUTTON.setAttribute( 'aria-expanded', 'false' );
      MENU.setAttribute( 'aria-expanded', 'false' );
      BODY.className = BODY.className.replace( ' navigation-is-open', '' );
      MASTHEAD.removeAttribute('style');
      BODY.removeChild(CLOSE);
    }
  };

  // Get all the link elements within the menu.
  var i, len;

  // Set menu items with submenus to aria-haspopup="true".
  for ( i = 0, len = SUBMENUS.length; i < len; i++ ) {
    SUBMENUS[i].parentNode.setAttribute( 'aria-haspopup', 'true' );
  }

  // Each time a menu link is focused or blurred, toggle focus.
  for ( i = 0, len = LINKS.length; i < len; i++ ) {
    LINKS[i].addEventListener( 'focus', toggleFocus, true );
    LINKS[i].addEventListener( 'blur', toggleFocus, true );
  }

  /**
   * Sets or removes .focus class on an element.
   */
  function toggleFocus() {
    var self = this;

    // Move up through the ancestors of the current link until we hit .nav-menu.
    while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

      // On li elements toggle the class .focus.
      if ( 'li' === self.tagName.toLowerCase() ) {
        if ( -1 !== self.className.indexOf( 'focus' ) ) {
          self.className = self.className.replace( ' focus', '' );
        } else {
          self.className += ' focus';
        }
      }

      self = self.parentElement;
    }
  }

  /**
   * Toggles `focus` class to allow submenu access on tablets.
   */
  ( function( NAV ) {
    var touchStartFn, i,
      parentLink = NAV.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

    if ( 'ontouchstart' in window ) {
      touchStartFn = function( e ) {
        var menuItem = this.parentNode, i;

        if ( ! menuItem.classList.contains( 'focus' ) ) {
          e.preventDefault();
          for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
            if ( menuItem === menuItem.parentNode.children[i] ) {
              continue;
            }
            menuItem.parentNode.children[i].classList.remove( 'focus' );
          }
          menuItem.classList.add( 'focus' );
        } else {
          menuItem.classList.remove( 'focus' );
        }
      };

      for ( i = 0; i < parentLink.length; ++i ) {
        parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
      }
    }
  }( NAV ) );
} )();

/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */
( function() {
	var isWebkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	    isOpera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
	    isIe     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( isWebkit || isOpera || isIe ) && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
})();

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

                // Add scroll-scope.js to flickity captions
                $(document).scrollScope();

                // Add YouTube video to modal to prevent it from slowing down page rendering
                if ($(".mediabox .media").length > 0) {
                    createReveal();
                }

                if ($(".reveal").length > 0) {
                    new Foundation.Reveal( $(".reveal") );
                }

                function createReveal() {
                    var $reveal     =   '<div class="reveal" id="videoPlayerReveal" data-reveal>'+
                                        '<div id="videoBox" class="flex-video widescreen media"></div>'+
                                        '</div>';
                    var closeButton =   '<button class="close-button" data-close aria-label="Close modal">'+
                                        '<span class="screen-reader-text">Close modal</span>'+
                                        '<span class="icon" m-Icon="close large" aria-hidden="true">'+
                                        '<svg role="presentation" viewBox="0 1 24 24"><use xlink:href="#icon-close"></use></svg>'+
                                        '</span>'+
                                        '</button>';

                    $('body').append($reveal);

                    // Use `setTimeout` due to delay in `.reveal` getting wrapped by overlay
                    // Close button was moved to prevent it overlapping the video.
                    setTimeout(function() {
                        $('.reveal-overlay').prepend(closeButton);                        
                    }, 500);
                }

                $(document).on('click', "[data-open]", function(e) {
                    var target = $(this).attr("data-open");
                    var mediaAttrs  = atob($(this).attr("data-media"));

                    // Append the iframe attributes to an iframe in the `#videoBox`
                    $("#videoBox").append('<iframe ' + mediaAttrs + '></iframe>');
                    $("#" + target).css('opacity', '1');
                    
                });

                $(document).on(
                    'closed.zf.reveal', function() {
                        $("#videoBox iframe").remove();
                    }
                );
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
            init: (function() {
                // The ID for the list with all the blog posts
                var $container = $('.card-grid');

                //Isotope options, 'Card' matches the class in the PHP
                $container.imagesLoaded( function(){
                    $container.isotope({
                        itemSelector : '.Card', 
                            layoutMode : 'masonry'
                    });
                });
             
                // Add the class selected to the Card that is clicked, and remove from the others
                var $optionSets = $('.isotope-sortable-menu'),
                $optionLinks = $optionSets.find('a');

                $optionLinks.click(function() {
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
            }),
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

//# sourceMappingURL=app.js.map

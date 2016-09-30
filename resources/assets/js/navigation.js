/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {

  const ROOT     = document.documentElement,
        BODY     = document.body;

  if ( ! NAV || 'undefined' === typeof BUTTON ) {
    return;
  }

  const NAV      = document.querySelector( '#deptNavigation' ),
        BUTTON   = document.querySelector( '.menu-toggle' ),
        BACKDROP = document.querySelector( '.menu-backdrop' ),
        MENU     = NAV.getElementsByTagName( 'ul' )[0],
        LINKS    = MENU.getElementsByTagName( 'a' ),
        SUBMENUS = MENU.getElementsByTagName( 'ul' );

  if ( ! NAV || 'undefined' === typeof BUTTON ) {
    return;
  }

  // Hide menu toggle button if menu is empty and return early.
  if ( 'undefined' === typeof MENU ) {
    BUTTON.style.display = 'none';
    return;
  }

  MENU.setAttribute( 'aria-expanded', 'false' );
  if ( -1 === MENU.className.indexOf( 'nav-menu' ) ) {
    MENU.className += ' nav-menu';
  }

  BUTTON.onclick = function() {
    if ( -1 !== NAV.className.indexOf( 'is-active' ) ) {
      NAV.className = NAV.className.replace( ' is-active', '' );
      BUTTON.setAttribute( 'aria-expanded', 'false' );
      MENU.setAttribute( 'aria-expanded', 'false' );
      BACKDROP.className = BACKDROP.className.replace( ' is-visible', '' );
    } else {
      NAV.className += ' is-active';
      BUTTON.setAttribute( 'aria-expanded', 'true' );
      MENU.setAttribute( 'aria-expanded', 'true' );
      BACKDROP.className += ' is-visible';
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

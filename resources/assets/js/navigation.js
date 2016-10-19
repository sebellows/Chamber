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
        <span class="icon" m-Icon="close large"><svg aria-role="presentation" viewBox="0 1 24 24"><use xlink:href="#icon-close"></use></svg></span>
      </button>
  `;

  /**
   * Create a Close button for dismissing the menu modal.
   * 
   * @return object
   */
  function createCloseButton() {
    let toggle = document.createElement('div');

    toggle.style.cssText +=';'+ 'position:absolute;top:3rem;right:2rem;z-index:1201;';
    toggle.innerHTML = CLOSE_BUTTON;

    return toggle;
  }

  /**
   * Create the menu modal for displaying the section-navigation
   * on small screens.
   * 
   * @return object
   */
  function createModalBackground() {
    let modalBg = document.createElement('div');

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

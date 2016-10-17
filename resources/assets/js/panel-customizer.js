/**
 * Theme Customizer enhancements, specific to panels, for a better user experience.
 *
 * This allows us to detect when the user has opened specific sections within the Customizer,
 * and adjust our preview pane accordingly.
 */

( function() {

  // Site title
  if(typeof(wp) == "undefined") {
    return;
  }

  if(typeof(wp.customize) == "undefined") {
    return;
  }

  wp.customize.bind( 'ready', function() {

    // Detect when the section for each panel is expanded (or closed) so we can adjust preview accordingly
    wp.customize.section( 'panel_1' ).expanded.bind( function( isExpanding ) {

      // Value of isExpanding will = true if you're entering the section, false if you're leaving it
      wp.customize.previewer.send( 'section-highlight', { section: 'chamber-panel1', expanded: isExpanding } );
    } );

    // Detect when the section for each panel is expanded (or closed) so we can adjust preview accordingly
    wp.customize.section( 'panel_2' ).expanded.bind( function( isExpanding ) {

      // Value of isExpanding = true if you're entering the section, false if you're leaving it
      wp.customize.previewer.send( 'section-highlight', { section: 'chamber-panel2', expanded: isExpanding } );
    } );

    // Detect when the section for each panel is expanded (or closed) so we can adjust preview accordingly
    wp.customize.section( 'panel_3' ).expanded.bind( function( isExpanding ) {

      // Value of isExpanding will = true if you're entering the section, false if you're leaving it
      wp.customize.previewer.send( 'section-highlight', { section: 'chamber-panel3', expanded: isExpanding } );
    } );

    // Detect when the section for each panel is expanded (or closed) so we can adjust preview accordingly
    wp.customize.section( 'panel_4' ).expanded.bind( function( isExpanding ) {

      // Value of isExpanding will = true if you're entering the section, false if you're leaving it
      wp.customize.previewer.send( 'section-highlight', { section: 'chamber-panel4', expanded: isExpanding } );
    } );

  } );
} )( jQuery );
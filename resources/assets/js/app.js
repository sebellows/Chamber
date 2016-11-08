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
                //$(document).scrollScope();

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

                // DataTables listener
                $(document).ready(function() {
                    // set listener for scroll to top
                    var oldStart = 0;

                    var attractionsTable = $('#attractionsDataTable').DataTable( {
                        "order": [[ 0, "asc" ]],
                        "pagingType": "full_numbers",
                        "lengthMenu": [[10, 25, 50, 100, 150, -1], [10, 25, 50, 100, 150, "All"]],
                        "responsive": false,
                        "language": {
                            "lengthMenu": "Display _MENU_ attractions per page",
                            "zeroRecords": "No attractions found - sorry!",
                            "info": "Showing page _PAGE_ of _PAGES_",
                            "infoEmpty": "No attractions available",
                            "infoFiltered": "(filtered from _MAX_ total attractions)"
                        },
                        "fnDrawCallback": function(o) {
                            // auto scroll to top of table on page change
                            if(o._iDisplayStart != oldStart) {
                                var targetOffset = $('#attractionsDataTable').offset().top;
                                $('html,body').animate({scrollTop: targetOffset}, 500);
                                oldStart = o._iDisplayStart;
                            }
                        },
                    });

                    // our filter terms
                    var filterCity = null;
                    var filterType = null;

                    $('div.filter-buttons button').click(function() {
                        var searchTerm;

                        // build our search terms
                        if($(this).data('filter') == 'city') {
                            if(filterCity)
                            {
                                filterCity.addClass('hollow');
                            }

                            filterCity = $(this);
                            $(this).removeClass('hollow');
                        }
                        else if($(this).data('filter') == 'type'){
                            if(filterType)
                            {
                                filterType.addClass('hollow');
                            }

                            filterType = $(this);
                            $(this).removeClass('hollow');
                        }
                        else {
                            if($(this).data('clear') == 'city') {
                                filterCity.addClass('hollow');
                                filterCity = null;
                            }
                            else {
                                filterType.addClass('hollow');
                                filterType = null;
                            }
                        }

                        // setup our search phrase
                        if(filterCity || filterType) {
                            if(filterCity && filterType) {
                                searchTerm = filterCity.data('value') + ' ' + filterType.data('value');
                            }
                            else if(filterCity) {
                                searchTerm = filterCity.data('value');
                            }
                            else if(filterType) {
                                searchTerm = filterType.data('value');
                            }
                        }
                        else {
                            searchTerm = '';
                        }

                        attractionsTable.search(searchTerm).draw();
                    });

                } );

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
            },
            finalize: function() {
                //
            }
        },
        'data-tables-demo': {
            init: function() {
                if ($.fn.dataTable) {
                    $('#attractionsDataTable_wrapper').dataTable( {
                        language: {
                            searchPlaceholder: "Search"
                        }
                    } );
                }
            },
            finalize: function() {
                //
            }
        },
        'data_grid_attractions': {
            init: function() {
                var $table = $('#dataGrid'),
                $alertBtn = $('#alertButton'),
                full_screen = false;

                $().ready(function(){
                    $table.chamberDataGrid({
                        toolbar: ".toolbar",

                        showRefresh: true,
                        search: true,
                        showToggle: true,
                        showColumns: true,
                        pagination: true,
                        striped: true,
                        pageSize: 10,
                        pageList: [10,25,50,100],

                        formatShowingRows: function(pageFrom, pageTo, totalRows){
                            //do nothing here, we don't want to show the text "showing x of y from..."
                        },
                        formatRecordsPerPage: function(pageNumber){
                            return pageNumber + " rows visible";
                        },
                        icons: {
                            refresh: 'refresh',
                            toggle: 'list',
                            columns: 'columns',
                            detailOpen: 'plus-circle',
                            detailClose: 'minus-circle'
                        }
                    });



                    $(window).resize(function () {
                        $table.chamberDataGrid('resetView');
                    });

                    $alertButton.click(function () {
                        alert("You pressed on Alert");
                    });

                });
            },
            finalize: function() {
                //
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

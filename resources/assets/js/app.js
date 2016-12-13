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

    /**
     * Prepend a class at the start of a class chain on an element.
     *
     * @link   https://stackoverflow.com/questions/14461853/jquery-addclass-to-first-position-of-multiple-classes
     * @param  {array} newClasses
     * @return {array}
     */
    $.fn.extend({
        prependClass: function(newClasses) {
            return this.each(function() {
                var currentClasses = $(this).prop("class");
                $(this).removeClass(currentClasses).addClass(newClasses + " " + currentClasses);
            });
        }
    });

    // Use this variable to set up the common and page specific functions. If you
    // rename this variable, you will also need to rename the namespace below.
    var Chamber = {
        // All pages
        'common': {
            init: function() {
                // JavaScript to be fired on all pages
                
                // added classes to label to denote either a checkbox/radio input
                // and whether it is checked
                // if ( $('input[type="checkbox"]').parent('label') ) {
                //     $('input[type="checkbox"]').parent().addClass( "checkbox" );
                // }
                // if ( $('input[type="checkbox"]:checked').parent('label') ) {
                //     $('input[type="checkbox"]').parent().addClass("filled-in");
                // }
                // if ( $('input[type="checkbox"]:not(:checked)').parent('label').hasClass("filled-in") ) {
                //     $('input[type="checkbox"]').parent( $('label') ).removeClass("filled-in");
                // }
                // if ( $('input[type="radio"]').parent('label') ) {
                //     $('input[type="radio"]').parent().addClass( "radio" );
                // }
                // if ( $('input[type="radio"]:checked').parent('label') ) {
                //     $('input[type="radio"]').parent().addClass("filled-in");
                // }
                // if ( $('input[type="radio"]:not(:checked)').parent('label').hasClass("filled-in") ) {
                //     $('input[type="radio"]').parent('label').removeClass("filled-in");
                // }

                $(document).ready( function () {
                    $(".vfb-checkbox").each( function() {
                        var label = $(this).find("label");
                        var input = $(this).find("input");

                        label.addClass("control checkbox");
                        input.after( '<span class="control-indicator"></span>' );
                    });

                    $(".vfb-radio").each( function() {
                        var label = $(this).find("label");
                        var input = $(this).find("input");

                        label.addClass("control radio");
                        input.after( '<span class="control-indicator"></span>' );
                    });
                });

                // toggle the searchform in the global header
                if ($("#searchForm").length > 0) {
                    new Foundation.Toggler($("#searchForm"));
                }

                // Add class to duplo block if it is hoverable
                if ( $(".duplo-link") ) {
                    $(".duplo-link").parent().addClass("has-duplo-link");
                }

                // Add scroll-scope.js to flickity captions
                if ( $(".dynamic-whitesheet" ).length > 0) {
                    $(document).scrollScope();
                }

                $("#carousel").imagesLoaded().progress( function(instance, image) {
                    var result = image.isLoaded ? 'loaded' : 'broken';
                    if (result === 'loaded') {
                        $(".carousel-caption").addClass("fadeIn");
                        // $("figcaption").addClass("fadeIn").removeClass("hide");
                    }
                });

                if ( $(".reveal").length > 0 ) {
                    new Foundation.Reveal( $(".reveal") );
                }

                $(document).on('closed.zf.reveal', function() {
                    $("#videoBox iframe").remove();
                } );

                if ( $("#contactForm").length > 0 ) {
                    new Foundation.Abide( $("#contactForm") );
                }

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
            init: function() {
                if ( $(".archive-attractions") ) {
                    // The ID for the list with all the blog posts
                    var $container = $('.card-grid');

                    //Isotope options, 'Card' matches the class in the PHP
                    $container.imagesLoaded( function() {
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

                    // Add a body class after isotope's layout is complete.
                    // This prevents the footer from crashing into the card-grid
                    // on initial page load while Isotope does its math.
                    $container.on( 'layoutComplete', function() {
                        $("body").addClass("contentinfo-is-visible");
                    });
                }
            },
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

/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {

    if ( ! Modernizr ) {
        return;
    }

    if ( ! document.querySelector('.stripe.media-block') ) {
        return;
    }

    if ( ! mediaID || ! mediaAttrs ) {
        return;
    }

    const MEDIABLOCK = document.querySelector('.stripe.media-block');

    /**
     * Set multiple attributes on an element.
     * 
     * @param {[object]} el
     * @param {[array]} attrs
     */
    function setAttributes(el, attrs) {
        for(let key in attrs) {
            el.setAttribute(key, attrs[key]);
        }
    }

    /**
     * Add the image `src` for the video poster.
     * 
     * @param {[string]} format i.e., the image formate and size
     */
    function addVideoPosterSrc( format, setWebP = false ) {
        let poster = '';

        if ( setWebP === true ) {
            poster = 'https://i.ytimg.com/vi_webp/' + mediaID + '/' + format + '.webp';
        } else {
            poster = 'https://i.ytimg.com/vi/' + mediaID + '/' + format + '.jpg';
        }

        return poster;          
    }

    /**
     * Add the videoPoster image and `srcset`.
     */
    function addVideoPosterImg( webp ) {
        let sdImage  = addVideoPosterSrc( 'sddefault' ),
            hqImage  = addVideoPosterSrc( 'hqdefault' ),
            maxImage = addVideoPosterSrc( 'maxresdefault' );

        let hiRes = webp === true ? addVideoPosterSrc( 'sddefault', webp ) : sdImage;

        let posterImage = '<img class="video-poster" src="'+
                          hiRes+'" srcset="'+
                          hqImage+' 640w, '+
                          hiRes+' 853w, '+
                          maxImage+' 1280w" sizes="(max-width: 100vw) 853px" alt="video poster image">';

        return posterImage;
    }

    /**
     * Add the SVG play arrow icon to the play button.
     */
    function addPlayButtonSVG() {
        let svg            = document.createElementNS("http://www.w3.org/2000/svg", "svg");
        let pathBG         = document.createElementNS("http://www.w3.org/2000/svg", "path");
        let pathPlayArrow1 = document.createElementNS("http://www.w3.org/2000/svg", "path");
        let pathPlayArrow2 = document.createElementNS("http://www.w3.org/2000/svg", "path");

        setAttributes( svg, {
            'viewBox': '0 0 68 48', 
            'height': '100%', 
            'style': 'pointer-events:none;'
        } );

        setAttributes( pathBG, {
            'd': 'm .66,37.62 c 0,0 .66,4.70 2.70,6.77 2.58,2.71 5.98,2.63 7.49,2.91 5.43,.52 23.10,.68 23.12,.68 .00,-1.3e-5 14.29,-0.02 23.81,-0.71 1.32,-0.15 4.22,-0.17 6.81,-2.89 2.03,-2.07 2.70,-6.77 2.70,-6.77 0,0 .67,-5.52 .67,-11.04 l 0,-5.17 c 0,-5.52 -0.67,-11.04 -0.67,-11.04 0,0 -0.66,-4.70 -2.70,-6.77 C 62.03,.86 59.13,.84 57.80,.69 48.28,0 34.00,0 34.00,0 33.97,0 19.69,0 10.18,.69 8.85,.84 5.95,.86 3.36,3.58 1.32,5.65 .66,10.35 .66,10.35 c 0,0 -0.55,4.50 -0.66,9.45 l 0,8.36 c .10,4.94 .66,9.45 .66,9.45 z',
            'fill': '#1f1f1e',
            'fill-opacity': '0.81'
        } );

        setAttributes( pathPlayArrow1, {
            'd': 'm 26.96,13.67 18.37,9.62 -18.37,9.55 -0.00,-19.17 z',
            'fill': '#fff'
        } );

        setAttributes( pathPlayArrow2, {
            'd': 'M 45.02,23.46 45.32,23.28 26.96,13.67 43.32,24.34 45.02,23.46 z',
            'fill': '#ccc'
        } );
        
        svg.appendChild(pathBG);
        svg.appendChild(pathPlayArrow1);
        svg.appendChild(pathPlayArrow2);

        return svg;
    }

    /**
     * Add the play button to the video slot atop the videoPoster image.
     * 
     * @param {[array]} attrs
     */
    function addVideoButton( attrs ) {
        let videoButton     = document.createElement("button");
        let videoButtonIcon = addPlayButtonSVG();

        setAttributes(
            videoButton,
            {
                "class": "playButton",
                "aria-label": "Play video in modal window",
                "data-open": "videoPlayerReveal",
                "data-media": '"' + attrs + '"'
            }
        );

        videoButton.appendChild(videoButtonIcon);

        return videoButton;
    }

    /**
     * Create the videoPoster image and play button which will inject 
     * the real video into a modal when clicked.
     * 
     * @return object
     */
    function videoPoster( attrs, webp = false ) {
        let videoSlot        = document.querySelector('.media-block .flex-video');
        let videoPosterImage = addVideoPosterImg( attrs, webp );
        let videoPlayButton  = addVideoButton( attrs );

        videoSlot.innerHTML = videoPosterImage;
        videoSlot.appendChild(videoPlayButton);

        return videoSlot;
    }

    if ( MEDIABLOCK ) {
        videoPoster( mediaAttrs, hasWebP );
    }

} )();

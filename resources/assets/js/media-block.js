import * as lazyImages from './lazy-image-loading.js';

/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function () {

    "use strict";

    if ( ! Modernizr ) {
        return;
    }

    if ( ! document.querySelector('.stripe.media-block') ) {
        return;
    }

    const MEDIABLOCK  = document.querySelector('.stripe.media-block');
    const VIDEOBLOCK  = MEDIABLOCK.querySelector('.flex-video');
    const WEBP        = Modernizr.webp;

    mediaID    = typeof mediaID === "undefined" ? '' : mediaID;
    mediaAttrs = typeof mediaAttrs === "undefined" ? '' : mediaAttrs;

    /**
     * Set multiple attributes on an element.
     *
     * @source http://stackoverflowu
     * 
     * .com/questions/12274748/setting-multiple-attributes-for-an-element-at-once-with-javascript
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
     * @param {[string]} format i.e., the image format and size
     */
    function addVideoPosterSrc( format, WEBP ) {
        let poster = '';

        let extension = WEBP ? '.webp' : '.jpg';

        if ( WEBP ) {
            poster = 'https://i.ytimg.com/vi_webp/' + mediaID + '/' + format + extension;
        } else {
            poster = 'https://i.ytimg.com/vi/' + mediaID + '/' + format + extension;
        }

        return poster;          
    }

    /**
     * Add the videoPoster image and `srcset`.
     */
    function addVideoPosterImg( WEBP ) {
        let posterImage = '';

        let sdImage  = addVideoPosterSrc( 'sddefault' ),
            hqImage  = addVideoPosterSrc( 'hqdefault' ),
            maxImage = addVideoPosterSrc( 'maxresdefault' );

        let hiRes = WEBP ? addVideoPosterSrc( 'sddefault', WEBP ) : sdImage;

        if ( WEBP ) {
            posterImage = '<img class="lazy video-poster" data-src="'+hiRes+'">';
        } else {
            posterImage = '<img class="lazy video-poster" data-src="'+
                          hiRes+'" data-srcset="'+
                          hqImage+' 640w, '+
                          hiRes+' 853w, '+
                          maxImage+' 1280w" sizes="(max-width: 100vw) 853px" alt="video poster image">';
        }

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
    function videoPoster( attrs, WEBP ) {
        let videoSlot        = document.querySelector('.media-block .flex-video');
        let videoPosterImage = addVideoPosterImg( attrs, WEBP );
        let videoPlayButton  = addVideoButton( attrs );

        videoSlot.insertAdjacentHTML('afterbegin', videoPosterImage);
        videoSlot.appendChild(videoPlayButton);

        return videoSlot;
    }

    function lazyLoadVideoPoster() {
        window.addEventListener('load', lazyImages.setLazy);
        window.addEventListener('load', lazyImages.lazyLoad);
        window.addEventListener('scroll', lazyImages.lazyLoad);
        window.addEventListener('resize', lazyImages.lazyLoad);
    }

    if ( VIDEOBLOCK ) {
        videoPoster( mediaAttrs, WEBP );
        lazyLoadVideoPoster();
    }

    // Add YouTube video to modal to prevent it from slowing down page rendering
    if ( document.querySelector( ".mediabox .media" ) ) {
        createReveal();
    }

    /**
     * Create the markup required to use Foundation's Reveal modal.
     * 
     * @return {object} the Reveal module
     */
    function createReveal() {
        let videoBox = `
            <div id="videoBox" class="flex-video widescreen media"></div>
        `;

        let closeButton =  `
            <button class="close-button" data-close aria-label="Close modal">
                <span class="screen-reader-text">Close modal</span>
                <span class="icon" m-Icon="close large" aria-hidden="true">
                    <svg role="presentation" viewBox="0 1 24 24"><use xlink:href="#icon-close"></use></svg>
                </span>
            </button>
        `;

        let reveal = document.createElement("div");

        setAttributes(reveal, {
            "class": "reveal",
            "id": "videoPlayerReveal",
            "data-reveal": ""
        });

        reveal.innerHTML = videoBox;

        document.body.appendChild(reveal);

        // Use `setTimeout` due to delay in `.reveal` getting wrapped by overlay
        // Close button was moved to prevent it overlapping the video.
        setTimeout(function() {
            document.querySelector('.reveal-overlay').insertAdjacentHTML('afterbegin', closeButton);
        }, 500);
    };

    /**
     * Generate a new iframe from the modified pieces set in our ACF oEmbed
     * object, using a decoded set of attributes that were encoded via PHP
     * in our template.
     * 
     * @param  {object} target The playButton's target
     * @return {object}        The new iframe
     */
    function generateIframe( target ) {
        let targetObj  = target.getAttribute("data-open");
        let attrs = decodeURIComponent(escape(window.atob(mediaAttrs)));

        // Append the iframe attributes to an iframe in the `#videoBox`
        document.querySelector("#" + targetObj).style.cssText +=";"+ "opacity:1;";

        let iframeTemplate = `
            <iframe ${attrs}></iframe>
        `;

        if (document.querySelector("#videoBox")) {
            document.querySelector("#videoBox").innerHTML = iframeTemplate;
        }
    }

    // Add the event listener that will generate the iframe.
    document.addEventListener("click", function(e) {
        if ( e.target.hasAttribute("data-open") ) {
            generateIframe(e.target);
        }
    });

} )();

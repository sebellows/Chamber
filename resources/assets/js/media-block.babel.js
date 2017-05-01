(function (exports) {
'use strict';

// ------------- lazy-image-loading.js ------------- //

var LazyImages = function LazyImages() {
    this.lazy = document.querySelectorAll('.lazy');
};

LazyImages.prototype.lazyLoad = function lazyLoad () {
        var this$1 = this;

    var images = this.lazy;

    for (var i = 0; i < images.length; i++){
        if(this$1.isInViewport(images[i])){
            if (images[i].getAttribute('data-src')){
                images[i].src = images[i].getAttribute('data-src');
                images[i].removeAttribute('data-src');
            }
            if (images[i].getAttribute('data-srcset')){
                images[i].srcset = images[i].getAttribute('data-srcset');
                images[i].removeAttribute('data-srcset');
            }
            images[i].classList.add("is-loaded");
        }
    }

    this.cleanLazy();
};

LazyImages.prototype.cleanLazy = function cleanLazy () {
    Array.prototype.filter.call(this.lazy, function(l) { 
        return l.getAttribute('data-src');
    });
};

LazyImages.prototype.isInViewport = function isInViewport (lazy) {
    var rect = lazy.getBoundingClientRect();
        
    return (
        rect.bottom >= 0 && 
        rect.right  >= 0 && 
        rect.top<= (window.innerHeight || document.documentElement.clientHeight) && 
        rect.left   <= (window.innerWidth || document.documentElement.clientWidth)
     );
};

LazyImages.prototype.onChange = function onChange () {
        var args = [], len = arguments.length;
        while ( len-- ) args[ len ] = arguments[ len ];

    return args;
};

/**
 * media-block.js.
 *
 * Add videoPoster image from YouTube video to media-block stripe.
 */
( function () {

    "use strict";

    // if ( ! document.querySelector('.stripe.media-block') ) {
    //     return;
    // }

    if ( ! document.querySelector('.stripe.media-block .flex-video') ) {
        return;
    }

    var MEDIABLOCK  = document.querySelector('.stripe.media-block');
    var VIDEOBLOCK  = MEDIABLOCK.querySelector('.flex-video');

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
        for(var key in attrs) {
            el.setAttribute(key, attrs[key]);
        }
    }

    /**
     * Add the image `src` for the video poster.
     * 
     * @return {Object}
     */
    function setVideoPosterImage() {
        var poster = '';

        poster = '<img class="lazy video-poster" data-src="https://i.ytimg.com/vi/' + mediaID + '/sddefault.jpg" />';

        return poster;
    }

    /**
     * Add the SVG play arrow icon to the play button.
     */
    function addPlayButtonSVG() {
        var svg            = document.createElementNS("http://www.w3.org/2000/svg", "svg");
        var pathBG         = document.createElementNS("http://www.w3.org/2000/svg", "path");
        var pathPlayArrow1 = document.createElementNS("http://www.w3.org/2000/svg", "path");
        var pathPlayArrow2 = document.createElementNS("http://www.w3.org/2000/svg", "path");

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
        var videoButton     = document.createElement("button");
        var videoButtonIcon = addPlayButtonSVG();

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
    function videoPoster( attrs ) {
        var videoSlot        = document.querySelector('.media-block .flex-video');
        var videoPosterImage = setVideoPosterImage();
        var videoPlayButton  = addVideoButton( attrs );

        videoSlot.insertAdjacentHTML('afterbegin', videoPosterImage);
        videoSlot.appendChild(videoPlayButton);

        return videoSlot;
    }

    if ( VIDEOBLOCK ) {
        videoPoster( mediaAttrs );
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
        var videoBox = "\n            <div id=\"videoBox\" class=\"flex-video widescreen media\"></div>\n        ";

        var closeButton =  "\n            <button class=\"close-button\" data-close aria-label=\"Close modal\">\n                <span class=\"screen-reader-text\">Close modal</span>\n                <span class=\"icon\" m-Icon=\"close large\" aria-hidden=\"true\">\n                    <svg role=\"presentation\" viewBox=\"0 1 24 24\"><use xlink:href=\"#icon-close\"></use></svg>\n                </span>\n            </button>\n        ";

        var reveal = document.createElement("div");

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
    }

    /**
     * Generate a new iframe from the modified pieces set in our ACF oEmbed
     * object, using a decoded set of attributes that were encoded via PHP
     * in our template.
     * 
     * @param  {object} target The playButton's target
     * @return {object}        The new iframe
     */
    function generateIframe( target ) {
        var targetObj  = target.getAttribute("data-open");
        var attrs = decodeURIComponent(escape(window.atob(mediaAttrs)));

        // Append the iframe attributes to an iframe in the `#videoBox`
        document.querySelector("#" + targetObj).style.cssText +=";"+ "opacity:1;";

        var iframeTemplate = "\n            <iframe " + attrs + "></iframe>\n        ";

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

( function () {
    var LAZY = new LazyImages;
    var loadLazily = function (_) { LAZY.lazyLoad(); };

    window.addEventListener('load', loadLazily, false);
    window.addEventListener('resize', loadLazily, false);
    window.addEventListener('scroll', loadLazily, false);

    // window.removeEventListener('load', loadLazily, false);
    // window.removeEventListener('resize', loadLazily, false);
    // window.removeEventListener('scroll', loadLazily, false);
})();

}((this.LaravelElixirBundle = this.LaravelElixirBundle || {})));
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjpudWxsLCJzb3VyY2VzIjpbIi9Vc2Vycy9qb2VsaG93YXJkL0Rlc2t0b3AvY3VycmVudCBwcm9qZWN0cy9jaGFtYmVyL3dwLWNvbnRlbnQvdGhlbWVzL0NoYW1iZXIvcmVzb3VyY2VzL2Fzc2V0cy9qcy9sYXp5LWltYWdlLWxvYWRpbmcuanMiLCIvVXNlcnMvam9lbGhvd2FyZC9EZXNrdG9wL2N1cnJlbnQgcHJvamVjdHMvY2hhbWJlci93cC1jb250ZW50L3RoZW1lcy9DaGFtYmVyL3Jlc291cmNlcy9hc3NldHMvanMvbWVkaWEtYmxvY2suanMiXSwic291cmNlc0NvbnRlbnQiOlsiLy8gLS0tLS0tLS0tLS0tLSBsYXp5LWltYWdlLWxvYWRpbmcuanMgLS0tLS0tLS0tLS0tLSAvL1xuXG5leHBvcnQgZGVmYXVsdCBjbGFzcyBMYXp5SW1hZ2VzIHtcblxuICAgIGNvbnN0cnVjdG9yKCkge1xuICAgICAgICB0aGlzLmxhenkgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yQWxsKCcubGF6eScpO1xuICAgIH1cblxuICAgIGxhenlMb2FkKCkge1xuICAgICAgICBsZXQgaW1hZ2VzID0gdGhpcy5sYXp5O1xuXG4gICAgICAgIGZvciAobGV0IGkgPSAwOyBpIDwgaW1hZ2VzLmxlbmd0aDsgaSsrKXtcbiAgICAgICAgICAgIGlmKHRoaXMuaXNJblZpZXdwb3J0KGltYWdlc1tpXSkpe1xuICAgICAgICAgICAgICAgIGlmIChpbWFnZXNbaV0uZ2V0QXR0cmlidXRlKCdkYXRhLXNyYycpKXtcbiAgICAgICAgICAgICAgICAgICAgaW1hZ2VzW2ldLnNyYyA9IGltYWdlc1tpXS5nZXRBdHRyaWJ1dGUoJ2RhdGEtc3JjJyk7XG4gICAgICAgICAgICAgICAgICAgIGltYWdlc1tpXS5yZW1vdmVBdHRyaWJ1dGUoJ2RhdGEtc3JjJyk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGlmIChpbWFnZXNbaV0uZ2V0QXR0cmlidXRlKCdkYXRhLXNyY3NldCcpKXtcbiAgICAgICAgICAgICAgICAgICAgaW1hZ2VzW2ldLnNyY3NldCA9IGltYWdlc1tpXS5nZXRBdHRyaWJ1dGUoJ2RhdGEtc3Jjc2V0Jyk7XG4gICAgICAgICAgICAgICAgICAgIGltYWdlc1tpXS5yZW1vdmVBdHRyaWJ1dGUoJ2RhdGEtc3Jjc2V0Jyk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGltYWdlc1tpXS5jbGFzc0xpc3QuYWRkKFwiaXMtbG9hZGVkXCIpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9XG5cbiAgICAgICAgdGhpcy5jbGVhbkxhenkoKTtcbiAgICB9XG5cbiAgICBjbGVhbkxhenkoKSB7XG4gICAgICAgIEFycmF5LnByb3RvdHlwZS5maWx0ZXIuY2FsbCh0aGlzLmxhenksIGZ1bmN0aW9uKGwpIHsgXG4gICAgICAgICAgICByZXR1cm4gbC5nZXRBdHRyaWJ1dGUoJ2RhdGEtc3JjJyk7XG4gICAgICAgIH0pO1xuICAgIH1cblxuICAgIGlzSW5WaWV3cG9ydChsYXp5KSB7XG4gICAgICAgIGxldCByZWN0ID0gbGF6eS5nZXRCb3VuZGluZ0NsaWVudFJlY3QoKTtcbiAgICAgICAgXG4gICAgICAgIHJldHVybiAoXG4gICAgICAgICAgICByZWN0LmJvdHRvbSA+PSAwICYmIFxuICAgICAgICAgICAgcmVjdC5yaWdodCAgPj0gMCAmJiBcbiAgICAgICAgICAgIHJlY3QudG9wICAgIDw9ICh3aW5kb3cuaW5uZXJIZWlnaHQgfHwgZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50LmNsaWVudEhlaWdodCkgJiYgXG4gICAgICAgICAgICByZWN0LmxlZnQgICA8PSAod2luZG93LmlubmVyV2lkdGggfHwgZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50LmNsaWVudFdpZHRoKVxuICAgICAgICAgKTtcbiAgICB9XG5cbiAgICBvbkNoYW5nZSguLi5hcmdzKSB7XG4gICAgICAgIHJldHVybiBhcmdzO1xuICAgIH1cblxufSIsImltcG9ydCBMYXp5SW1hZ2VzIGZyb20gJy4vbGF6eS1pbWFnZS1sb2FkaW5nLmpzJztcblxuLyoqXG4gKiBtZWRpYS1ibG9jay5qcy5cbiAqXG4gKiBBZGQgdmlkZW9Qb3N0ZXIgaW1hZ2UgZnJvbSBZb3VUdWJlIHZpZGVvIHRvIG1lZGlhLWJsb2NrIHN0cmlwZS5cbiAqL1xuKCBmdW5jdGlvbiAoKSB7XG5cbiAgICBcInVzZSBzdHJpY3RcIjtcblxuICAgIC8vIGlmICggISBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuc3RyaXBlLm1lZGlhLWJsb2NrJykgKSB7XG4gICAgLy8gICAgIHJldHVybjtcbiAgICAvLyB9XG5cbiAgICBpZiAoICEgZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLnN0cmlwZS5tZWRpYS1ibG9jayAuZmxleC12aWRlbycpICkge1xuICAgICAgICByZXR1cm47XG4gICAgfVxuXG4gICAgY29uc3QgTUVESUFCTE9DSyAgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuc3RyaXBlLm1lZGlhLWJsb2NrJyk7XG4gICAgY29uc3QgVklERU9CTE9DSyAgPSBNRURJQUJMT0NLLnF1ZXJ5U2VsZWN0b3IoJy5mbGV4LXZpZGVvJyk7XG5cbiAgICBtZWRpYUlEICAgID0gdHlwZW9mIG1lZGlhSUQgPT09IFwidW5kZWZpbmVkXCIgPyAnJyA6IG1lZGlhSUQ7XG4gICAgbWVkaWFBdHRycyA9IHR5cGVvZiBtZWRpYUF0dHJzID09PSBcInVuZGVmaW5lZFwiID8gJycgOiBtZWRpYUF0dHJzO1xuXG4gICAgLyoqXG4gICAgICogU2V0IG11bHRpcGxlIGF0dHJpYnV0ZXMgb24gYW4gZWxlbWVudC5cbiAgICAgKlxuICAgICAqIEBzb3VyY2UgaHR0cDovL3N0YWNrb3ZlcmZsb3d1XG4gICAgICogXG4gICAgICogLmNvbS9xdWVzdGlvbnMvMTIyNzQ3NDgvc2V0dGluZy1tdWx0aXBsZS1hdHRyaWJ1dGVzLWZvci1hbi1lbGVtZW50LWF0LW9uY2Utd2l0aC1qYXZhc2NyaXB0XG4gICAgICogXG4gICAgICogQHBhcmFtIHtbb2JqZWN0XX0gZWxcbiAgICAgKiBAcGFyYW0ge1thcnJheV19IGF0dHJzXG4gICAgICovXG4gICAgZnVuY3Rpb24gc2V0QXR0cmlidXRlcyhlbCwgYXR0cnMpIHtcbiAgICAgICAgZm9yKGxldCBrZXkgaW4gYXR0cnMpIHtcbiAgICAgICAgICAgIGVsLnNldEF0dHJpYnV0ZShrZXksIGF0dHJzW2tleV0pO1xuICAgICAgICB9XG4gICAgfVxuXG4gICAgLyoqXG4gICAgICogQWRkIHRoZSBpbWFnZSBgc3JjYCBmb3IgdGhlIHZpZGVvIHBvc3Rlci5cbiAgICAgKiBcbiAgICAgKiBAcmV0dXJuIHtPYmplY3R9XG4gICAgICovXG4gICAgZnVuY3Rpb24gc2V0VmlkZW9Qb3N0ZXJJbWFnZSgpIHtcbiAgICAgICAgbGV0IHBvc3RlciA9ICcnO1xuXG4gICAgICAgIHBvc3RlciA9ICc8aW1nIGNsYXNzPVwibGF6eSB2aWRlby1wb3N0ZXJcIiBkYXRhLXNyYz1cImh0dHBzOi8vaS55dGltZy5jb20vdmkvJyArIG1lZGlhSUQgKyAnL3NkZGVmYXVsdC5qcGdcIiAvPic7XG5cbiAgICAgICAgcmV0dXJuIHBvc3RlcjtcbiAgICB9XG5cbiAgICAvKipcbiAgICAgKiBBZGQgdGhlIFNWRyBwbGF5IGFycm93IGljb24gdG8gdGhlIHBsYXkgYnV0dG9uLlxuICAgICAqL1xuICAgIGZ1bmN0aW9uIGFkZFBsYXlCdXR0b25TVkcoKSB7XG4gICAgICAgIGxldCBzdmcgICAgICAgICAgICA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnROUyhcImh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnXCIsIFwic3ZnXCIpO1xuICAgICAgICBsZXQgcGF0aEJHICAgICAgICAgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50TlMoXCJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2Z1wiLCBcInBhdGhcIik7XG4gICAgICAgIGxldCBwYXRoUGxheUFycm93MSA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnROUyhcImh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnXCIsIFwicGF0aFwiKTtcbiAgICAgICAgbGV0IHBhdGhQbGF5QXJyb3cyID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudE5TKFwiaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmdcIiwgXCJwYXRoXCIpO1xuXG4gICAgICAgIHNldEF0dHJpYnV0ZXMoIHN2Zywge1xuICAgICAgICAgICAgJ3ZpZXdCb3gnOiAnMCAwIDY4IDQ4JywgXG4gICAgICAgICAgICAnaGVpZ2h0JzogJzEwMCUnLCBcbiAgICAgICAgICAgICdzdHlsZSc6ICdwb2ludGVyLWV2ZW50czpub25lOydcbiAgICAgICAgfSApO1xuXG4gICAgICAgIHNldEF0dHJpYnV0ZXMoIHBhdGhCRywge1xuICAgICAgICAgICAgJ2QnOiAnbSAuNjYsMzcuNjIgYyAwLDAgLjY2LDQuNzAgMi43MCw2Ljc3IDIuNTgsMi43MSA1Ljk4LDIuNjMgNy40OSwyLjkxIDUuNDMsLjUyIDIzLjEwLC42OCAyMy4xMiwuNjggLjAwLC0xLjNlLTUgMTQuMjksLTAuMDIgMjMuODEsLTAuNzEgMS4zMiwtMC4xNSA0LjIyLC0wLjE3IDYuODEsLTIuODkgMi4wMywtMi4wNyAyLjcwLC02Ljc3IDIuNzAsLTYuNzcgMCwwIC42NywtNS41MiAuNjcsLTExLjA0IGwgMCwtNS4xNyBjIDAsLTUuNTIgLTAuNjcsLTExLjA0IC0wLjY3LC0xMS4wNCAwLDAgLTAuNjYsLTQuNzAgLTIuNzAsLTYuNzcgQyA2Mi4wMywuODYgNTkuMTMsLjg0IDU3LjgwLC42OSA0OC4yOCwwIDM0LjAwLDAgMzQuMDAsMCAzMy45NywwIDE5LjY5LDAgMTAuMTgsLjY5IDguODUsLjg0IDUuOTUsLjg2IDMuMzYsMy41OCAxLjMyLDUuNjUgLjY2LDEwLjM1IC42NiwxMC4zNSBjIDAsMCAtMC41NSw0LjUwIC0wLjY2LDkuNDUgbCAwLDguMzYgYyAuMTAsNC45NCAuNjYsOS40NSAuNjYsOS40NSB6JyxcbiAgICAgICAgICAgICdmaWxsJzogJyMxZjFmMWUnLFxuICAgICAgICAgICAgJ2ZpbGwtb3BhY2l0eSc6ICcwLjgxJ1xuICAgICAgICB9ICk7XG5cbiAgICAgICAgc2V0QXR0cmlidXRlcyggcGF0aFBsYXlBcnJvdzEsIHtcbiAgICAgICAgICAgICdkJzogJ20gMjYuOTYsMTMuNjcgMTguMzcsOS42MiAtMTguMzcsOS41NSAtMC4wMCwtMTkuMTcgeicsXG4gICAgICAgICAgICAnZmlsbCc6ICcjZmZmJ1xuICAgICAgICB9ICk7XG5cbiAgICAgICAgc2V0QXR0cmlidXRlcyggcGF0aFBsYXlBcnJvdzIsIHtcbiAgICAgICAgICAgICdkJzogJ00gNDUuMDIsMjMuNDYgNDUuMzIsMjMuMjggMjYuOTYsMTMuNjcgNDMuMzIsMjQuMzQgNDUuMDIsMjMuNDYgeicsXG4gICAgICAgICAgICAnZmlsbCc6ICcjY2NjJ1xuICAgICAgICB9ICk7XG4gICAgICAgIFxuICAgICAgICBzdmcuYXBwZW5kQ2hpbGQocGF0aEJHKTtcbiAgICAgICAgc3ZnLmFwcGVuZENoaWxkKHBhdGhQbGF5QXJyb3cxKTtcbiAgICAgICAgc3ZnLmFwcGVuZENoaWxkKHBhdGhQbGF5QXJyb3cyKTtcblxuICAgICAgICByZXR1cm4gc3ZnO1xuICAgIH1cblxuICAgIC8qKlxuICAgICAqIEFkZCB0aGUgcGxheSBidXR0b24gdG8gdGhlIHZpZGVvIHNsb3QgYXRvcCB0aGUgdmlkZW9Qb3N0ZXIgaW1hZ2UuXG4gICAgICogXG4gICAgICogQHBhcmFtIHtbYXJyYXldfSBhdHRyc1xuICAgICAqL1xuICAgIGZ1bmN0aW9uIGFkZFZpZGVvQnV0dG9uKCBhdHRycyApIHtcbiAgICAgICAgbGV0IHZpZGVvQnV0dG9uICAgICA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoXCJidXR0b25cIik7XG4gICAgICAgIGxldCB2aWRlb0J1dHRvbkljb24gPSBhZGRQbGF5QnV0dG9uU1ZHKCk7XG5cbiAgICAgICAgc2V0QXR0cmlidXRlcyhcbiAgICAgICAgICAgIHZpZGVvQnV0dG9uLFxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIFwiY2xhc3NcIjogXCJwbGF5QnV0dG9uXCIsXG4gICAgICAgICAgICAgICAgXCJhcmlhLWxhYmVsXCI6IFwiUGxheSB2aWRlbyBpbiBtb2RhbCB3aW5kb3dcIixcbiAgICAgICAgICAgICAgICBcImRhdGEtb3BlblwiOiBcInZpZGVvUGxheWVyUmV2ZWFsXCIsXG4gICAgICAgICAgICAgICAgXCJkYXRhLW1lZGlhXCI6ICdcIicgKyBhdHRycyArICdcIidcbiAgICAgICAgICAgIH1cbiAgICAgICAgKTtcblxuICAgICAgICB2aWRlb0J1dHRvbi5hcHBlbmRDaGlsZCh2aWRlb0J1dHRvbkljb24pO1xuXG4gICAgICAgIHJldHVybiB2aWRlb0J1dHRvbjtcbiAgICB9XG5cbiAgICAvKipcbiAgICAgKiBDcmVhdGUgdGhlIHZpZGVvUG9zdGVyIGltYWdlIGFuZCBwbGF5IGJ1dHRvbiB3aGljaCB3aWxsIGluamVjdCBcbiAgICAgKiB0aGUgcmVhbCB2aWRlbyBpbnRvIGEgbW9kYWwgd2hlbiBjbGlja2VkLlxuICAgICAqIFxuICAgICAqIEByZXR1cm4gb2JqZWN0XG4gICAgICovXG4gICAgZnVuY3Rpb24gdmlkZW9Qb3N0ZXIoIGF0dHJzICkge1xuICAgICAgICBsZXQgdmlkZW9TbG90ICAgICAgICA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5tZWRpYS1ibG9jayAuZmxleC12aWRlbycpO1xuICAgICAgICBsZXQgdmlkZW9Qb3N0ZXJJbWFnZSA9IHNldFZpZGVvUG9zdGVySW1hZ2UoKTtcbiAgICAgICAgbGV0IHZpZGVvUGxheUJ1dHRvbiAgPSBhZGRWaWRlb0J1dHRvbiggYXR0cnMgKTtcblxuICAgICAgICB2aWRlb1Nsb3QuaW5zZXJ0QWRqYWNlbnRIVE1MKCdhZnRlcmJlZ2luJywgdmlkZW9Qb3N0ZXJJbWFnZSk7XG4gICAgICAgIHZpZGVvU2xvdC5hcHBlbmRDaGlsZCh2aWRlb1BsYXlCdXR0b24pO1xuXG4gICAgICAgIHJldHVybiB2aWRlb1Nsb3Q7XG4gICAgfVxuXG4gICAgaWYgKCBWSURFT0JMT0NLICkge1xuICAgICAgICB2aWRlb1Bvc3RlciggbWVkaWFBdHRycyApO1xuICAgIH1cblxuICAgIC8vIEFkZCBZb3VUdWJlIHZpZGVvIHRvIG1vZGFsIHRvIHByZXZlbnQgaXQgZnJvbSBzbG93aW5nIGRvd24gcGFnZSByZW5kZXJpbmdcbiAgICBpZiAoIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoIFwiLm1lZGlhYm94IC5tZWRpYVwiICkgKSB7XG4gICAgICAgIGNyZWF0ZVJldmVhbCgpO1xuICAgIH1cblxuICAgIC8qKlxuICAgICAqIENyZWF0ZSB0aGUgbWFya3VwIHJlcXVpcmVkIHRvIHVzZSBGb3VuZGF0aW9uJ3MgUmV2ZWFsIG1vZGFsLlxuICAgICAqIFxuICAgICAqIEByZXR1cm4ge29iamVjdH0gdGhlIFJldmVhbCBtb2R1bGVcbiAgICAgKi9cbiAgICBmdW5jdGlvbiBjcmVhdGVSZXZlYWwoKSB7XG4gICAgICAgIGxldCB2aWRlb0JveCA9IGBcbiAgICAgICAgICAgIDxkaXYgaWQ9XCJ2aWRlb0JveFwiIGNsYXNzPVwiZmxleC12aWRlbyB3aWRlc2NyZWVuIG1lZGlhXCI+PC9kaXY+XG4gICAgICAgIGA7XG5cbiAgICAgICAgbGV0IGNsb3NlQnV0dG9uID0gIGBcbiAgICAgICAgICAgIDxidXR0b24gY2xhc3M9XCJjbG9zZS1idXR0b25cIiBkYXRhLWNsb3NlIGFyaWEtbGFiZWw9XCJDbG9zZSBtb2RhbFwiPlxuICAgICAgICAgICAgICAgIDxzcGFuIGNsYXNzPVwic2NyZWVuLXJlYWRlci10ZXh0XCI+Q2xvc2UgbW9kYWw8L3NwYW4+XG4gICAgICAgICAgICAgICAgPHNwYW4gY2xhc3M9XCJpY29uXCIgbS1JY29uPVwiY2xvc2UgbGFyZ2VcIiBhcmlhLWhpZGRlbj1cInRydWVcIj5cbiAgICAgICAgICAgICAgICAgICAgPHN2ZyByb2xlPVwicHJlc2VudGF0aW9uXCIgdmlld0JveD1cIjAgMSAyNCAyNFwiPjx1c2UgeGxpbms6aHJlZj1cIiNpY29uLWNsb3NlXCI+PC91c2U+PC9zdmc+XG4gICAgICAgICAgICAgICAgPC9zcGFuPlxuICAgICAgICAgICAgPC9idXR0b24+XG4gICAgICAgIGA7XG5cbiAgICAgICAgbGV0IHJldmVhbCA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoXCJkaXZcIik7XG5cbiAgICAgICAgc2V0QXR0cmlidXRlcyhyZXZlYWwsIHtcbiAgICAgICAgICAgIFwiY2xhc3NcIjogXCJyZXZlYWxcIixcbiAgICAgICAgICAgIFwiaWRcIjogXCJ2aWRlb1BsYXllclJldmVhbFwiLFxuICAgICAgICAgICAgXCJkYXRhLXJldmVhbFwiOiBcIlwiXG4gICAgICAgIH0pO1xuXG4gICAgICAgIHJldmVhbC5pbm5lckhUTUwgPSB2aWRlb0JveDtcblxuICAgICAgICBkb2N1bWVudC5ib2R5LmFwcGVuZENoaWxkKHJldmVhbCk7XG5cbiAgICAgICAgLy8gVXNlIGBzZXRUaW1lb3V0YCBkdWUgdG8gZGVsYXkgaW4gYC5yZXZlYWxgIGdldHRpbmcgd3JhcHBlZCBieSBvdmVybGF5XG4gICAgICAgIC8vIENsb3NlIGJ1dHRvbiB3YXMgbW92ZWQgdG8gcHJldmVudCBpdCBvdmVybGFwcGluZyB0aGUgdmlkZW8uXG4gICAgICAgIHNldFRpbWVvdXQoZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcucmV2ZWFsLW92ZXJsYXknKS5pbnNlcnRBZGphY2VudEhUTUwoJ2FmdGVyYmVnaW4nLCBjbG9zZUJ1dHRvbik7XG4gICAgICAgIH0sIDUwMCk7XG4gICAgfTtcblxuICAgIC8qKlxuICAgICAqIEdlbmVyYXRlIGEgbmV3IGlmcmFtZSBmcm9tIHRoZSBtb2RpZmllZCBwaWVjZXMgc2V0IGluIG91ciBBQ0Ygb0VtYmVkXG4gICAgICogb2JqZWN0LCB1c2luZyBhIGRlY29kZWQgc2V0IG9mIGF0dHJpYnV0ZXMgdGhhdCB3ZXJlIGVuY29kZWQgdmlhIFBIUFxuICAgICAqIGluIG91ciB0ZW1wbGF0ZS5cbiAgICAgKiBcbiAgICAgKiBAcGFyYW0gIHtvYmplY3R9IHRhcmdldCBUaGUgcGxheUJ1dHRvbidzIHRhcmdldFxuICAgICAqIEByZXR1cm4ge29iamVjdH0gICAgICAgIFRoZSBuZXcgaWZyYW1lXG4gICAgICovXG4gICAgZnVuY3Rpb24gZ2VuZXJhdGVJZnJhbWUoIHRhcmdldCApIHtcbiAgICAgICAgbGV0IHRhcmdldE9iaiAgPSB0YXJnZXQuZ2V0QXR0cmlidXRlKFwiZGF0YS1vcGVuXCIpO1xuICAgICAgICBsZXQgYXR0cnMgPSBkZWNvZGVVUklDb21wb25lbnQoZXNjYXBlKHdpbmRvdy5hdG9iKG1lZGlhQXR0cnMpKSk7XG5cbiAgICAgICAgLy8gQXBwZW5kIHRoZSBpZnJhbWUgYXR0cmlidXRlcyB0byBhbiBpZnJhbWUgaW4gdGhlIGAjdmlkZW9Cb3hgXG4gICAgICAgIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoXCIjXCIgKyB0YXJnZXRPYmopLnN0eWxlLmNzc1RleHQgKz1cIjtcIisgXCJvcGFjaXR5OjE7XCI7XG5cbiAgICAgICAgbGV0IGlmcmFtZVRlbXBsYXRlID0gYFxuICAgICAgICAgICAgPGlmcmFtZSAke2F0dHJzfT48L2lmcmFtZT5cbiAgICAgICAgYDtcblxuICAgICAgICBpZiAoZG9jdW1lbnQucXVlcnlTZWxlY3RvcihcIiN2aWRlb0JveFwiKSkge1xuICAgICAgICAgICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvcihcIiN2aWRlb0JveFwiKS5pbm5lckhUTUwgPSBpZnJhbWVUZW1wbGF0ZTtcbiAgICAgICAgfVxuICAgIH1cblxuICAgIC8vIEFkZCB0aGUgZXZlbnQgbGlzdGVuZXIgdGhhdCB3aWxsIGdlbmVyYXRlIHRoZSBpZnJhbWUuXG4gICAgZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcihcImNsaWNrXCIsIGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgaWYgKCBlLnRhcmdldC5oYXNBdHRyaWJ1dGUoXCJkYXRhLW9wZW5cIikgKSB7XG4gICAgICAgICAgICBnZW5lcmF0ZUlmcmFtZShlLnRhcmdldCk7XG4gICAgICAgIH1cbiAgICB9KTtcblxufSApKCk7XG5cbiggZnVuY3Rpb24gKCkge1xuICAgIGNvbnN0IExBWlkgPSBuZXcgTGF6eUltYWdlcztcbiAgICBjb25zdCBsb2FkTGF6aWx5ID0gXyA9PiB7IExBWlkubGF6eUxvYWQoKTsgfTtcblxuICAgIHdpbmRvdy5hZGRFdmVudExpc3RlbmVyKCdsb2FkJywgbG9hZExhemlseSwgZmFsc2UpO1xuICAgIHdpbmRvdy5hZGRFdmVudExpc3RlbmVyKCdyZXNpemUnLCBsb2FkTGF6aWx5LCBmYWxzZSk7XG4gICAgd2luZG93LmFkZEV2ZW50TGlzdGVuZXIoJ3Njcm9sbCcsIGxvYWRMYXppbHksIGZhbHNlKTtcblxuICAgIC8vIHdpbmRvdy5yZW1vdmVFdmVudExpc3RlbmVyKCdsb2FkJywgbG9hZExhemlseSwgZmFsc2UpO1xuICAgIC8vIHdpbmRvdy5yZW1vdmVFdmVudExpc3RlbmVyKCdyZXNpemUnLCBsb2FkTGF6aWx5LCBmYWxzZSk7XG4gICAgLy8gd2luZG93LnJlbW92ZUV2ZW50TGlzdGVuZXIoJ3Njcm9sbCcsIGxvYWRMYXppbHksIGZhbHNlKTtcbn0pKCk7XG5cbiJdLCJuYW1lcyI6WyJsZXQiLCJ0aGlzIiwiY29uc3QiXSwibWFwcGluZ3MiOiI7OztBQUFBOztBQUVBLElBQXFCLFVBQVUsR0FBQyxtQkFFakIsR0FBRztJQUNkLElBQVEsQ0FBQyxJQUFJLEdBQUcsUUFBUSxDQUFDLGdCQUFnQixDQUFDLE9BQU8sQ0FBQyxDQUFDO0NBQ2xELENBQUE7O0FBRUwscUJBQUksUUFBUSx3QkFBRzs7O0lBQ1gsSUFBUSxNQUFNLEdBQUcsSUFBSSxDQUFDLElBQUksQ0FBQzs7SUFFM0IsS0FBU0EsSUFBSSxDQUFDLEdBQUcsQ0FBQyxFQUFFLENBQUMsR0FBRyxNQUFNLENBQUMsTUFBTSxFQUFFLENBQUMsRUFBRSxDQUFDO1FBQ3ZDLEdBQU9DLE1BQUksQ0FBQyxZQUFZLENBQUMsTUFBTSxDQUFDLENBQUMsQ0FBQyxDQUFDLENBQUM7WUFDaEMsSUFBUSxNQUFNLENBQUMsQ0FBQyxDQUFDLENBQUMsWUFBWSxDQUFDLFVBQVUsQ0FBQyxD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
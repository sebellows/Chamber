// ------------- lazy-image-loading.js ------------- //

export default class LazyImages {

    constructor() {
        this.lazy = document.querySelectorAll('.lazy');
    }

    lazyLoad() {
        let images = this.lazy;

        for (let i = 0; i < images.length; i++){
            if(this.isInViewport(images[i])){
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
    }

    cleanLazy() {
        Array.prototype.filter.call(this.lazy, function(l) { 
            return l.getAttribute('data-src');
        });
    }

    isInViewport(lazy) {
        let rect = lazy.getBoundingClientRect();
        
        return (
            rect.bottom >= 0 && 
            rect.right  >= 0 && 
            rect.top    <= (window.innerHeight || document.documentElement.clientHeight) && 
            rect.left   <= (window.innerWidth || document.documentElement.clientWidth)
         );
    }

    onChange(...args) {
        return args;
    }

}
// ------------- lazy-image-loading.js ------------- //

export default class LazyImages {

    constructor() {
        this.lazy = document.querySelectorAll('.lazy');
        this.lazyLoad(this.lazy);
        // console.log('Found ' + this.lazy.length + ' lazy images');
    }

    lazyLoad(lazy) {
        for (let i = 0; i < lazy.length; i++){
            if(this.isInViewport(lazy[i])){
                if (lazy[i].getAttribute('data-src')){
                    lazy[i].src = lazy[i].getAttribute('data-src');
                    lazy[i].removeAttribute('data-src');
                }
                if (lazy[i].getAttribute('data-srcset')){
                    lazy[i].srcset = lazy[i].getAttribute('data-srcset');
                    lazy[i].removeAttribute('data-srcset');
                }
                lazy[i].classList.add("is-loaded");
            }
        }

        this.cleanLazy(lazy);
    }

    cleanLazy(lazy) {
        Array.prototype.filter.call(lazy, function(l) { 
            return l.getAttribute('data-src');
            console.log('penis');
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
}

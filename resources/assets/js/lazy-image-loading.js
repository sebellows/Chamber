
export let LAZY = [];

export function setLazy(){
    LAZY = document.querySelectorAll('.lazy');
    console.log('Found ' + LAZY.length + ' lazy images');
}

export function lazyLoad(){
    for (let i = 0; i < LAZY.length; i++){
        if(isInViewport(LAZY[i])){
            if (LAZY[i].getAttribute('data-src')){
                LAZY[i].src = LAZY[i].getAttribute('data-src');
                LAZY[i].removeAttribute('data-src');
            }
            if (LAZY[i].getAttribute('data-srcset')){
                LAZY[i].srcset = LAZY[i].getAttribute('data-srcset');
                LAZY[i].removeAttribute('data-srcset');
            }
        }
    }
    
    cleanLazy();
}

export function cleanLazy(){
    LAZY = Array.prototype.filter.call(LAZY, function(l) { 
        return l.getAttribute('data-src');
    });
}

export function isInViewport(el){
    var rect = el.getBoundingClientRect();
    
    return (
        rect.bottom >= 0 && 
        rect.right  >= 0 && 
        rect.top    <= (window.innerHeight || document.documentElement.clientHeight) && 
        rect.left   <= (window.innerWidth || document.documentElement.clientWidth)
     );
}

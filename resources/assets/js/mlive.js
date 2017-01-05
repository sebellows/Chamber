!function () {
    function t() {
        var t = r("utm_content");
        if (t) {
            var e = new Date;
            e.setDate(e.getDate() + 30), document.cookie = t + ";expires=" + e.toGMTString() + ";path=/";
        } else {
            if (document.cookie) {
                for (var o = document.cookie.split(/; */), n = 0; n < o.length; n++) {
                    if (0 === o[n].toLowerCase().trim().indexOf("utm_content=")) {
                        t = o[n];
                        break;
                    }
                }
            }
        }
        return t;
    }

    function e(t) {
        try {
            console.log(t);
        } catch (e) {
            alert(t);
        }
    }

    function r(t) {
        var e = top.location.search ? top.location.search.substring(1) : null;
        if (e) {
            for (var r = e.split("&"), o = 0; o < r.length; o++) {
                if (0 === r[o].toLowerCase().trim().indexOf(t + "=")) {
                    return r[o];
                }
            }
        }
        return null;
    }

    var o = "", n = r("mctest");
    if (n) {
        e("dnr tag version: 20160125"), o = "http://localhost:8080/rip/library/dnr/mcDnrTag.debug.js";
    } else {
        var a = t(), c = "";
        a && (c = top.location.search ? 0 <= top.location.search.indexOf("utm_content") ? top.location.search : top.location.search + "&" + a : "?" + a, o = "https://script.advertiserreports.com/redirector/dnr" + c);
    }
    if (o) {
        var i = document.createElement("script");
        i.src = o, i.type = "text/javascript", scriptTag = document.getElementsByTagName("script")[0], scriptTag.parentNode.appendChild(i);

    }
}();
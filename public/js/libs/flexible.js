(function (e, t) {
    var n = e.documentElement, i = "orientationchange" in window ? "orientationchange" : "resize", d = function() {
        var e = n.clientWidth;
        if (e) {
            var t = 20 * (e / 375);
            t = t > 27 ? 27 : t, n.style.fontSize = t + "px";
            {
                var i = window.devicePixelRatio;
                document.querySelector('meta[name="viewport"]');
            }
            n.setAttribute("data-dpr", i);
        }
    };
    e.addEventListener && (t.addEventListener(i, d, !1), e.addEventListener("DOMContentLoaded", d, !1));
})(document, window);
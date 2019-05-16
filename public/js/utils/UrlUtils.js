

define([""], function () {
    return {
        // 获取URL参数值
        getQueryString: function (paramName) {
            var self = this;
            return self.getQueryStringFromURL(window.location.href, paramName);
        },

        // 从给定的URL中获取参数值
        getQueryStringFromURL: function (url, paramName) {
            var search = url.substr(url.indexOf("?"));
            var reg = new RegExp("(^|&)" + paramName + "=([^&]*)(&|$)", "i"),
                r = search.substr(1).match(reg);
            if (r != null) {
                return (r[2]);
            }
            return null;
        }
    };
});
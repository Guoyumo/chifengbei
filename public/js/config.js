(function() {
  require.config({
    baseUrl: "js",
    paths: {
      zepto: "libs/zepto.min",
      underscore: "libs/underscore-1.8.3.min",
      weui: "libs/weui.min",
      wx: "libs/jweixin-1.0.0.min",
      moment: "libs/moment.min",
      Swiper: "libs/swiper.min"
    },
    urlArgs: "v=1557392014942", // +  (new Date()).getTime(),
    shim: {
      "zepto": {
        exports: "$"
      },
      "underscore": {
        exports: "_"
      },
      "weui": {
        exports: "weui"
      },
      "wx": {
        exports: "wx"
      },
      "moment": {
        exports: "moment"
      },
      "Swiper": {
        deps: ["zepto"],
        exports: "Swiper"
      }
    }
  });
  require(["zepto", "underscore", "utils/stringUtils", "utils/urlUtils"], function($, _, stringUtils, urlUtils) {
    var ctrlStr = $("script[data-controller]").attr("data-controller");
    var ctrl = ctrlStr.split(',');
    if (ctrl.length > 0) {
      require(ctrl);
    }
  });
})();
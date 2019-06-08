require(["zepto", "underscore", "wx",
  "utils/UrlUtils",
    "text!detail/view/detailTpl.html",
    'detail/model/data',
    'Swiper'
  ],
  function($, _, wx, UrlUtils, detailTpl,data,Swiper) {
    var detailList = {
      el: {
        $detailItem: $(".detailItem")
      },
      details:null,
      addEventListener:function(){
        $(".choose").on('click', function() {
          $(this).siblings().removeClass("detail-choose");
          $(this).toggleClass("detail-choose");
        })
        $("#detail-buy").on('click', function() {
          location.href = "address.html"
        })
        //计数器
        var MAX = 99,
          MIN = 1;
        $(".weui-count__decrease").click(function(e) {
          var $input = $(e.currentTarget).parent().find('.weui-count__number');
          var number = parseInt($input.val() || "0") - 1
          if (number < MIN) number = MIN;
          $input.val(number)
        })
        $(".weui-count__increase").click(function(e) {
          var $input = $(e.currentTarget).parent().find('.weui-count__number');
          var number = parseInt($input.val() || "0") + 1
          if (number > MAX) number = MAX;
          $input.val(number)
        })
        //swiper
        var swiper = new Swiper('.swiper-container', {
          pagination: {
            el: '.swiper-pagination',
            clickable: true,
          },
          autoplay: {
            delay: 1000,
          },
          speed: 200,
        });
      },
      render: function() {
        var self = this;
        self.el.$detailItem.append(_.template(detailTpl)({
          detailList: self.details
        }));
        self.addEventListener();
      },
      init: function() {
        var code = UrlUtils.getQueryString('code');
        this.details = data[code];
        this.render();
      }
    }

    // 执行函数
    $(function() {
      detailList.init();
    })
  })
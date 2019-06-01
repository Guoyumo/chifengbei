require(["zepto", "underscore", "wx",
    "utils/UrlUtils",
    "text!shop/view/shopTpl.html",
    "shop/model/data"
  ],
  function($, _, wx, UrlUtils, shopTpl,data) {
    var shop = {
      el: {
        $shoplist: $(".shoplist"),
        $viewDetial: $('.j_view_detail')
      },
      data:{
        code:null,
        shopList:data
      },
      addEventListener:function(){
        var self = this;
        $('.j_view_detail').click(function(){
          var code = $(this).attr('data-value');
          location.href="detail?code=" + code;
        });
      },
      render: function() {
        var self = this;
        self.el.$shoplist.append(_.template(shopTpl)({
          shopList:self.data.shopList[self.data.code]
        }));
        self.addEventListener();
      },
      init: function() {
        var code = UrlUtils.getQueryString('code');
        this.data.code = code;
        this.render();
      }
    }

    // 执行函数
    $(function() {
      shop.init();
    });
  })
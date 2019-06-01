require(["zepto", "underscore", "wx",
    "utils/stringUtils",
    "text!store/view/storeItemTpl.html",
    "store/model/data",
    "Swiper"
  ],
  function($, _, wx, stringUtils, storeItemTpl,data,Swiper) {
    var storeList = {
      el: {
        $listCont: $(".listCont")
      },
      fakeData:data,
      addEventListener:function(){
        var swiper = new Swiper('.swiper-container', {
          pagination: {
            el: '.swiper-pagination',
            clickable: true,
          },
          autoplay: {
            delay: 2500,
          },
          speed: 200,
        });
      },
      render: function() {
        var self = this;
        self.el.$listCont.append(_.template(storeItemTpl)({
          storeList: self.fakeData
        }));
      },
      init: function() {
        this.render();
        this.addEventListener();
      }
    }

    // 执行函数
    $(function() {
      storeList.init();
      $(".store-item").on('click', function() {
       var code = $(this).attr('data-value');
        location.href = "shop?code=" + code;
      })
      
    });
  })
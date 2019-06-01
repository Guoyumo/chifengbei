require(["zepto", "underscore", "wx",
    "utils/stringUtils",
    "text!address/view/addressTpl.html"],
    function ($, _, wx,  stringUtils,addressTpl) {
      var address = {
        el:{
          $addressCont : $(".addressCont")
        },
        render:function(){
          var self = this;
          self.el.$addressCont.append(_.template(addressTpl)({
          }));
        },
        init:function(){
          this.render();
        }
      }

      // 执行函数
    $(function () {
      address.init();
  });
})
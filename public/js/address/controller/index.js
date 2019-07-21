require(["zepto", "underscore", "wx",
    "utils/stringUtils",
    "text!address/view/addressTpl.html","weui"],
    function ($, _, wx,  stringUtils,addressTpl,weui) {
      var address = {
        el:{
          $addressCont : $(".addressCont"),
          $submit: $('.j_submit')
        },
        addEventListener:function(){
          var self = this;
          $('.j_submit').click(function(){
            $.ajax({
              type: "POST",
              url: "/shopOrder",
              data: {},
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              timeout: 15000,
              beforeSend: function (xhr, settings) {
              },
              success:function (result) {
                console.log(result)
              },
              error: function (xhr, errorType, error) {
                  console.log(xhr);
              },
              complete: function (xhr, status) {
                  weui.loading().hide();
              }
            })
          });
        },
        render:function(){
          var self = this;
          self.el.$addressCont.append(_.template(addressTpl)({
          }));
          self.addEventListener();
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
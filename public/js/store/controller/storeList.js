require(["zepto", "underscore", "wx",
    "utils/stringUtils",
    "store/view/storeItemTpl"],
    function ($, _, wx,  stringUtils,storeItemTpl) {
      var storeList = {
        el:{
          $listCont : $(".listCont")
        },
        fakeData : [
          {title:'store 1'},
          {title:'store 2'},
          {title:'store 3'}
        ],
        render:function(){
          var self = this;
          self.el.$listCont.append(_.template(storeItemTpl)({
            storeList: self.fakeData
          }));
        },
        init:function(){
          this.render();
        }
      }

      // 执行函数
    $(function () {
      storeList.init();
  });
})
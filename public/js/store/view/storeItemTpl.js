

define([''], function () {
  return '<% _.each(storeList,function(item){ %>' + 
        '<div><%= item.title %></div> ' +
        '<% }) %>' 
});

define([''], function () {
    return {
        // 判断字符串非空
        isNotEmpty: function(str) {
            return str !== "" && str !== null && str !== undefined;
        },

        // 判断字符串为空
        isEmpty: function(str) {
            return str === "" || str === null || str === undefined;
        }
    }
});

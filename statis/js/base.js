/**
 * @description JS基础库<依赖jQuery>
 *
 * @author Jason <shuaijinchao@gmail.com>
 *
 * @create 2015-11-29 16:21
 */

var IMOOC = IMOOC || {};
IMOOC.GLOBAL = {};
IMOOC.APPS = {};

IMOOC.APPS.QUERYPHONE = {};
IMOOC.APPS.QUERYPHONE.showInfo = function(){
    $('#phoneInfo').show();
};
IMOOC.APPS.QUERYPHONE.hideInfo = function(){
    $('#phoneInfo').hide();
};
IMOOC.APPS.QUERYPHONE.dataCallback = function(data) {
    if (data.code == 200) {
        IMOOC.APPS.QUERYPHONE.showInfo();
        $('#phoneNumber').text(data.phone);
        $('#phoneProvince').text(data.province);
        $('#phoneCatName').text(data.catName);
        $('#phoneMsg').text(data.msg);
    } else {
        IMOOC.APPS.QUERYPHONE.hideInfo();
        alert(data.msg);
    }
};

IMOOC.GLOBAL.ajax = function(url, method, params, dataType, callback){
    $.ajax({
        url: url,
        type: method,
        data: params,
        dataType: dataType,
        success: callback,
        error:function(){
            alert('请求异常');
        }
    });
};
/**
 * Created with JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-2-25
 * Time: 下午4:57
 * To change this template use File | Settings | File Templates.
 */

$(document).ready(function(){
    //other things to do on document ready, seperated for ajax calls
    docReadyBlogInit();
});

function docReadyBlogInit(){
    //I18N 设置
    $.fn.datetimepicker.dates['zh-CN'] = {
        days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"],
        daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六", "周日"],
        daysMin:  ["日", "一", "二", "三", "四", "五", "六", "日"],
//        months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        months: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
        monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        today: "今日",
        suffix: [],
        meridiem: [],
        rtl : true//显示时间 月年按照从右到左的形式。也就是正常的年月
    };
    $(".form_datetime").datetimepicker({
        format: "yyyy-mm-dd hh:ii:ss",
        language : "zh-CN",
        autoclose: true,
        todayBtn: true,
        minuteStep: 10,
        pickerPosition: "bottom-left"
    });

    $('.accordion-inner').tooltip({
        placement : "right",
        selector: "a[rel=tooltip]"
    })

    $('#new-password').passwordStrength({
        targetDiv: "#password-strength"
    });

    //算术验证
    $("#code-img").click(function(){
        $(this).attr("src",'http://localhost/loveqiao/admin/vc?t=' + Math.random());
    });
    $("#code-change").click(function(){
        $("#code-img").attr("src",'http://localhost/loveqiao/admin/vc?t=' + Math.random());
    });

    $("#change-password-submit").click(function(){
        var code_num = $("#code-num").val();
        $.ajax({
            url: "http://localhost/loveqiao/admin/changepwd",
            data: {
                act : "math",
                code : code_num
            },
            type : "POST",
            dataType: "json",
            success: function(data){
                switch(data["HEAD"]){
                    case "success":
                        alert("验证码正确！");
                        break;
                    case "error":
                        alert("验证码错误！");
                        break;
                    default:
                        break;
                }
            },
            error: function(data){
                alert("请求失败，请重试");
            }
        });
        return false;
    });

}

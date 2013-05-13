/**
 * Created with JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-3-27
 * Time: 下午4:18
 * To change this template use File | Settings | File Templates.
 */


$(document).ready(function(){
    //other things to do on document ready, seperated for ajax calls
    docReadyLoginInit();
});

function docReadyLoginInit(){
    //算术验证
    $("#captcha-img-login").click(function(){
        $(this).attr("src",'http://localhost/loveqiao/login/captcha?t=' + Math.random());
    });

    $("#code-change").click(function(){
        $("#captcha-img-login").attr("src",'http://localhost/loveqiao/login/captcha?t=' + Math.random());
    });

    //这里需要在浮层创建之后在绑定事件，否则，可能出现无法找到下面元素的异常
    $('#login-button-submit').click(function(){
        if($("#username-input-login").val() == "") {
            $("#login-state-tips").removeClass().addClass("alert alert-error lq-login-state-tips")
                .html('<strong>提示！</strong>请输入您的<strong>账号</strong>后再登录')
                .show().fadeOut(4000);

            return false;
        }
        if($("#password-input-login").val() == ""){
            $("#login-state-tips").removeClass().addClass("alert alert-error lq-login-state-tips")
                .html('<strong>提示！</strong>请输入您的<strong>密码</strong>后再登录')
                .show().fadeOut(4000);
            return false;
        }

        $.ajax({
            url: "http://localhost/loveqiao/login/signin",
            data: {
                "username" : $('#username-input-login').val(),
                "password" : $('#password-input-login').val(),
                "code"     : $("#captcha-input-login").val()
            },
            type : "POST",
            dataType: "json",
            success: function(data){
                switch(data["HEAD"]){
                    case "success":
                        location.replace("http://localhost/loveqiao/admin/");
                        break;
                    case "error":
                        $("#login-state-tips").removeClass().addClass("alert alert-error lq-login-state-tips")
                            .html('<strong>提示！' + data["BODY"])
                            .show().fadeOut(4000);
                        $("#captcha-img-login").attr("src",'http://localhost/loveqiao/login/captcha?t=' + Math.random());
                        break;
                    default:
                        break;
                }
            },
            error: function(data){
                alert("请求失败，请重试:" + data);
            }

        });
        return false;
        //this.submit();
    });
}



/**
 * Created with JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-3-27
 * Time: 下午4:18
 * To change this template use File | Settings | File Templates.
 */


$(document).ready(function(){
    //other things to do on document ready, seperated for ajax calls
    docReadyFeedbackInit();
});

function docReadyFeedbackInit(){
    //算术验证
    $("#captcha-img-feedback").click(function(){
        $(this).attr("src",'http://localhost/loveqiao/feedback/captcha?t=' + Math.random());
    });

    $("#code-change").click(function(){
        $("#captcha-img-feedback").attr("src",'http://localhost/loveqiao/feedback/captcha?t=' + Math.random());
    });

    //这里需要在浮层创建之后在绑定事件，否则，可能出现无法找到下面元素的异常
    $('#feedback-button-submit').click(function(){
        if($('#feedback').val() == ""){
            $("#feedback-state-tips").removeClass().addClass("alert alert-error lq-login-state-tips")
                .html('<strong>温馨提示！</strong>请您写上<strong>反馈内容</strong>后再提交吧^_^')
                .show().fadeOut(4000);
            return false;
        }

        $.ajax({
            url: "http://localhost/loveqiao/feedback/submit",
            data: {
                username : $('#username').val(),
                email : $('#email').val(),
                feedback : $('#feedback').val(),
                code     : $("#captcha-input-feedback").val()
            },
            type : "POST",
            dataType: "json",
            success: function(data){
                switch(data["HEAD"]){
                    case "success":
                        $("#sign-in-model").html("<div class='alert alert-success' style='margin-top:20px;text-align: center'>反馈已经提交，感谢您的参与</div>");
                        break;
                    case "error":
                        $("#feedback-state-tips").removeClass().addClass("alert alert-error lq-login-state-tips")
                            .html('<strong>提示！' + data["BODY"])
                            .show().fadeOut(4000);
                        $("#captcha-img-feedback").attr("src",'http://localhost/loveqiao/login/captcha?t=' + Math.random());
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



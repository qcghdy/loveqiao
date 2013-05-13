/**
 * Created with JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-2-22
 * Time: 下午5:12
 * To change this template use File | Settings | File Templates.
 */

$(document).ready(function(){
    docReadyCommonInit();
});

function docReadyCommonInit(){
    //登录功能。
    $('#sign-in').click(function(){
        $('#sign-in-model').modal({
            backdrop:true,
            keyboard:true,
            show:true
        });
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
            url: "http://localhost/loveqiao/util/login",
            data: {
                "username" : $('#username-input-login').val(),
                "password" : $('#password-input-login').val()
            },
            type : "POST",
            dataType: "json",
            success: function(data){
                switch(data["HEAD"]){
                    case "success":
                        $('#sign-in-model').modal('hide');
                        var content = data["BODY"];
                        $("#user-top-bar").html(
                            '<li class="dropdown">' +
                                '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i>'+ content["username"] +'<b class="caret"></b></a>'+
                                '<ul class="dropdown-menu">'+
                                    '<li><a href="http://localhost/loveqiao/admin"><i class="icon-shopping-cart"></i>个人中心</a></li>'+
                                    '<li><a href="http://localhost/loveqiao/util/logout/"><i class="icon-shopping-cart"></i>退出</a></li>'+
                                '</ul>' +
                            '</li>'
                        );
                        break;
                    case "error":
                        alert("该用户不存在，请先注册。");
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
        //this.submit();
    });

}



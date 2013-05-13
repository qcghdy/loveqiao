/**
 * Created with JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-3-28
 * Time: 上午11:41
 * To change this template use File | Settings | File Templates.
 */

$(document).ready(function(){
    //other things to do on document ready, seperated for ajax calls
    docReadyAdminFeedbackInit();
});

function docReadyAdminFeedbackInit(){

    var feedbacks = $("input[name='feedback']");

    $("#chooseAll").click(function(e){
        feedbacks.each(function(index){
            this.checked = true;
        });
    });

    $("#reverseChoose").click(function(e){
        feedbacks.each(function(index){
            this.checked = !this.checked;
        });
    });

    $("#setFlagRead").click(function(e){
        //获取管理员批量选择的反馈
        var feedbackId = new Array();
        feedbacks.each(function(index){
            if(this.checked){
                feedbackId.push(this.value);
            }
        });
        //判断用户是否有输入
        if(feedbackId.length == 0){
            $('#tips-model-alert').html("请选择要标记已读的反馈信息");
            $('#tips-confirm-model').modal({
                backdrop:true,
                keyboard:true,
                show:true
            });
        }else{
            //先将要请求的id复制到隐藏的input中
            $("#request").attr("value", feedbackId.join("+"));
            //设置请求
            $("#feedbackForm").attr("action", "http://localhost/loveqiao/admin/setFeedbackRead/").attr("method", "GET").submit();
        }
    });

    $("#delete").click(function(e){
        //获取管理员批量选择的反馈
        var feedbackId = new Array();
        feedbacks.each(function(index){
            if(this.checked){
                feedbackId.push(this.value);
            }
        });
        //判断用户是否有输入
        if(feedbackId.length == 0){
            $('#tips-model-alert').html("请选择要删除的反馈信息");
            $('#tips-confirm-model').modal({
                backdrop:true,
                keyboard:true,
                show:true
            });
            return false;
        }else{
            //先将要请求的id复制到隐藏的input中
            $("#request").attr("value", feedbackId.join("+"));
            //设置请求
            $("#feedbackForm").attr("action", "http://localhost/loveqiao/admin/deleteFeedback/").attr("method", "GET").submit();
        }
    });

    $("a[rel=popover]").popover();


}
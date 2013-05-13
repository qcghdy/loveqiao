/**
 * Created with JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-3-5
 * Time: 下午3:05
 * To change this template use File | Settings | File Templates.
 */

$(document).ready(function(){
    //other things to do on document ready, seperated for ajax calls
    docReadyBlogInit();
});

function docReadyBlogInit(){

    $.scrolltotop({
        className: 'totop',
        controlHTML : "<a id='top' title='回到顶部' style='height:35px; width:40px;' href='javascript:void(0);'>回到顶部</a>",
        offsety:50,
        offsetx:50
    });

    $('.editor-widget').tooltip({
        placement : "right",
        selector: "a[rel=tooltip]"
    })

    var editor = new UE.ui.Editor();
    editor.render("myEditor");
    editor.ready(function(){
        //editor.setContent("既然来了，就写点什么吧。欢迎使用UEditor！");
    });

    $("#publish").click(function(){
        //检测碎碎题
        if(jQuery.trim($("#suisui-title").val()) == ''){
            $('#errorDialog').modal({
                backdrop:true,
                keyboard:true,
                show:true
            });
            return false;
        }
        //检测碎碎念
        if(editor.hasContents()){ //此处以非空为例
            //前端页面，设置按钮不可被点击
            that = this;
            $(that).attr('disabled', 'disabled');
            editor.sync();       //同步内容
            var postEditor = {
                title     : encodeURIComponent(jQuery.trim($("#suisui-title").val()))
                ,type     : encodeURIComponent($('#suisui-type')[0].selectedIndex)
                ,myEditor : encodeURIComponent(editor.getContent())
                ,tags     : encodeURIComponent($("#suisui-tag").val())
                ,topic    : encodeURIComponent($("#suisui-topic").val())
                ,token    : $("#token").val()
                ,sid      : $("#sid").val()
            }
            $.ajax({
                url: "http://localhost/loveqiao/admin/updateBlog/",
                data: postEditor,
                type : "POST",
                dataType: "json",
                success: function(data){
                    switch(data["HEAD"]){
                        case "success":
                            $("#jumpDialog").modal('show');
                            var second = parseInt($("#second").html(), 10);
                            var start = 1;
                            setInterval(function(){
                                if(second == 0){
                                    location.replace("http://localhost/loveqiao/blog/item?sid=" + data["BODY"]);
                                }else{
                                    start += 20;
                                    $("#processBar").css("width", start + "%");
                                    --second >= 0 ? $("#second").html(second) : "";
                                }

                            }, 1000);
                            break;
                        case "error":
                            alert("请不要重复提交、恶意提交");
                            break;
                        default:
                            break;
                    }
                    $(that).removeAttr('disabled');
                },
                error: function(data){
                    alert("请求失败，请重试。" + data);
                }
            });
            return false;
            //someForm.submit();   //提交Form
        }else{
            $('#errorDialog').modal({
                backdrop:true,
                keyboard:true,
                show:true
            });
            return false;
        }
    });

    $('#tags-option').click(function(){
        $('#tags-option-model').modal({
            backdrop:true,
            keyboard:true,
            show:true
        });
    });

}

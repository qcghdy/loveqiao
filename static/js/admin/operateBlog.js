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
    $("#admin-blog-operation").click(function(e){
        var target = $(e.target)[0];
        if(target.getAttribute("option") == "delete"){
            $("#delete-confirm-model-alert").html("您确认要删除标题为<h5>“"+ target.getAttribute("stitle") + "”</h5>的这条碎碎念吗？");
            $('#delete-confirm-model').modal();
            $("#delete-confirm-button").click(function(){
                var that = this;
                $.ajax({
                    url: "http://localhost/loveqiao/admin/deleteBlog",
                    data: {
                        sid : target.getAttribute("sid")
                    },
                    type : "POST",
                    dataType: "json",
                    success: function(data){
                        switch(data["HEAD"]){
                            case "success":
                                $("#delete-confirm-model-alert").html("删除成功！");
                                //1秒钟后刷新页面
                                setTimeout(function(){
                                    document.location.reload();
                                }, 1000);
                                break;
                            case "error":
                                alert("删除失败，请重试！");
                                break;
                            default:
                                break;
                        }
                    },
                    error: function(data){
                        alert("请求失败，请重试");
                    }
                });
            });
        }

        if(target.getAttribute("option")=="edit"){

        }

    });

}

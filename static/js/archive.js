/**
 * Created with JetBrains PhpStorm.
 * User: denniszhu
 * Date: 13-3-12
 * Time: 下午4:15
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(function(){
    //other things to do on document ready, seperated for ajax calls
    docReadyBlogInit();
});
function docReadyBlogInit(){
//    $.scrolltotop({
//        className: 'totop',
//        controlHTML : "<a id='top' title='回到顶部' style='height:35px; width:40px;' href='javascript:void(0);'>回到顶部</a>",
//        offsety:50,
//        offsetx:50
//    });

    var headers = $(".archive-header-title").find("a"), posts = $(".archive-body");
    $.each(headers, function(index, header) { // 遍历所有文章标题元素
        bShare.addEntry({
            title:$(header).text(),           // 获取文章标题
            url:  $(header).attr("href"),	  // 获取文章链接
            summary:$(posts[index]).text()	  // 从postBody中获取文章摘要
        });
    });

    $("a[name='reply']").each(function(index, ele){
        var that = this;
        $(that).click(function(event){
            event.stopPropagation();
            $(this).parent().parent().hide().next().show();
        });
    });

//    $(document.body).click(function(event){
//        $("div[class='archive-reply']").each(function(index, replyBox){
//            $(replyBox).hide().prev().show();
//        });
//    });


//    $(document.body).each(function(index, replyBox){
//        $(replyBox).blur(function(event){
//
//            //event.stopPropagation();
//            $(this).hide().prev().show();
////            var target = event.currentTarget;
////            if("" == jQuery.trim($(this).text())){
////                $(this).parent().parent().parent().parent().parent().parent().hide().prev().show();
////            }
//        });
////        var that = this;
////        $(that).click(function(event){
////            event.stopPropagation();
////            $(this).parent().parent().hide().next().show();
////        });
//    });
    $("#testBtn").click(function(){
        var fields = $("select, :radio, :checkbox, :text").serializeArray();
        console.log(fields);
        jQuery.each( fields, function(i, field){
            $("#results").append(field.value + " ");
        });
    });
}
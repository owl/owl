$(function(){
var list = "";
var currentlevel = 0;
//見出しを検索
$(".page-body h1, .page-body h2,.page-body h3").each(function(i){
    var idName = "section" + i;
    $(this).attr("id",idName);
    var level = 0;
    if (this.nodeName.toLowerCase() == "h1") {
        level = 1;
    } else if (this.nodeName.toLowerCase() == "h2") {
        level = 2;
    } else if (this.nodeName.toLowerCase() == "h3") {
        level = 3;
    }
    while (currentlevel < level) {
        list += '<ol class="chapter">';
        currentlevel++;
    }
    while (currentlevel > level) {
        list += "</ol>";
        currentlevel--;
    }
    list += '<li><a href="#' + idName + '">' + $(this).text() + '</a></li>';
});
//見出しが2つ以上あったら目次を表示する
if ($(".page-body h1, .page-body h2, .page-body h3").length >= 2){
    $("<div class='sidebar-info sectionList'><h5>目次</h5>" + list + "</div><hr>").prependTo("#sidebar");
}
//スクロールを滑らかにする
$('.sectionList a').on("click", function() {
    $('html,body').animate({scrollTop: $(this.hash).offset().top}, 600);
    return false;
});
});

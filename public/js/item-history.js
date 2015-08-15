$(function() {
    $("h2").click(function(){
        $(this).next(".diff-area").toggleClass("show");
        $(this).next(".diff-area").toggleClass("hidden");
        $("span", this).toggleClass("glyphicon-chevron-up");
        $("span", this).toggleClass("glyphicon-chevron-down");
    });
});

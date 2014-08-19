$(function() {
    $(document).on('click', '#like_id', function() {

        var open_id = $("#open_id").val();

        $.ajax({
            type:"POST",
            url:"/likes",
            data:{"open_item_id": open_id},

            success: function(msg){
            }
        });

        $('#like_id').html("<span class=\"glyphicon glyphicon-thumbs-up\"></span> いいね！を取り消す");
        $('#like_id').removeClass('btn-primary');
        $('#like_id').addClass('btn-default');
        $('#like_id').attr('id', 'dislike_id');
    });
    $(document).on('click', '#dislike_id', function() {
        var open_id = $("#open_id").val();
        $.ajax({
            type:"POST",
            url:"/likes/" + open_id,
            data:{"_method": "delete"},

            success: function(msg){
            }
        });

        $('#dislike_id').html("<span class=\"glyphicon glyphicon-thumbs-up\"></span> いいね！");
        $('#dislike_id').removeClass('btn-default');
        $('#dislike_id').addClass('btn-primary');
        $('#dislike_id').attr('id', 'like_id');
    });
});

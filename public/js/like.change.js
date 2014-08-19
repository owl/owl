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
        $('#like_id').attr('id', 'unlike_id');
    });
    $(document).on('click', '#unlike_id', function() {
        var open_id = $("#open_id").val();
        $.ajax({
            type:"POST",
            url:"/likes/" + open_id,
            data:{"_method": "delete"},

            success: function(msg){
            }
        });

        $('#unlike_id').html("<span class=\"glyphicon glyphicon-thumbs-up\"></span> いいね！");
        $('#unlike_id').removeClass('btn-default');
        $('#unlike_id').addClass('btn-primary');
        $('#unlike_id').attr('id', 'like_id');
    });
});

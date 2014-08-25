$(function() {
    $(document).on('submit', '#comment', function() {
        $.ajax({
            type:"POST",
            url:"/comment/create",
            data:{"open_item_id": this.open_item_id.value, "user_id": this.user_id.value, "body": this.body.value},

            success: function(msg){
                $('#comment_container').append(msg);
                $('#comment_text').val("");
            }
        });

    });
});

$(function() {
    $(document).on('submit', '#comment-form', function() {
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
    $(document).on('click', '.comment-delete', function() {
        var obj = $(this).closest('div.comment'); 
        $.ajax({
            type:"POST",
            url:"/comment/destroy",
            data:{"id": $(this).prev('.comment-delete').val()},

            success: function(msg){
                obj.hide();
            }
        });
    });
    $(document).on('click', '.start-edit', function() {
        alert('hoge');
    });
    $(document).on('click', '.comment-edit', function() {
        var obj = $(this).closest('div.comment'); 
        $.ajax({
            type:"POST",
            url:"/comment/destroy",
            data:{"id": $(this).prev('.comment-delete').val()},

            success: function(msg){
                obj.hide();
            }
        });
    });
});

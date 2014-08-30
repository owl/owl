$(function() {
    $(document).on('submit', '#comment-form', function() {
        $.ajax({
            type:"POST",
            url:"/comment/create",
            data:{"open_item_id": this.open_item_id.value, "body": this.body.value},

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
            data:{"id": obj.find('.comment-id').val()},

            success: function(msg){

                obj.hide();
            }
        });
    });
    $(document).on('click', '.start-edit', function() {
        var obj = $(this).closest('div.comment'); 
        obj.find('.right').hide();
        obj.find('.arrow_box').hide();
        obj.find('.comment-edit').show();
        obj.find('.title-username').hide();
        obj.find('.title-onedit').show();
    });
    $(document).on('click', '.edit-cancel', function() {
        var obj = $(this).closest('div.comment'); 
        obj.find('.comment-edit').hide();
        obj.find('.right').show();
        obj.find('.arrow_box').show();
        obj.find('.comment-edit-body').val(obj.find('.orig_comment').val());
        obj.find('.title-username').show();
        obj.find('.title-onedit').hide();
    });
    $(document).on('submit', '.edit-confirm', function() {
        var obj = $(this).closest('div.comment'); 
        $.ajax({
            type:"POST",
            url:"/comment/update",
            data:{"id": obj.find('.comment-id').val(), "body" : obj.find('.comment-edit-body').val()},
            success: function(msg){
                obj.html(msg);
            }
        });
    });
});

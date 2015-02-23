$(function() {
    $(document).on('click', '#stock_id', function() {
        var open_id = $("#open_id").val();

        $.ajax({
            type:"POST",
            url:"/stocks",
            data:{"open_item_id": open_id},

            success: function(msg){
            }
        });

        $('#stock_id').text('ストックを解除する');
        $('#stock_id').removeClass('btn-success');
        $('#stock_id').addClass('btn-default');
        $('#stock_id').attr('id', 'unstock_id');
    });
    $(document).on('click', '#unstock_id', function() {
        var open_id = $("#open_id").val();
        $.ajax({
            type:"POST",
            url:"/stocks/" + open_id,
            data:{"_method": "delete"},

            success: function(msg){
            }
        });

        $('#unstock_id').text('この記事をストックする');
        $('#unstock_id').removeClass('btn-default');
        $('#unstock_id').addClass('btn-success');
        $('#unstock_id').attr('id', 'stock_id');
    });
});


$(function() {
    $('#item_text').blur();
    $('#file_id').change(function() {
        $(this).upload('/image/upload', function(res) {
            $('#item_text').append(res);
        }, 'text');
    });
});

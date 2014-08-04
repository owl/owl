
$(function() {
    $('#file_id').change(function() {
        $(this).upload('/image/upload', function(res) {
            var text = $('#item_text').val();
            $('#item_text').val(text + "\n" + res);
        }, 'text');
    });
});

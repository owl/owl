
$(function() {
    $('#file_id').change(function() {
        var file = document.getElementById('file_id').files[0];

        if (file.size > 2 * 1000 * 1000) {
          alert("アップロードできるファイルサイズを超えています(2MBまで)。");
          return;
        }

        $(this).upload('/image/upload', function(res) {
            var text = $('#item_text').val();
            $('#item_text').val(text + "\n" + res);
        }, 'text');
    });
});

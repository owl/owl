/**
 * Create POST request to parse markdown
 */
$(function() {
  /* variable */
  var editFlag = false;
  var $loding  = $('#cssload-loader');

  /* functions */

  // 受け取った内容でpreview内を書き換え
  var makePreview = function(body) {
    $('.preview-body').html(body);
  };

  // 編集中のデータを取得
  var getMarkdown = function() {
    return $('textarea').val();
  };

  /* Event listener */
  $('.preview').click(function() {
    $.ajax({
      type: 'POST',
      url: '/items/parse',
      data: getMarkdown(),
      success: function(msg) {
        var res = $.parseJSON(msg);
        makePreview(res['html']);
      },
      error: function() {
        // TODO: エラーメッセージを表示
      }
    });
  });

  $(document)
    .ajaxStart(function() {
      $loding.show();
    })
    .ajaxStop(function() {
      $loding.hide();
    });
});

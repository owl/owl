/**
 * Create POST request to parse markdown
 */
$(function() {
  /* variable */
  var editFlag = false;
  var $loding  = $('#cssload-loader');
  var $preview = $('.preview-body');

  /* functions */

  // 受け取った内容でpreview内を書き換え
  var makePreview = function(body) {
    $preview.html(body);
  };

  // 編集中のデータを取得
  var getMarkdown = function() {
    return $('textarea').val();
  };

  // アクセス用トークン取得
  var getLaravelToken = function() {
    return $('input[name=_token]').val();
  }

  /* Event listener */
  $('.preview').click(function() {
    $.ajax({
      type: 'POST',
      url: '/items/parse',
      data: {
        'md'    : getMarkdown(),
        '_token': getLaravelToken()
      },
      success: function(msg) {
        makePreview(msg['html']);
      },
      error: function() {
        makePreview('Something error...');
      }
    });
  });

  $(document)
    .ajaxStart(function() {
      $preview.hide();
      $loding.show();
    })
    .ajaxStop(function() {
      $loding.hide();
      $preview.show();
    });
});

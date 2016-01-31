/**
 * edit.js
 *
 * Description:
 *   記事編集画面用JS
 */

$(function() {
  /**
   * @description 指定されたボタンをローディング中かつクリック不可にする
   * @param {mixed} selector
   * @return void
   */
  var buttonLoading = function(selector) {
    $(selector).button('loading');
  };

  /* Event listeners */
  $('form').submit(function() {
    buttonLoading('.edit-item-button');
  });
});

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
  $('.js-item-submit-btn,.js-comment-submit-btn').click(function() {
    buttonLoading(this);
  });
});

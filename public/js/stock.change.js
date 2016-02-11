$(function() {
  /**
   * @description ボタンをローディングかつクリック不可にする
   * @param {mixed} selector
   * @return void
   */
  var loadingButton = function(selector) {
    $(selector).text('通信中');
    $(selector).attr('disabled', 'disabled');
  };

  /**
   * @description ボタンのローディング表示を解除する
   * @param {mixed} selector
   * @return void
   */
  var resetButton = function(selector) {
    $(selector).removeAttr('disabled');
  };

  /**
   * @description open_idを取得
   * @return {string}
   */
  var getOpenId = function() {
    return $('#open_id').val();
  };

  /** お気に入りされた時 */
  $(document).on('click', '#stock_id', function() {
    loadingButton(this);

    var ajaxPromise = $.ajax({
      type    : "POST",
      url     : "/favorites",
      data    : {"open_item_id": getOpenId()},
      success : function(msg){
      }
    }).promise();

    ajaxPromise.then(function(result) {
      resetButton('#stock_id');
      $('#stock_id').text('お気に入りを解除する');
      $('#stock_id').removeClass('btn-success');
      $('#stock_id').addClass('btn-default');
      $('#stock_id').attr('id', 'unstock_id');
    }, function(error) {
    });
  });

  /** お気に入りが解除された時 */
  $(document).on('click', '#unstock_id', function() {
    var ajaxPromise = $.ajax({
      type    : "POST",
      url     : "/favorites/" + getOpenId(),
      data    : {"_method": "delete"},
      success : function(msg){
      }
    }).promise();

    ajaxPromise.then(function(result) {
      $('#unstock_id').text('この記事をお気に入りする');
      $('#unstock_id').removeClass('btn-default');
      $('#unstock_id').addClass('btn-success');
      $('#unstock_id').attr('id', 'stock_id');
    }, function(error) {
    });
  });
});

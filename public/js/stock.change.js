$(function() {
  /**
   * @description ボタンをローディングかつクリック不可にする
   * @param {mixed} selector
   * @return void
   */
  var loadingButton = function(selector) {
    $(selector).button('loading');
  };

  /**
   * @description ボタンのローディング表示を解除する
   * @param {mixed} selector
   * @return void
   */
  var resetButton = function(selector) {
    $(selector).button('reset');
  };

  $(document).on('click', '#stock_id', function() {
    loadingButton(this);

    var open_id = $("#open_id").val();

    var ajaxPromise = $.ajax({
      type    : "POST",
      url     : "/favorites",
      data    : {"open_item_id": open_id},
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

  $(document).on('click', '#unstock_id', function() {
    var open_id = $("#open_id").val();
    var ajaxPromise = $.ajax({
      type    : "POST",
      url     : "/favorites/" + open_id,
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

$(function() {
  /**
   * @description 指定されたボタンをローディング中かつクリック不可にする
   * @param {mixed} selector
   * @return void
   */
  var buttonLoading = function(selector) {
    $(selector).text('通信中');
    $(selector).attr('disabled', 'disabled');
  };

  /**
   * @description ボタンのローディングを解除する
   * @param {mixed} selector
   * @return void
   */
  var buttonReset = function(selector) {
    $(selector).removeAttr('disabled');
  };

  $(document).on('click', '#like_id', function() {
    // ボタンをローディング中にする
    buttonLoading(this);

    var open_id = $("#open_id").val();
    var like_count = $("#like_count").text();

    var ajaxPromise = $.ajax({
      type:"POST",
      url:"/likes",
      data:{"open_item_id": open_id},

      success: function(msg){
      }
    }).promise();

    ajaxPromise.then(function(result) {
      buttonReset('#like_id');
      $('#like_id').html("<span class=\"glyphicon glyphicon-thumbs-up\"></span> いいね！を取り消す");
      $('#like_id').removeClass('btn-primary');
      $('#like_id').addClass('btn-default');
      $('#like_id').attr('id', 'unlike_id');
      $('#like_count').html( parseInt(like_count) + 1);
    }, function(error) {
    });
  });

  $(document).on('click', '#unlike_id', function() {
    var open_id = $("#open_id").val();
    var like_count = $("#like_count").text();

    var ajaxPromise = $.ajax({
      type:"POST",
      url:"/likes/" + open_id,
      data:{"_method": "delete"},
      success: function(msg){
      }
    }).promise();

    ajaxPromise.then(function(result) {
      $('#unlike_id').html("<span class=\"glyphicon glyphicon-thumbs-up\"></span> いいね！");
      $('#unlike_id').removeClass('btn-default');
      $('#unlike_id').addClass('btn-primary');
      $('#unlike_id').attr('id', 'like_id');
      $('#like_count').html( parseInt(like_count) - 1);
    }, function(error) {
    });
  });
});

/**
 * set-notification.js
 *
 * Description:
 *   メール通知設定用JSファイル
 *
 * Author:
 *   @sota1235
 */

$(function() {
  /**
   * 通知設定変更をサーバに送信
   * @param {string}  type
   * @param {boolean} flag
   */
  var updateData = function(type, flag) {
    var uri = '/user/notification/update';
    var ajax = $.ajax({
      url: uri,
      data: {
        type: type,
        flag: flag
      },
      success: function(res) {
        return res.result;
      },
      error: function(req, stat, e) {
        return false;
      },
      type: 'POST',
      timeout: 60000
    });
    return ajax.promise();
  };

  /**
   * 通信成功メッセージを表示
   *
   * @param {string} title
   * @param {string} text
   * @return void
   */
  var successNotify = function(title, text) {
    new PNotify({
      title   : title,
      text    : text,
      type    : 'success',
      styling : 'fontawesome',
      delay   : 3000
    });
  };

  /**
   * 通信失敗メッセージを表示
   *
   * @param {string} title
   * @param {string} text
   * @return void
   */
  var failedNotify = function(title, text) {
    new PNotify({
      title   : title,
      text    : text,
      type    : 'error',
      styling : 'fontawesome',
      delay   : 3000
    });
  };

  /* Event listeners */
  $('input[type="checkbox"]').on('switchChange.bootstrapSwitch', function(event, state) {
    updateData(this.value, state)
      .then(function(result) {
        successNotify('設定を更新しました！', 'メール通知設定を更新しました');
      }, function(error) {
        failedNotify('サーバエラー', '管理者にお問い合わせください');
      });
  });
});

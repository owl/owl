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
    $.ajax({
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
  };

  /* Event listeners */
  $('input[type="checkbox"]').on('switchChange.bootstrapSwitch', function(event, state) {
    updateData(this.value, state); // TODO: error handling
  });
});

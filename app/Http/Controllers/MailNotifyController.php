<?php namespace Owl\Http\Controllers;

/**
 * @copyright (c) owl
 */

use Illuminate\Http\Request;
use Owl\Http\Controllers\Controller;
use Owl\Services\MailNotifyService;
use Owl\Services\UserService;

/**
 * Class MailNotifyjController
 * メール通知設定用コントローラークラス
 *
 * @package Owl\Http\Controllers
 */
class MailNotifyController extends Controller
{
    /**
     * 設定を更新
     *
     * @param Request            $request
     * @param UserService        $userService
     * @param MailNotifyService  $mailNotifyService
     *
     * @return \Illuminate\Http\Response
     */
    public function update(
        Request           $request,
        UserService       $userService,
        MailNotifyService $mailNotifyService
    ) {
        $params = $request->only(['type', 'flag']);

        $result = $mailNotifyService->updateSetting(
            $userService->getCurrentUser()->id,
            $params['type'],
            $params['flag']
        );

        return response()->json(['result' => $result]);
    }
}

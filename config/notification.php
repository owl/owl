<?php

return [
    /**
     * メールによるアクション通知機能を有効にする場合はtrueを設定する
     */
    'enabled' => env('NOTIFICATION_ENABLE', false),

    /**
     * メールによるアクション通知機能を有効にする場合はtrueを設定する
     */
    'slack' => [
        'webhook_url' => env('SLACK_WEBHOOK_URL', null),
    ]
];

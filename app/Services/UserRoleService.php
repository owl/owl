<?php namespace Owl\Services;

use Owl\Repositories\UserRoleRepositoryInterface;
use Carbon\Carbon;

class UserRoleService extends Service
{
    const ROLE_ID_MEMBER = 1;
    const ROLE_ID_OWNER = 2;

    protected $userRoleRepo;

    public function __construct(
        UserRoleRepositoryInterface $userRoleRepo
    ) {
        $this->userRoleRepo = $userRoleRepo;
    }

    public function getByUserId($userId)
    {
        return $this->reminderTokenRepo->getByUserId($userId);
    }

    public function getByToken($token)
    {
        return $this->reminderTokenRepo->getByToken($token);
    }

    public function create($userId, $token)
    {
        $params = [];
        $params['user_id'] = $userId;
        $params['token'] = $token;

        $data = $this->getByUserId($userId);

        if (empty($data)) {
            $ret = $this->reminderTokenRepo->insert($params);
        } else {
            $wkey = ['id' => $data->id];
            $ret = $this->reminderTokenRepo->update($params, $wkey);
        }
        return $ret;
    }

    public function delete($tokenId)
    {
        $wkey = ['id' => $tokenId];
        $ret = $this->reminderTokenRepo->delete($wkey);
        return $ret;
    }

    public function sendReminderMail($email, $token)
    {
        $data = ['token' => $token];
        \Mail::send('emails.passwordReminder', $data, function($message) use ($email) {
            $message->to($email)->subject('パスワード再設定 - Owl');
        });
    }
}

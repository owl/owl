<?php namespace Owl\Repositories\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_roles';

    protected $fillable = ['name'];

    public function user()
    {
        return $this->hasMany('Owl\Repositories\Eloquent\Models\User');
    }
}

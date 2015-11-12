<?php namespace Owl\Repositories\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'topics';

    protected $fillable = ['title','body'];

    public function user()
    {
        return $this->hasMany('Owl\Repositories\Eloquent\Models\User');
    }
}

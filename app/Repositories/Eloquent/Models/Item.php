<?php namespace Owl\Repositories\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = ['user_id','title','body','published', 'open_item_id'];

    public function user()
    {
        return $this->belongsTo('Owl\Repositories\Eloquent\Models\User');
    }

    public function tag()
    {
        return $this->belongsToMany('Owl\Repositories\Eloquent\Models\Tag');
    }

    public function like()
    {
        return $this->hasMany('Owl\Repositories\Eloquent\Models\Like');
    }

    public function comment()
    {
        return $this->hasMany('Owl\Repositories\Eloquent\Models\Comment');
    }
}

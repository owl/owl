<?php namespace Owl\Repositories\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = array('user_id', 'item_id');

    public function user()
    {
        return $this->belongsTo('Owl\Models\User');
    }

    public function item()
    {
        return $this->belongsTo('Owl\Models\Item');
    }
}

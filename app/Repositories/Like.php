<?php namespace Owl\Repositories;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = array('user_id', 'item_id');

    public function user() {
        return $this->belongsTo('Owl\Repositories\User');
    }

    public function item() {
        return $this->belongsTo('Owl\Repositories\Item');
    }
}

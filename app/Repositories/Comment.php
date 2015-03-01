<?php namespace Owl\Repositories;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    public function item() {
        return $this->belongsTo('Owl\Repositories\Item');
    }

    public function user() {
        return $this->belongsTo('Owl\Repositories\User');
    }
}

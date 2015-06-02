<?php namespace Owl\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    public function item() {
        return $this->belongsTo('Owl\Models\Item');
    }

    public function user() {
        return $this->belongsTo('Owl\Models\User');
    }
}

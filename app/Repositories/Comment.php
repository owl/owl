<?php

class Comment extends Eloquent {
    public function item() {
        return $this->belongsTo('Item');
    }

    public function user() {
        return $this->belongsTo('User');
    }
}

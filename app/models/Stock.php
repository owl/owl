<?php

class Stock extends Eloquent {
    protected $fillable = array('user_id', 'item_id');
    public function user() {
        return $this->belongsTo('User');
    }
    public function item() {
        return $this->belongsTo('Item');
    }
}

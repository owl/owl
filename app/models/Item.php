<?php

class Item extends Eloquent{
    protected $table = 'items';

    protected $fillable = ['user_id','title','body','published', 'open_item_id'];

    public function user() {
        return $this->belongsTo('User');
    }

    public static function createOpenItemId(){
        return substr(md5(uniqid(rand(),1)),0,20);
    }

}

<?php

class Item extends Eloquent{
    protected $table = 'items';

    protected $fillable = ['user_id','title','body','published'];
}

<?php

class Stock extends Eloquent {
    protected $fillable = array('user_id', 'item_id');
    public function user() {
        return $this->belongsTo('User');
    }
    public function item() {
        return $this->belongsTo('Item');
    }

    public static function getStockList($userId) {
        return DB::table('stocks')
                   ->join('items', 'stocks.item_id', '=', 'items.id')
                   ->join('users', 'items.user_id', '=', 'users.id')
                   ->where('stocks.user_id', $userId)
                   ->select('users.email', 'users.username', 'items.open_item_id',
                            'items.updated_at', 'items.title')
                   ->paginate(10);
    }
}

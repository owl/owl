<?php

use Carbon\Carbon;

class Stock extends Eloquent {
    const RANKING_STOCK_KEY = 'ranking_stock_';
    const EXPIRE_AT_ADD_MINUTES = 15;

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
                    ->orderBy('stocks.created_at', 'desc')
                    ->paginate(10);
    }

    public static function getRankingStockList($limit) {
        return DB::select(
            'select '.
            '    * '.
            'from '.
            '    items as i '.
            '    inner join ( '.
            '        select '.
            '            s.item_id, count(*) as stock_count '.
            '        from '.
            '            stocks s '.
            '        group by '.
            '            s.item_id '.
            '    ) as sc on i.id = sc.item_id '.
            'order by '.
            '    sc.stock_count desc '.
            'limit ?', 
            array($limit)
        );
    }

    public static function getRankingStockListWithCache($limit) {
        $result = Cache::get(Stock::RANKING_STOCK_KEY.$limit);

        if (!empty($result)) return $result;

        $result = Stock::getRankingStockList($limit);
        $expiresAt = Carbon::now()->addMinutes(Stock::EXPIRE_AT_ADD_MINUTES);
        Cache::put(Stock::RANKING_STOCK_KEY.$limit, $result, $expiresAt);

        return $result;
    }
}

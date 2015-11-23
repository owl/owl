<?php namespace Owl\Repositories\Fluent;

use Carbon\Carbon;
use Owl\Repositories\StockRepositoryInterface;

class StockRepository extends AbstractFluent implements StockRepositoryInterface
{
    protected $table = 'stocks';

    const RANKING_STOCK_KEY = 'ranking_stock_';
    const EXPIRE_AT_ADD_MINUTES = 15;

    /**
     * Get a table name.
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->table;
    }

    /**
     * Get a stock by id.
     *
     * @param $id int
     * @return stdClass
     */
    public function getStockById($id)
    {
        return \DB::table($this->getTableName())
            ->where($this->getTableName().'.id', $id)
            ->first();
    }

    /**
     * get "Stock data" or Store a "Stock data".
     *
     * @param $user_id int user_id
     * @param $item_id int item_id
     * @return stdClass
     */
    public function firstOrCreate($user_id, $item_id)
    {
        $stockData = \DB::table($this->getTableName())
            ->where($this->getTableName().'.user_id', $user_id)
            ->where($this->getTableName().'.item_id', $item_id)
            ->first();

        if (!empty($stockData)) {
            return $stockData;
        }

        $object = array();
        $object["user_id"] = $user_id;
        $object["item_id"] = $item_id;
        $stock_id = $this->insert($object);
        return $this->getStockById($stock_id);
    }

    /**
     * Get "Stock data".
     *
     * @param $user_id int user_id
     * @param $item_id int item_id
     * @return stdClass
     */
    public function getByUserIdAndItemId($user_id, $item_id)
    {
        return \DB::table($this->getTableName())
            ->where('user_id', '=', $user_id)
            ->where('item_id', '=', $item_id)
            ->first();
    }

    /**
     * Get "Stock data".
     *
     * @param $item_id int item_id
     * @return stdClass
     */
    public function getByItemId($item_id)
    {
        return \DB::table($this->getTableName())
            ->where('item_id', '=', $item_id)
            ->first();
    }

    /**
     * Delete a "Stock data".
     *
     * @param $user_id int user_id
     * @param $item_id int item_id
     * @return boolean
     */
    public function destroy($user_id, $item_id)
    {
        return \DB::table($this->getTableName())
            ->where('user_id', '=', $user_id)
            ->where('item_id', '=', $item_id)
            ->delete();
    }

    /**
     * Get recent ranking data from cache.
     *
     * @param $limit int limit date
     * @param $dayPeriod int day period
     * @return array
     */
    public function getRecentRankingWithCache($limit, $dayPeriod)
    {
        $result = $this->getRankingStockList($limit, $dayPeriod);
        return $result;
    }

    /**
     * Get ranking data from cache.
     *
     * @param $limit int limit date
     * @return array
     */
    public function getRankingWithCache($limit)
    {
        $result = \Cache::get(self::RANKING_STOCK_KEY.$limit);

        if (!empty($result)) {
            return $result;
        }

        $result = $this->getRankingStockList($limit);
        $expiresAt = Carbon::now()->addMinutes(self::EXPIRE_AT_ADD_MINUTES);
        \Cache::put(self::RANKING_STOCK_KEY.$limit, $result, $expiresAt);

        return $result;
    }

    /**
     * Get ranking data.
     *
     * @param $limit int limit date
     * @param $day_period int day period
     * @return array
     */
    public function getRankingStockList($limit, $day_period = null)
    {
        $options = array($limit);
        $where = '';
        if (!empty($day_period)) {
            $where = <<<__SQL__
                where i.created_at > ?
__SQL__;
            $period = Carbon::now()->subDays($day_period);
            array_unshift($options, $period);
        }
        $query = <<<__SQL__
            select 
                * 
            from 
                items as i 
                inner join ( 
                    select 
                        s.item_id, count(*) as stock_count 
                    from 
                        stocks s 
                    group by 
                        s.item_id 
                ) as sc on i.id = sc.item_id 
            $where
                and i.published = 2
            order by 
                sc.stock_count desc 
            limit ? 

__SQL__;
        return \DB::select($query, $options);
    }

    /**
     * Get stock lists.
     *
     * @param $user_id int user_id
     * @return array
     */
    public function getStockList($user_id)
    {
        return \DB::table('stocks')
                    ->join('items', 'stocks.item_id', '=', 'items.id')
                    ->join('users', 'items.user_id', '=', 'users.id')
                    ->where('stocks.user_id', $user_id)
                    ->select('users.email', 'users.username', 'items.open_item_id', 'items.updated_at', 'items.title')
                    ->orderBy('stocks.created_at', 'desc')
                    ->paginate(10);
    }
}

<?php namespace Owl\Services;

use Owl\Repositories\StockRepositoryInterface;

class StockService extends Service
{
    protected $stockRepo;

    public function __construct(StockRepositoryInterface $stockRepo)
    {
        $this->stockRepo = $stockRepo;
    }

    /**
     * Get stock lists.
     *
     * @param $user_id int user_id
     * @return array
     */
    public function getStockList($user_id)
    {
        return $this->stockRepo->getStockList($user_id);
    }

    /**
     * get "Stock data" or Store a "Stock data".
     *
     * @param $user_id int user_id
     * @param $item_id int item_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function firstOrCreate($user_id, $item_id)
    {
        return $this->stockRepo->firstOrCreate($user_id, $item_id);
    }

    /**
     * Delete a "Stock data".
     *
     * @param $user_id int user_id
     * @param $item_id int item_id
     * @return boolean
     */
    public function delete($user_id, $item_id)
    {
        return $this->stockRepo->destroy($user_id, $item_id);
    }

    /**
     * Get "Stock data".
     *
     * @param $user_id int user_id
     * @param $item_id int item_id
     * @return Illuminate\Database\Eloquent\Collection | Illuminate\Database\Eloquent\Builder
     */
    public function getByUserIdAndItemId($user_id, $item_id)
    {
        return $this->stockRepo->getByUserIdAndItemId($user_id, $item_id);
    }

    /**
     * Get "Stock data".
     *
     * @param $item_id int item_id
     * @return Illuminate\Database\Eloquent\Collection | Illuminate\Database\Eloquent\Builder
     */
    public function getByItemId($item_id)
    {
        return $this->stockRepo->getByItemId($item_id);
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
        return $this->stockRepo->getRecentRankingWithCache($limit, $dayPeriod);
    }

    /**
     * Get ranking data from cache.
     *
     * @param $limit int limit date
     * @return array
     */
    public function getRankingWithCache($limit)
    {
        return $this->stockRepo->getRankingWithCache($limit);
    }
}

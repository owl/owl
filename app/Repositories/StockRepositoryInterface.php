<?php namespace Owl\Repositories;

interface StockRepositoryInterface
{
    /**
     * get "Stock data" or Store a "Stock data".
     *
     * @param $user_id int user_id
     * @param $item_id int item_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function firstOrCreate($user_id, $item_id);

    /**
     * Get "Stock data".
     *
     * @param $user_id int user_id
     * @param $item_id int item_id
     * @return Illuminate\Database\Eloquent\Collection | Illuminate\Database\Eloquent\Builder
     */
    public function getByUserIdAndItemId($user_id, $item_id);

    /**
     * Get "Stock data".
     *
     * @param $item_id int item_id
     * @return Illuminate\Database\Eloquent\Collection | Illuminate\Database\Eloquent\Builder
     */
    public function getByItemId($item_id);

    /**
     * Delete a "Stock data".
     *
     * @param $user_id int user_id
     * @param $item_id int item_id
     * @return boolean
     */
    public function destroy($user_id, $item_id);


    /**
     * Get recent ranking data from cache.
     *
     * @param $limit int limit date
     * @param $dayPeriod int day period
     * @return array
     */
    public function getRecentRankingWithCache($limit, $dayPeriod);

    /**
     * Get ranking data from cache.
     *
     * @param $limit int limit date
     * @return array
     */
    public function getRankingWithCache($limit);

    /**
     * Get ranking data.
     *
     * @param $limit int limit date
     * @param $day_period int day period
     * @return array
     */
    public function getRankingStockList($limit, $day_period = null);

    /**
     * Get stock lists.
     *
     * @param $user_id int user_id
     * @return array
     */
    public function getStockList($user_id);
}

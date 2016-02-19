<?php

/**
 * @copyright (c) owl
 */
namespace Owl\Repositories\Fluent;

use Illuminate\Database\DatabaseManager;

/**
 * Abstract Class AbstractFluent
 *
 * @package Owl\Repositories\Fluent
 */
abstract class AbstractFluent
{
    /** @var string  Table name */
    protected $table = '';

    /**
     * Get a table name.
     *
     * @return string
     */
    abstract public function getTableName();

    /**
     * Find a record.
     *
     * @param array  $wkey
     * @param
     * @return \stcClass | null
     */
    public function get(array $wkey)
    {
        return \DB::table($this->getTableName())
            ->where($wkey)
            ->first();
    }

    /**
     * Insert a record.
     *
     * @param $params array ：key(column name) => value
     * @param $table string  ：table name(defalut: getTableName())
     * @return int ：inserted record's id
     */
    public function insert(array $params, $table = null)
    {
        if (is_null($table)) {
            $table = $this->getTableName();
        }

        $params = $this->setTimestamps($params);

        $id = \DB::table($table)->insertGetId($params);
        return $id;
    }

    /**
     * Update a record.
     *
     * @param $params array ：key(column name) => value
     * @param $wkey array   ：where key(column name) => value
     * @param $table string  ：table name(defalut: getTableName())
     * @return int ：updated count number
     */
    public function update(array $params, array $wkey, $table = null)
    {
        if (is_null($table)) {
            $table = $this->getTableName();
        }

        $params = $this->setTimestamps($params, false);

        return \DB::table($table)
            ->where(key($wkey), '=', current($wkey))
            ->update($params);
    }

    /**
     * Deletel a record.
     *
     * @param $wkey array   ：where key(column name) => value
     * @param $table string ：table name(defalut: getTableName())
     * @return int：deleted count number
     */
    public function delete(array $wkey, $table = null)
    {
        if (is_null($table)) {
            $table = $this->getTableName();
        }

        return \DB::table($table)
            ->where(key($wkey), '=', current($wkey))
            ->delete();
    }

    /**
     * Set timestamps.
     *
     * @param $params array
     * @param $updatedFlag boolean
     * @return array
     */
    protected function setTimestamps(array $params, $createdFlag = true)
    {
        $timestamp = date('Y-m-d H:i:s');
        if ($createdFlag === true) {
            $params['created_at'] = $timestamp;
        }
        $params['updated_at'] = $timestamp;
        return $params;
    }

    /**
     * Return query builder.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function builder()
    {
        $table = is_null($this->table) ? $this->getTableName : $this->table;

        return \DB::table($table);
    }
}

<?php

class ItemFts extends Eloquent{
    protected $table = 'items_fts';

    public $timestamps = false;

    public static function match($str) {
        $query = <<<__SQL__
            SELECT
              it.* 
            FROM
              items_fts fts 
            INNER JOIN
              items it ON it.id = fts.item_id 
            WHERE
              fts.words MATCH :match
__SQL__;
        return DB::select( DB::raw($query), array( 'match' => NGram::convert($str)));
    }


}

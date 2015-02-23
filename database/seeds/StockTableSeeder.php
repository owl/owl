<?php

class StockTableSeeder extends Seeder {

    public function run()
    {
        DB::table('stocks')->delete();
        Stock::create(
            ['user_id' => 1, 'item_id' => 1]
        );
    }
}

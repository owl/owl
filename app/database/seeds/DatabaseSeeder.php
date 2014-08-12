<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
            Eloquent::unguard();

            DB::table('items')->truncate();
            Item::create(
                [
                    'title' => '1回目の投稿',
                    'body' => 'This items number is 1.',
                    'user_id' => 1,
                    'published' => 2
                ]);
            Item::create(
                [
                    'title' => '2回目の投稿',
                    'body' => 'This items number is 2.',
                    'user_id' => 1,
                    'published' => 2
                ]);

            $this->call('StockTableSeeder');
        }
}

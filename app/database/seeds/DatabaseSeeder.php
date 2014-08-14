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
                    'open_item_id' => $this->tempid(),
                    'title' => '1回目の投稿',
                    'body' => 'This items number is 1.',
                    'user_id' => 1,
                    'published' => 2
                ]);
            Item::create(
                [
                    'open_item_id' => $this->tempid(),
                    'title' => '2回目の投稿',
                    'body' => 'This items number is 2.',
                    'user_id' => 1,
                    'published' => 2
                ]);

            $this->call('StockTableSeeder');
    }

    private function tempid(){
        return substr(md5(uniqid(rand(),1)),0,20);
    }

}

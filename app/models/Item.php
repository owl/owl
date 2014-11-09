<?php

class Item extends Eloquent{
    protected $table = 'items';

    protected $fillable = ['user_id','title','body','published', 'open_item_id'];

    public function user() {
        return $this->belongsTo('User');
    }

    public function tag() {
        return $this->belongsToMany('Tag');
    }

    public function like(){
        return $this->hasMany('Like');
    }

    public function comment(){
        return $this->hasMany('Comment');
    }

    public static function createOpenItemId(){
        return substr(md5(uniqid(rand(),1)),0,20);
    }

    public static function getAllItems() {
        return  Item::with('user')
                    ->where('published', '2')
                    ->orderBy('updated_at','desc')
                    ->paginate(10);
    }

    public static function getRecentItemsByUserId($userId) {
        return  Item::with('user')
                    ->where('published', '2')
                    ->where('user_id', $userId)
                    ->orderBy('id','desc')
                    ->take(5)->get();
    }

    public static function getRecentItemsByTagId($tagId) {
        return DB::table('items')
                    ->join('users', 'items.user_id', '=', 'users.id')
                    ->join('tags', 'tags.id', '=', 'item_tag.tag_id')
                    ->join('item_tag', 'items.id', '=', 'item_tag.item_id')
                    ->where('tags.id', $tagId)
                    ->where('published', '2')
                    ->select('users.email', 'users.username', 'items.open_item_id', 'items.updated_at', 'items.title')
                    ->orderBy('items.id', 'desc')
                    ->paginate(10);
    }

    /* @Override */
    public function save(array $options = array())
    {
        $ret = parent::save($options);

        //delete & insert fts
        ItemFts::where('item_id', $this->id)->delete();
        $fts = new ItemFts;
        $fts->item_id = $this->id;
        $fts->words = $this->toNgram($this->title, $this->body);
        $fts->save();

        return $ret;
    }

    /* @Override */
    public function delete()
    {
        ItemFts::where('item_id', $this->id)->delete();
        ItemHistory::where('item_id', $this->id)->delete();
        return parent::delete();
    }


    private function toNgram($title, $body){
        return FtsUtils::toNgram($title . "\n\n" . $body);
    }
}

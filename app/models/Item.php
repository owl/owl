<?php

class Item extends Eloquent{
    protected $table = 'items';

    protected $fillable = ['user_id','title','body','published', 'open_item_id'];

    public function user() {
        return $this->belongsTo('User');
    }

    public function like(){
        return $this->hasMany('Like');
    }

    public static function createOpenItemId(){
        return substr(md5(uniqid(rand(),1)),0,20);
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
        return parent::delete();
    }


    private function toNgram($title, $body){
        return FtsUtils::toNgram($title . "\n\n" . $body);
    }
}

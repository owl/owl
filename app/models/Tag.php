<?php

class Tag extends Eloquent {
    protected $guarded = array();

    public function item() {
        return $this->belongsToMany('Item');
    }

    public static function getTagIdsByTagName($tag_names) {
        $tag_ids = array();

        foreach($tag_names as $tag_name) {
            $tag = Tag::firstOrCreate(array('name' => $tag_name))->toArray();
            $tag_ids[] = (string)$tag['id'];
        }
        return $tag_ids;
    }

}

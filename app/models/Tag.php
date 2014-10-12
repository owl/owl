<?php

class Tag extends Eloquent {
    protected $guarded = array();

    public function item() {
        return $this->belongsToMany('Item');
    }

    public static function getTagIdsByTagNames($tag_names) {
        $tag_ids = array();

        foreach($tag_names as $tag_name) {
            $tag_name = mb_strtolower($tag_name);
            // タグがなかった場合は新規でcreateする
            $tag = Tag::firstOrCreate(array('name' => $tag_name))->toArray();
            $tag_ids[] = (string)$tag['id'];
        }
        return $tag_ids;
    }
}

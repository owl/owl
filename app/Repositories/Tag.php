<?php namespace Owl\Repositories;

use Illuminate\Database\Eloquent\Model;
use Owl\Libraries\FtsUtils;

class Tag extends Model {
    protected $guarded = array();

    public function item() {
        return $this->belongsToMany('Owl\Repositories\Item');
    }

    public static function getTagIdsByTagNames($tag_names) {
        $tag_ids = array();

        foreach($tag_names as $tag_name) {
            $tag_name = trim(mb_convert_kana( $tag_name, "&quot;s&quot;"));
            $tag_name = str_replace(" ","", $tag_name);
            if (empty($tag_name)) {
                continue;
            }
            $tag_name = mb_strtolower($tag_name);
            $tag = Tag::firstOrCreate(array('name' => $tag_name))->toArray();
            TagFts::firstOrCreate(array('tag_id' => $tag['id'], 'words' => FtsUtils::toNgram($tag_name)));
            $tag_ids[] = (string)$tag['id'];
        }
        return $tag_ids;
    }
}

<?php namespace Owl\Repositories\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $guarded = array();

    public function item()
    {
        return $this->belongsToMany('Owl\Models\Item');
    }
}

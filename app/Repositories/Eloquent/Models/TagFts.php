<?php namespace Owl\Repositories\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class TagFts extends Model
{
    protected $table = 'tags_fts';
    public $timestamps = false;
    protected $fillable = ['tag_id','words'];
}

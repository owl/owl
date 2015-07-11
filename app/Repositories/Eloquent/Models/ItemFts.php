<?php namespace Owl\Repositories\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Owl\Libraries\FtsUtils;

class ItemFts extends Model
{
    protected $table = 'items_fts';

    public $timestamps = false;
}

<?php namespace Owl\Repositories\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class ItemHistory extends Model
{
    protected $table = 'items_history';

    protected $fillable = ['item_id','user_id','title','body','published', 'open_item_id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('Owl\Repositories\Eloquent\Models\User');
    }
}

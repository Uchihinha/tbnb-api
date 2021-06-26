<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftDeletes;

    protected $hidden = [
        'updated_at',
        'deleted_at'
    ];

    public function getCreatedAtAttribute($value)
    {
        return (new Carbon($value))->format('Y-m-d H:i:s');
    }

}

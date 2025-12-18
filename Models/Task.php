<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=['taskname','status','user_id','deleted_at'];

    public function user()
    {
        return $this->belongsTo(UserDetail::class, 'user_id', 'id');
    }
}

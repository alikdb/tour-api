<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'location',
        'start_date',
        'end_date',
        'price',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'email');
    }
}

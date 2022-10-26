<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'number',
        'user_id',
        'card_id',
    ];

    // public function writer() {
    //     /* User <-> Post 의 relationship */
    //     // 1 : N
    //     // User는 hasMany posts
    //     // Post는 belongs to a User
    //     return $this->belongsTo(User::class, "user_id");
    //     /*
    //         select p.*, u.*
    //         from users u, posts p
    //         inner join on u.id = p.user_id
    //     */
    // }
}

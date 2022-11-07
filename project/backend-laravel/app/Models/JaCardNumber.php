<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JaCardNumber extends Model
{
    use HasFactory;
    protected $fillable = [
        'card_id',
        'time',
        'card_number',
        'pack_name',
        'rare'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoMyCard extends Model
{
    use HasFactory;
    protected $fillable = [
        'card_number_id',
        'amount'
    ];
}

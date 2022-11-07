<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JaCardNumber extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'name2',
        'icon',
        'attribute',
        'level',
        'rank',
        'link',
        'link_arrow',
        'p_scale',
        'p_effect',
        'card_text',
        'monster_type',
        'card_type',
        'atk',
        'def',
    ];
}

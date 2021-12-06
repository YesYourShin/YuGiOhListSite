<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orica extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'effect',
        'pEffect',
        'icon',
        'attribute',
        'level',
        'rank',
        'pScale',
        'link',
        'linkArray',
        'monsterType',
        'category',
        'monsterCategory',
        'atk',
        'def',
        'user_id',
    ];
}

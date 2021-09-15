<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Card extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'cards';

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
        'monsterType',
        'cardType',
        'atk',
        'def',
        'limit',

        // 'card_id',
    ];
}

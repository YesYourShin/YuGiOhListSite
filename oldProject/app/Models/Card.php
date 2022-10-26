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
        'title2',
        'limited',
        'icon',
        'attribute',
        'level',
        'rank',
        'link',
        'atk',
        'def',
        'monsterType' ,
        'cardType' ,
        'pScale' ,
        'pEffect' ,
        'cardText' ,

        // 'card_id',
    ];

    public function cards() {
        return $this -> hasMany(Card::class);
    }
}

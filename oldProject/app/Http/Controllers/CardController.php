<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Card;
use App\Models\Collection;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CardController extends Controller
{
    function insert(Request $request) 
    {
        $data = $request->json()->all();      

        foreach($data as $entry) {
            $title = $entry['title'];
            $title2 = $entry['title2'];
            $limited = isset($entry['limited']) ? $entry['limited'] : '';
            $icon = isset($entry['icon']) ? $entry['icon'] : '';
            $attribute = isset($entry['attribute']) ? $entry['attribute'] : '';
            $level = isset($entry['level']) ? $entry['level'] : '';
            $rank = isset($entry['rank']) ? $entry['rank'] : '';
            $link = isset($entry['link']) ? $entry['link'] : '';
            $atk = isset($entry['atk']) ? $entry['atk'] : '';
            $def = isset($entry['def']) ? $entry['def'] : '';
            $monsterType = isset($entry['monsterType']) ? $entry['monsterType'] : '';
            $cardType1 = isset($entry['cardType1']) ? $entry['cardType1'] : '';
            $cardType2 = isset($entry['cardType2']) ? $entry['cardType2'] : '';
            $cardType3 = isset($entry['cardType3']) ? $entry['cardType3'] : '';
            $pScale = isset($entry['pScale']) ? $entry['pScale'] : '';
            $pEffect = isset($entry['pEffect']) ? $entry['pEffect'] : '';
            $cardText = $entry['cardText'];
            

            $validator = Validator::make($entry, [
                'title' => 'required|unique:cards',
                'title2' => 'nullable',
                'limited' => 'nullable',
                'icon' => 'nullable',
                'attribute' => 'nullable',
                'level' => 'nullable',
                'rank' => 'nullable',
                'link' => 'nullable',
                'atk' => 'nullable',
                'def' => 'nullable',
                'monsterType' => 'nullable',
                'cardType' => 'nullable',
                'pScale' => 'nullable',
                'pEffect' => 'nullable',
                'cardText' => 'required',
            ]);

            if ($validator->fails()){
                $messages = $validator->messages();
                return response($messages);
            }
            
            Card::create([
                'title' => $title,
                'title2' => $title2,
                'limited' => $limited,
                'icon' => $icon,
                'attribute' =>  $attribute,
                'level' =>  $level,
                'rank' =>  $rank,
                'link' =>  $link,
                'atk' => $atk,
                'def' => $def,
                'monsterType' => $monsterType,
                'cardType1' => $cardType1,
                'cardType2' => $cardType2,
                'cardType3' => $cardType3,
                'pScale' => $pScale,
                'pEffect' => $pEffect,
                'cardText' => $cardText,
            ]);
        }
        return response(['success']);
    }

    public function cardlistpage()
    {
        $cards = DB::table('cards')->paginate(12);

        return ['response' => $cards, 'success' => 1];
    }

    public function cardlist()
    {
        return Inertia::render('Card/CardList');
    }

    public function search ($search) 
    {
        $cards = DB::table('cards')->where('title', 'like', '%'.$search.'%')->paginate(12);

        return $cards;
    }

    public function show($id) 
    {
        $card = DB::table('cards')->where('id', 'like', $id)->first();

        return Inertia::render('Card/CardItem', ['response'=>$card, 'id'=>$card->id]);
    }
}

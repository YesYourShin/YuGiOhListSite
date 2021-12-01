<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Card;
use App\Models\Collection;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    function insert(Request $request) {
        // return $request->{'titles'};

        // dd($request->json()->all());
        
        $data = $request->json()->all();

        // $data = json_decode($request->getContent(), true);        


        foreach($data as $entry) {


            $title = $entry['title'];
            $effect = $entry['text'];
            $pEffect = isset($entry['ptext']) ? $entry['ptext'] : '';
            $icon = isset($entry['효과']) ? $entry['효과'] : '';
            $attribute = isset($entry['속성']) ? $entry['속성'] : '';
            $level = isset($entry['레벨']) ? $entry['레벨'] : '';
            $rank = isset($entry['랭크']) ? $entry['랭크'] : '';
            $pScale = isset($entry['펜듈럼 스케일']) ? $entry['펜듈럼 스케일'] : '';
            $link = isset($entry['링크']) ? $entry['링크'] : '';
            $monsterType = isset($entry['종족']) ? $entry['종족'] : '';
            $cardType = isset($entry['기타 항목']) ? $entry['기타 항목'] : '';
            $atk = isset($entry['공격력']) ? $entry['공격력'] : '';
            $def = isset($entry['수비력']) ? $entry['수비력'] : '';
            $limited = isset($entry['limited']) ? $entry['limited'] : '';

            // $id = $entry['id'];

            $validator = Validator::make($entry, [
                'title' => 'required|unique:cards',
                'text' => 'required',
                'ptext' => 'nullable',
                'icon' => 'nullable',
                'attribute' => 'nullable',
                'level' => 'nullable',
                'rank' => 'nullable',
                'pScale' => 'nullable',
                'link' => 'nullable',
                'monsterType' => 'nullable',
                'cardType' => 'nullable',
                'atk' => 'nullable',
                'def' => 'nullable',
                'limited' => 'nullable',

                // 'id' => 'nullable|unique:cards',
            ]);

            if ($validator->fails()){
                $messages = $validator->messages();
                return response($messages);
            }
            
            Card::create([
                'title' => $title,
                'effect' => $effect,
                'pEffect' => $pEffect,
                'icon' => $icon,
                'attribute' => $attribute,
                'level' => $level,
                'rank' => $rank,
                'pScale' => $pScale,
                'link' => $link,
                'monsterType' => $monsterType,
                'cardType' => $cardType,
                'atk' => $atk,
                'def' => $def,
                'limited' => $limited,

                // 'card_id' => $id,
            ]);
        }


                
        

        return response(['success']);
    }

    public function cardlist()
    {

        $cards = DB::table('cards')->paginate(10);

        return response(['cards' => $cards, 'success' => 1]);

    }

    public function search ($search) {
        $cards = DB::table('cards')->where('title', 'like', '%'.$search.'%')->paginate(10);

        return $cards;
        
    }

    // public function store (Request $request) {
    //     $this->validate($request, [
    //         'title'=>'required',
    //         'number'=>'required'
    //     ]);

    //     $input = array_merge($request->all(), [
    //         "user_id"=>Auth::user()->id
    //     ]);

    //     Collection::create($input);
    // }

    public function show($title) {
        // $card = Card::with('likes')->find($id);
        $card = DB::table('cards')->where('title', 'like', $title)->first();
        // $card = DB::table('cards')
        //     ->where('id', 'like', $id)->get()
        //     ->join('collections', 'cards.')
        // ;
        
        return $card;
    }
}

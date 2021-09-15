<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Models\Card;

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
            $limit = isset($entry['limit']) ? $entry['limit'] : '';

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
                'limit' => 'nullable',

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
                'limit' => $limit,

                // 'card_id' => $id,
            ]);
        }


                
        

        return response(['success']);
    }
}

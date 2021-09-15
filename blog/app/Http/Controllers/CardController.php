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



            // if(array_search('효과', $entry)){
            //     $icon = $entry['효과'];
            // }

            // if(array_search('속성', $entry)){
                
            //     $attribute = $entry['속성'];
            //     if(array_search('수비력', $entry)){
            //         if(array_search('레벨', $entry)){
            //             $level = $entry['레벨'];
            //         }
            //         if(array_search('text', $entry)){
            //             $pEffect = $entry['ptext'];
            //             $pScale = $entry['펜듈럼 스케일'];  
            //         }
            //         if(array_search('랭크', $entry)){
            //             $rank = $entry['랭크'];
            //         }
                    
            //         $def = $entry['수비력'];
            //     } 
            //     if(array_search('링크', $entry)){
            //             $link = $entry['링크'];
            //     }
            //     $atk = $entry['공격력'];
                
            //     $monsterType = $entry['종족'];
            //     $cardType = $entry['기타 항목'];
                
            // }
            
        
            
            
            
            
            

            
            // $id = $entry['id'];

            $validator = Validator::make($entry, [
                // 'title' => 'required|unique:cards',
                // 'text' => 'required',
                // 'id' => 'nullable|unique:cards',

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
                'def' => 'nullable'
            ]);

            if ($validator->fails()){
                $messages = $validator->messages();
                return response($messages);
            }
            
            Card::create([
                // 'title' => $title,
                // 'text' => $text,
                // 'card_id' => $id,

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
            ]);
        }


                
        

        return response(['success']);
    }
}

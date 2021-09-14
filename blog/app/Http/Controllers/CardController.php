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
        foreach($data as $entry) {
            $title = $entry['title'];
            $text = $entry['text'];
            // $id = $entry['id'];

            $validator = Validator::make($entry, [
                'title' => 'required|unique:cards',
                'text' => 'required',
                // 'id' => 'nullable|unique:cards',
            ]);

            if ($validator->fails()){
                $messages = $validator->messages();
                return response($messages);
            }
            
            Card::create([
                'title' => $title,
                'text' => $text,
                // 'card_id' => $id,
            ]);
        }


                
        

        return response(['success']);
    }
}

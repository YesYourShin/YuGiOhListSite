<?php

namespace App\Http\Controllers;

use App\Models\JaCard;
use App\Models\JaCardNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardJAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return JaCard::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cards = $request->all();

        # 카드 정보들 다 array에 넣음
        # card_list는 다른 테이블에 들어가야 하기에 제외

        foreach($cards as $card) {
            $array = [];
            $cardList = [];
            foreach($card as $key => $item) {
                if($key=="card_list"){
                    $cardList = $item;
                    continue;
                }
                $array = array_merge($array, ["$key" => "$item"]);
            }
            // echo(json_encode($array));

            # cards_jp에 카드 정보 넣음
            DB::table('ja_cards')->insert([
                $array
            ]);

            # cards_jp에 넣은 카드의 카드 아이디를 구하는 쿼리
            $cardId = DB::table('ja_cards')->where('name', $array['name'])->value('id');

            # cards_jp_list에 카드 아이디와 같이 card_list 정보를 넣음
            foreach($cardList as $card) {
                $card['card_id'] = $cardId;
                DB::table('ja_card_numbers')->insert([
                    $card
                ]);
            }

        }

        return "insert jp cards success";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $card = JaCard::where('id', $id)->first()->toArray();
        $cardNumber = JaCardNumber::where('card_id', $card['id'])->get()->toArray();
        // echo($card);
        // $card_id = $card->id;
        // dd($card->id);

        $card = array_merge($card, ['cardNumber' => $cardNumber]);
        return $card;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
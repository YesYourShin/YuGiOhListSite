<?php

namespace App\Http\Controllers;

use App\Models\JaCard;
use App\Models\JaCardNumber;
use App\Models\UserCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class JaCardController extends Controller
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
    public function create(Request $request)
    {
        // 유저가 가진 카드를 저장할 때 쓰는 함수

        // 로그인이 됐는지는 routes/api.php에서 Middleware로 확인하고 여기로 옴

        // 유저가 보낸 카드 아이디를 테이블에 저장

        // 정보가 제대로 오지 않았을 때 오류 처리 해야 함!!!!!!!!!

        $validator = Validator::make($request->all(), [
                'user_id' => 'required|string',
                'card_number_id' => 'required|string',
                'amount' => ['required','string',Rule::notIn(["0"])]
        ]);

        if ($validator->fails()) {
            return "에러";
        }



        UserCard::insert([
            'user_id' => $request->user_id,
            'card_number_id' => $request->card_number_id,
            'amount' => $request->amount
        ]);

        return 'success';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 카드 정보를 넣는 함수임
        $cards = $request->all();

        // 카드 정보들 다 array에 넣음
        // card_list는 다른 테이블에 들어가야 하기에 제외

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

            // cards_jp에 카드 정보 넣음
            DB::table('ja_cards')->insert([
                $array
            ]);

            // cards_jp에 넣은 카드의 카드 아이디를 구하는 쿼리
            $cardId = DB::table('ja_cards')->where('name', $array['name'])->value('id');

            // cards_jp_list에 카드 아이디와 같이 card_list 정보를 넣음
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
    public function update(Request $request)
    {
        // 유저가 가진 카드 개수 업데이트

        // 정보가 제대로 오지 않았을 때 오류 처리 해야 함!!!!!!!!!

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string',
            'card_number_id' => 'required|string',
            'amount' => ['required','string',Rule::notIn(["0"])]
        ]);

        if ($validator->fails()) {
            return "에러";
        }

        UserCard::where('user_id', $request->user_id)
            ->where('card_number_id', $request->card_number_id)
            ->update(['amount' => $request->amount]);

        return 'success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // 유저가 가진 카드 삭제

        $card = UserCard::where('user_id', $request->user_id)
            ->where('card_number_id', $request->card_number_id)
            ->delete();

        return 'delete success';
    }
}

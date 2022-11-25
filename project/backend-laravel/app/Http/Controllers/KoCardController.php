<?php

namespace App\Http\Controllers;

use App\Models\KoCard;
use App\Models\KoCardNumber;
use App\Models\KoMyCard;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KoCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 여기서 전체 카드 리스트를 보여줌
        return KoCard::paginate(100);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // 유저가 가진 카드를 저장할 때 쓰는 함수

        // 유저가 보낸 카드 아이디를 테이블에 저장

        KoMyCard::insert([
            'user_id' => $request->userId,
            'card_number_id' => $request->cardNumberId,
            'amount' => $request->amount
        ]);

        return 'create success';
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

            # cards_kr에 카드 정보 넣음
            DB::table('ko_cards')->insert([
                $array
            ]);

            # cards_kr에 넣은 카드의 카드 아이디를 구하는 쿼리
            $cardId = DB::table('ko_cards')->where('name', $array['name'])->value('id');

            # cards_kr_list에 카드 아이디와 같이 card_list 정보를 넣음
            foreach($cardList as $card) {
                $card['card_id'] = $cardId;
                DB::table('ko_card_numbers')->insert([
                    $card
                ]);
            }

        }

        return "insert kr cards success";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        // 카드 상세 정보 표시

        // 카드의 코드를 기준으로 찾음
        // 이렇게 해야 언어를 바꿨을 때도 카드정보 보여줄 수 있음
        try {
            $card = KoCard::where('code', $code)->firstOrFail();
        }
        catch(Exception $e){
            return "Not Found";
        }

        // 위에서 찾은 해당 카드의 card numbers를 찾아줌
        // 유저가 로그인 한 상태일 경우에는 소지하고 있는 card numbers의 장수도 같이 알려줌
        if(Auth::guard('api')->check()) {
            $userId = auth('api')->user()->id;
            $cardNumber = KoMyCard::join('ko_card_numbers', 'ko_my_cards.card_number_id', '=', 'ko_card_numbers.id')
                ->where('ko_my_cards.user_id', $userId)
                ->where('ko_card_numbers.card_id', $card->id)
                ->select('ko_my_cards.*', 'ko_card_numbers.*', )
                ->get()
                ->toArray();
        } else {
            $cardNumber = KoCardNumber::where('card_id', $card['id'])->get()->toArray();
        }

        $card = $card->toArray();
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

        KoMyCard::where('user_id', $request->userId)
            ->where('card_number_id', $request->cardNumberId)
            ->update(['amount' => $request->amount]);

        return 'update success';
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

        KoMyCard::where('user_id', $request->userId)
            ->where('card_number_id', $request->cardNumberId)
            ->delete();

        return 'delete success';
    }

    public function myCardStore(Request $request)
    {
        // 받은 카드 데이터를 바탕으로 create인지 update인지 destroy인지 판단함

        // 로그인이 됐는지는 routes/api.php에서 Middleware로 확인하고 여기로 옴

        // validate 체크
        $validator = Validator::make($request->all(), [
            'cardNumberId' => 'required|string',
            'amount' => ['required','string']
        ]);

        if ($validator->fails()) {
            return "에러";
        }

        // post 한 유저의 아이디를 가져옴
        $userId = auth('api')->user()->id;

        // request 객체에 userId 추가
        $request['userId'] = $userId;

        // user_cards 테이블에서 해당 유저가 이 카드를 가지고 있는지 판단함
        $card = KoMyCard::where('user_id', $userId)
            ->where('card_number_id', $request->cardNumberId)
            ->get();

        // --------------------
        // create
        // 카드를 가지고 있지 않을 경우 create
        if (!count($card)) {

            return KoCardController::create($request);
        }
        // --------------------
        // update
        // 카드를 가지고 있고 amount가 0이 아닐 경우 update
        if ($request['amount']) {
            return KoCardController::update($request);
        }
        // --------------------
        // 카드를 가지고 있고 amount가 0인 경우 destroy
        else {
            return KoCardController::destroy($request);
        }
    }

    public function myCardIndex() {
        // 유저의 아이디를 가져옴
        $userId = auth('api')->user()->id;

        $cards = KoCard::join('ko_card_numbers', 'ko_cards.id', '=', 'ko_card_numbers.card_id')
            ->join('ko_my_cards', 'ko_card_numbers.id', '=', 'ko_my_cards.card_number_id')
            ->where('ko_my_cards.user_id', $userId)
            ->select('ko_cards.*', 'ko_card_numbers.*', 'ko_my_cards.*')
            ->paginate(100);
        return $cards;
    }
}

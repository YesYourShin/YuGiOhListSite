<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collection = DB::table('collection')->paginate(10);

        return response(['collection' => $collection, 'success' => 1]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function insert(Request $request)
    {
        
        $input = $this->validate($request, [
            'title'=>'required',
            'number'=>'required',
            'card_id'=>'required',
        ]);

        $input = array_merge($request->all(), [
            'user_id'=>Auth::user()->id
        ]);

        // 이미 있는 카드일 경우 insert 안 되도록 코드 짜야됨

        Collection::create($input);

        return response(['success']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id = Auth::id();

        $collection = Collection::where([
            ['card_id','like',$id],
            ['user_id','like',$user_id],
        ])->first();


        // $collection = DB::table('collections')->where('title', 'like', $title)->get();
        return response(['collection' => $collection]);
    }

    public function cardshow($id)
    {
        // dd($title);
        $collection = Collection::where('id','like',$id)->first();
        if($collection) {
            $collection = Card::where('title','like',$collection['title'])->first();
        }

        // $collection = DB::table('collections')->where('title', 'like', $title)->get();
        return $collection;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        
        $card = json_decode($request->getContent(), true);
        // $card = $data->json()->all();


        $request->validate(['number'=>'required']);
        // Validator::make($request->all(), [
        //     "number" => 'required'
        // ]);


        $user_id = Auth::id();
        $collection = Collection::where([
            ['card_id','like', $request['card_id']],
            ['user_id','like',$user_id],
        ])->first();
        // $collection = DB::table('collection')->where('title', 'like', $data->title)->get();

        // $this->authorize('update', $collection);

        $collection->update([
            'number'=>$request['number'],
        ]);

        return $collection;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user_id = Auth::id();
        // $collection = Collection::where(
        //     ['card_id','like', $id],
        //     ['user_id','like', $user_id],

        // )->first();
        $collection = DB::table('collections')->where([
            ['card_id','like', $id],
            ['user_id','like', $user_id],

        ])->delete();

        return $collection;
    }

    public function collectionlist()
    {
        return Inertia::render('Card/MyCardList');
    }

    public function collectionlistpage()
    {

        $auth = Auth::id();

        $cards = DB::table('collections')->where('user_id', 'like', $auth)->orderBy('id', 'DESC')->paginate(10);

        // DB::table('cards')->where('id', 'like', $card->title)

        return ['response' => $cards, 'success' => 1];
    }

    public function search ($search) {
        // dd($search);
        $user_id = Auth::id();
        $cards = DB::table('collections')->where([
            ['title','like', '%'.$search.'%'],
            ['user_id','like', $user_id],
        ])->paginate(10);

        return $cards;
        
    }
}

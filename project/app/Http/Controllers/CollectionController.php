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

        return response(['collection' => $collection]);
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
        $request->validate(['number'=>'required']);

        $user_id = Auth::id();

        $collection = Collection::where([
            ['card_id','like', $request['card_id']],
            ['user_id','like',$user_id],
        ])->first();

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

        $cards = DB::table('collections')->where('user_id', 'like', $auth)
                ->orderBy('id', 'DESC')->paginate(12);

        return ['response' => $cards, 'success' => 1];
    }

    public function search ($search) {
        $user_id = Auth::id();

        $cards = DB::table('collections')->where([
            ['title','like', '%'.$search.'%'],
            ['user_id','like', $user_id],
        ])->orderBy('id', 'DESC')->paginate(12);

        return $cards;
    }
}

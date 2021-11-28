<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        ]);

        // $input = array_merge($request->all(), [
        //     "user_id"=>Auth::user()->id
        // ]);

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
    public function show($title)
    {
        // dd($title);
        $collection = Collection::where('title','like',$title)->first();


        // $collection = DB::table('collections')->where('title', 'like', $title)->get();
        return $collection;
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

        $collection = Collection::where('title','like', $card['title'])->first();
        // $collection = DB::table('collection')->where('title', 'like', $data->title)->get();

        // $this->authorize('update', $collection);

        $collection->update([
            'number'=>$card['number'],
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
        $collection = Collection::where('title','like',$request['title'])->first();

        $collection->delete();

        return $collection;
    }

    public function collectionlist()
    {
        $cards = DB::table('collections')->paginate(10);

        return response(['cards' => $cards, 'success' => 1]);
    }
}

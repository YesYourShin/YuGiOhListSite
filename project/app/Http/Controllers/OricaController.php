<?php

namespace App\Http\Controllers;

use App\Models\Orica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class OricaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function insert(Request $request)
    {
        // $data = $request->json()->all();
        // $data = $request->all();

        // dd($data);
        
            // dd($request['title']);
            $title = $request['title'];
            $effect = $request['effect'];
            $pEffect = isset($request['pEffect']) ? $request['pEffect'] : '';
            $icon = isset($request['icon']) ? $request['icon'] : '';
            $attribute = isset($request['attribute']) ? $request['attribute'] : '';
            $level = isset($request['level']) ? $request['level'] : '';
            $rank = isset($request['rank']) ? $request['rank'] : '';
            $pScale = isset($request['pScale']) ? $request['pScale'] : '';
            $link = isset($request['link']) ? $request['link'] : '';
            $linkArray = isset($request['linkArray']) ? $request['linkArray'] : '';
            $monsterType = isset($request['monsterType']) ? $request['monsterType'] : '';
            $category = isset($request['category']) ? $request['category'] : '';
            $monsterCategory = isset($request['monsterCategory']) ? $request['monsterCategory'] : '';
            $atk = isset($request['atk']) ? $request['atk'] : '';
            $def = isset($request['def']) ? $request['def'] : '';

            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'effect' => 'required',
                'pEffect' => 'nullable',
                'icon' => 'nullable',
                'attribute' => 'nullable',
                'level' => 'nullable',
                'rank' => 'nullable',
                'pScale' => 'nullable',
                'link' => 'nullable',
                'linkArray' => 'nullable',
                'monsterType' => 'nullable',
                'category' => 'nullable',
                'monsterCategory' => 'nullable',
                'atk' => 'nullable',
                'def' => 'nullable',
            ]);

            if ($validator->fails()){
                $messages = $validator->messages();
                return response($messages);
            }
            

            Orica::create([
                'title' => $title,
                'effect' => $effect,
                'pEffect' => $pEffect,
                'icon' => $icon,
                'attribute' => $attribute,
                'level' => $level,
                'rank' => $rank,
                'pScale' => $pScale,
                'link' => $link,
                'linkArray' => $linkArray,
                'monsterType' => $monsterType,
                'category' => $category,
                'monsterCategory' => $monsterCategory,
                'atk' => $atk,
                'def' => $def,
                'user_id'=>Auth::user()->id
            ]);
    

        return response([isset($request['level']), 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        // $card = Card::with('likes')->find($id);
        $orica = DB::table('oricas')->where('id', 'like', $id)->first();
        // $card = DB::table('cards')
        //     ->where('id', 'like', $id)->get()
        //     ->join('collections', 'cards.')
        // ;
        return Inertia::render('Card/OricaItem', ['orica' => $orica]);
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

    public function oricalist()
    {
        return Inertia::render('Card/OricaList');

    }

    public function oricalistpage()
    {
        
        $oricas = DB::table('oricas')->paginate(10);
        
        return ['response' => $oricas, 'success' => 1];

    }

    public function search ($search) {
        dd($search);
        $oricas = DB::table('oricas')->where('title', 'like', '%'.$search.'%')->paginate(10);

        return $oricas;
        
    }

    public function myoricalist()
    {
        return Inertia::render('Card/MyOricaList');

    }

    public function myoricalistpage()
    {

        $auth = Auth::id();
        
        $oricas = DB::table('oricas')->where('user_id', 'like', $auth)->paginate(10);
        
        return ['response' => $oricas, 'success' => 1];

    }
}

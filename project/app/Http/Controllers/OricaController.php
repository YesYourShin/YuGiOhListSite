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
        

        $orica = Orica::create([
            'title' => $request['title'],
            'effect' => $request['effect'],
            'pEffect' => $request['pEffect'],
            'icon' => $request['icon'],
            'attribute' => $request['attribute'],
            'level' => $request['level'],
            'rank' => $request['rank'],
            'pScale' => $request['pScale'],
            'link' => $request['link'],
            'linkArray' => $request['linkArray'],
            'monsterType' => $request['monsterType'],
            'category' => $request['category'],
            'monsterCategory' => $request['monsterCategory'],
            'atk' => $request['atk'],
            'def' => $request['def'],
            'user_id'=>Auth::user()->id
        ]);
        return response(['success', 'id' => $orica -> id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $orica = DB::table('oricas')->where('id', 'like', $id)->first();

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
        $auth = Auth::id();

        $orica = DB::table('oricas')->where('id', 'like', $id)->first();

        if($orica->user_id == $auth) {
            return Inertia::render('Card/OricaEdit', ['response' => $orica]);
        }

        return;
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

        $orica = Orica::find($id);

        $orica->update([
            'title' => $request['title'],
            'effect' => $request['effect'],
            'pEffect' => $request['pEffect'],
            'icon' => $request['icon'],
            'attribute' => $request['attribute'],
            'level' => $request['level'],
            'rank' => $request['rank'],
            'pScale' => $request['pScale'],
            'link' => $request['link'],
            'linkArray' => $request['linkArray'],
            'monsterType' => $request['monsterType'],
            'category' => $request['category'],
            'monsterCategory' => $request['monsterCategory'],
            'atk' => $request['atk'],
            'def' => $request['def'],
        ]);

        return ['id' => $orica->id];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('oricas')->where('id','like', $id)->delete();

        return ['success' => true];
    }

    public function oricalist()
    {
        return Inertia::render('Card/OricaList');
    }

    public function oricalistpage()
    {
        $oricas = DB::table('oricas')->orderBy('id', 'DESC')->paginate(12);

        return ['response' => $oricas, 'success' => 1];
    }

    public function search ($search) {
        $oricas = DB::table('oricas')->where('title', 'like', '%'.$search.'%')
                ->orderBy('id', 'DESC')->paginate(12);

        return $oricas;
    }

    public function myoricalist()
    {
        return Inertia::render('Card/MyOricaList');

    }

    public function myoricalistpage()
    {
        $auth = Auth::id();
        
        $oricas = DB::table('oricas')->where('user_id', 'like', $auth)
                ->orderBy('id', 'DESC')->paginate(12);
        
        return ['response' => $oricas, 'success' => 1];
    }

    public function check($user_id)
    {
        $auth = Auth::id();

        if ($auth == $user_id) {
            return ['check' => true];
        } 

        return ['check' => false];
    }

    public function mysearch ($search) 
    {
        $user_id = Auth::id();

        $oricas = DB::table('oricas')->where([
            ['user_id','like',$user_id],
            ['title', 'like', '%'.$search.'%']

            ])->orderBy('id', 'DESC')->paginate(12);

        return $oricas;
    }
}

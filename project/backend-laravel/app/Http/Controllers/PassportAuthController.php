<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PassportAuthController extends Controller
{

    public function __construct()
    {
        /**
         *
         * success : 성공시 200 반환
         * token : 성공시 토큰 값 반환
         * error : 실패시 에러
         * message : 에러 메시지 반환
         */
    }

     /**
     * 회원가입 API
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('MingyuApp')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    /**
     * 로그인
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('MingyuApp')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function logout(Request $request)
    {
        $result = $request->user()->token()->revoke();
        if($result){
                $response = response()->json(['error'=>false,'message'=>'User logout successfully.'],200);
            }else{
                $response = response()->json(['error'=>true,'message'=>'Something is wrong.'],401);
            }
        return $response;
    }
}

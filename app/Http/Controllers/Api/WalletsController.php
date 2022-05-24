<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\WalletsResource;
use App\Http\Resources\TransactionsResource;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Auth;

class WalletsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function my_wallet(Request $request)
    {
        $user_id = Auth::guard('api')->user()->id;
        $my_wallet   = Wallet::where('user_id',$user_id)->first();
        $data    = [
            'wallet'=> $my_wallet,
        ];
        $message = 'Wallet retrieved successfully';
        $status_code    = 200;
        return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function wallet_history(Request $request)
    {
        $user_id = Auth::guard('api')->user()->id;
        $wallet_history = Transaction::with('sender','receiver')->where('sender_id',$user_id)->orWhere('receiver_id',$user_id)->orderBy('id','desc')->get();
         $data    = [
            'wallet_history'=>  TransactionsResource::collection($wallet_history),
        ];
        $data   = null;
        $message = 'Wallet History retrieved successfully';
        $status_code    = 200;
        return response(['data'=>$data, 'message'=>$message, 'status_code'=>$status_code]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function show(Wallet $wallet)
    {
        $data   = null;
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function userWallet($user_id)
    {
        return Wallet::where('user_id',$user_id)->pluck('amount')->first();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wallet $wallet)
    {


        $data   = null;
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet)
    {
        $data   = null;
        $message    =   'Unauthorized access!';
        $status_code   = 401;

        return response([ 'data' => $data, 'message' => $message, 'status_code'=>$status_code]);
    }
}

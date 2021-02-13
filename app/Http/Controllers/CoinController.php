<?php

namespace App\Http\Controllers;

use App\Coin;
use Illuminate\Http\Request;

class CoinController extends Controller
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
    public function store(Request $request)
    {
        $check = Coin::where("user_id",$request->user_id)->get();
        if($check->isEmpty()){
            $coin = Coin::create($request->all());
        }
        else{
            $coin = Coin::find($check[0]->id);
            $coin->amount = $coin->amount+$request->amount;
            $coin->save();
        }
        return response()->json(['message' => 'successfully you bye some coin']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function show(Coin $coin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function edit(Coin $coin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coin $coin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coin $coin)
    {
        //
    }

    /**
     * Check user has coin
     */
    public function checkCoin(Request $request){
        $coin = Coin::where("user_id",$request->user_id)->get();
        if($coin->isEmpty()){
            return response()->json(['status'=>false,'message'=>"You don't have any coin,Please bye"]);
        }
        else{
            $amout = $coin[0]->amount;
            return response()->json(['status'=>true,'message' => $amout]);
        }
    }

    /**
     * set gift
     */
    public function setGift(Request $request)
    {
        $check = Coin::where("user_id",$request->user_id)->get();
        if(!$check->isEmpty()){
            $coin = Coin::find($check[0]->id);
            $coin->amount = $check[0]->amount - $request->amount;
            if($coin->save()){
                return response()->json(['status' => true,'message' => "Thanks"]);
            }
        }
    }
}

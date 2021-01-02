<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Message;
use App\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $user_1;
    protected $user_2;
    public function index($user_1,$user_2)
    {
        $this->user_1 = $user_1;
        $this->user_2 = $user_2;
        return  response([
            'message'=>Message::whereIn("user_1",function($query){
                return $query->select('user_1')->from('messages')->where('user_1', $this->user_1)
                ->orWhere('user_1',$this->user_2);
             })
            ->whereIn("user_2",function($query){
                return $query->select('user_2')->from('messages')->where('user_2', $this->user_1)
                ->orWhere('user_2',$this->user_2);
            })
            ->get(),
            'user' => User::find($user_2)
        ]);
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
        $message = Message::create($request->all());
        broadcast(new MessageSent(auth()->user(),$message,$request->user_2))->toOthers();
        return response(['status' => true,'message' => $message]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}

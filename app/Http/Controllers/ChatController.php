<?php

namespace App\Http\Controllers;

use App\Events\StartVideoChat;
use App\Events\UserLifeEvent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class ChatController extends Controller
{
    
    public function index(Request $request)
    {
        $user = $request->user();
        $others = User::where('id', '!=', $user->id)->get();
        
        return view('chats.chat')->with([
            'user' => collect($request->user()),
            'others' => $others
        ]);
    }

    public function videoChat(Request $request)
    {
        $user = $request->user();
        $socket_id = $request->socket_id;
        $channel_name = $request->channel_name;
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            [
                'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                'encrypted' => true
            ]
        );
        return response(
            $pusher->presence_auth($channel_name, $socket_id, $user->id)
        );
    }

    public function callUser(Request $request)
    {
        $data['userToCall'] = $request->user_to_call;
        $data['signalData'] = $request->signal_data;
        $data['from'] = Auth::id();
        $data['type'] = 'incomingCall';

        broadcast(new StartVideoChat($data,$request->user_to_call))->toOthers();
    }
    public function acceptCall(Request $request)
    {
        $data['signal'] = $request->signal;
        $data['to'] = $request->to;
        $data['from'] = $request->from;
        $data['type'] = 'callAccepted';
        broadcast(new StartVideoChat($data,$request->to))->toOthers();
    }

    public function callUserLife(Request $request)
    {
        $data['signalData'] = $request->signal_data;
        $data['from'] = Auth::id();
        $data['type'] = 'incomingCall';
        broadcast(new UserLifeEvent($data))->toOthers();
    }
}

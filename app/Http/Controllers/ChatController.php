<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    
    public function index(Request $request)
    {
        $user = $request->user();
        $others = User::where('id', '!=', $user->id)->pluck('name', 'id');
        
        return view('chats.chat')->with([
            'user' => collect($request->user()->only(['id', 'name'])),
            'others' => $others
        ]);
    }
}

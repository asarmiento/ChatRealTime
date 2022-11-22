<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Models\User;
use App\Models\UserTemporal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use function Symfony\Component\String\s;

class ChatController extends Controller
{


    public function chat()
    {

            return view('chat');

    }

    public function send(Request $request)
    {
        $user = User::find(Auth::id());
        $this->saveToSession($request);
        event(new ChatEvent($request->get('message'), $user));
    }

/*    public function send()
    {
        $message='Hola';
        $user = UserTemporal::find(session::get('userId'));
        event(new ChatEvent($message, $user));
    }*/

    public function storeRegister(Request $request)
    {
        $user = User::where('email', $request->email);
        if ($user->count() == 0) {
            $data = $request->all();
            $data['password'] = bcrypt('password');
            $user = new User;
            $user->fill($data);
            if ($user->save()) {

                return $user;
            }
        }


    }

    public function saveToSession(request $request)
    {
        session()->put('chat',$request->chat);
    }

    public function getOldMessage()
    {
        return session('chat');
    }

    public function deleteSession()
    {
        session()->forget('chat');
    }
}

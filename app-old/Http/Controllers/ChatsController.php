<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;
use App\Models\Group;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('chats');
    }

    public function fetchMessages()
    {
        return Message::with('user')->where('group_id', 0)->get();
    }

    public function fetchGroupMessages($id)
    {
        return Message::with('user')->where('group_id', $id)->get();
    }

    public function fetchUserMessages($id)
    {
        return Message::with('user')->where('receiver_id', $id)->get();
    }


    public function fetchGroups()
    {
        return Group::all();
    }

    public function fetchGroupUsers($id)
    {
        $group = Group::findOrFail($id);
        return $group->users;

       /*  @foreach($group->users()->pluck('name')->toArray() as $key=>$name)
                            <li>{{ $name }}</li>
                            @endforeach */
    }

    public function sendMessage(Request $request)
    {
        $message = auth()->user()->messages()->create([
            'message' => $request->message,
            'group_id' => $request->group,
            'receiver_id' => $request->user
        ]);

        broadcast(new MessageSent($message->load('user')))->toOthers();

        return ['status' => 'success'];
    }
}

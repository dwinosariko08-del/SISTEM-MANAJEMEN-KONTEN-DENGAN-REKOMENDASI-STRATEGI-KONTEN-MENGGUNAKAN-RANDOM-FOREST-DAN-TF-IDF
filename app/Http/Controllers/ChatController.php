<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;

class ChatController extends Controller
{

    // ==============================
    // LIST USER CHAT
    // ==============================

    public function index()
    {

        $users = User::where('id','!=',Auth::id())
        ->get()
        ->map(function($user){

            $conversation = Conversation::where(function($q) use ($user){
                $q->where('user_one',Auth::id())
                ->where('user_two',$user->id);
            })
            ->orWhere(function($q) use ($user){
                $q->where('user_one',$user->id)
                ->where('user_two',Auth::id());
            })
            ->first();

            $lastMessage = null;
            $unread = 0;

            if($conversation){

                $lastMessage = Message::where('conversation_id',$conversation->id)
                ->latest()
                ->first();

                $unread = Message::where('conversation_id',$conversation->id)
                ->where('sender_id',$user->id)
                ->whereNull('read_at')
                ->count();

            }

            $user->last_message = $lastMessage->message ?? null;
            $user->unread = $unread;

            return $user;

        });

        return view('chat.index', compact('users'));

    }



    // ==============================
    // OPEN CHAT
    // ==============================

    public function openChat($id)
    {

        $user = User::findOrFail($id);

        // sidebar users
        $users = User::where('id','!=',Auth::id())
        ->get()
        ->map(function($u){

            $conversation = Conversation::where(function($q) use ($u){
                $q->where('user_one',Auth::id())
                ->where('user_two',$u->id);
            })
            ->orWhere(function($q) use ($u){
                $q->where('user_one',$u->id)
                ->where('user_two',Auth::id());
            })
            ->first();

            $lastMessage = null;
            $unread = 0;

            if($conversation){

                $lastMessage = Message::where('conversation_id',$conversation->id)
                ->latest()
                ->first();

                $unread = Message::where('conversation_id',$conversation->id)
                ->where('sender_id',$u->id)
                ->whereNull('read_at')
                ->count();

            }

            $u->last_message = $lastMessage->message ?? null;
            $u->unread = $unread;

            return $u;

        });


        // find conversation
        $conversation = Conversation::where(function($q) use ($id){
            $q->where('user_one',Auth::id())
            ->where('user_two',$id);
        })
        ->orWhere(function($q) use ($id){
            $q->where('user_one',$id)
            ->where('user_two',Auth::id());
        })
        ->first();


        // create if not exists
        if(!$conversation){

            $conversation = Conversation::create([
                'user_one'=>Auth::id(),
                'user_two'=>$id
            ]);

        }


        // mark messages as read
        Message::where('conversation_id',$conversation->id)
        ->where('sender_id','!=',Auth::id())
        ->whereNull('read_at')
        ->update([
            'read_at'=>now()
        ]);


        $messages = Message::where('conversation_id',$conversation->id)
        ->with('user')
        ->get();


        return view('chat.chat',compact(
            'conversation',
            'messages',
            'user',
            'users'
        ));

    }



    // ==============================
    // SEND MESSAGE
    // ==============================

    public function send(Request $request)
    {

        $fileName = null;

        if($request->hasFile('file')){

            $file = $request->file('file');

            $fileName = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('chat_files'),$fileName);

        }


        Message::create([
            'conversation_id'=>$request->conversation_id,
            'sender_id'=>Auth::id(),
            'message'=>$request->message,
            'file'=>$fileName
        ]);


        return response()->json([
            'status'=>'success'
        ]);

    }



    // ==============================
    // FETCH REALTIME MESSAGE
    // ==============================

    public function fetchMessages($conversation_id)
    {

        $messages = Message::where('conversation_id',$conversation_id)
        ->with('user')
        ->get();

        return response()->json($messages);

    }

}
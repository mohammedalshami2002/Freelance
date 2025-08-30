<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;
use App\Traits\UploadTrait;

class ChatController extends Controller
{
    use UploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chats = Chat::where('first_user', auth()->id())->orWhere('second_user', auth()->id())->paginate(10);
        return view('Dashboard.service_provider.chat.index', compact('chats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function sendMessage(StoreChatRequest $request, Chat $chat)
    {
        
        $messageData = $request->validated();
        if ($request->type != 1) {
            $filePath = $this->uploadImage($request->file('content'), 'uploads/messages');

            if ($filePath == false) {
                // فشل التحميل
                return redirect()->back()->withErrors(['error' => trans('meesage.Failed_to_upload_image')]);
            }
            $messageData['content'] = $filePath;
        }
        if($chat->addMessage($messageData)){
            return back()->with(['message' => trans('Dashboard.chat.messageIsSent')]);
        } else {
            return back()->with(['message' => trans('Dashboard.chat.failedToSent')]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        $chat->messages;
        return view('Dashboard.service_provider.chat.show', compact('chat'));
    }

    public function getNewMessages(Chat $chat, int $lastMessage)
    {
        $newMessages = $chat->messages()->where('id', '>', $lastMessage)->get();
        if($newMessages->count() > 0){
            return response()->json(['status' => true, 'messages' => $newMessages]);
        } else {
            return response()->json(['status' => false, 'message' => trans('Dashboard.no_messages')]);
        }
    }
}

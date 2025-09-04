<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class MeetingController extends Controller
{
    public function createMeeting($chatId)
    {
        $chat = Chat::findOrFail($chatId);

        $messageData = [
            'type'    => 5, 
            'content' => 'https://meet.jit.si/' . Str::random(15),
        ];

        $chat->addMessage($messageData);

        return redirect()->back();
    }
}

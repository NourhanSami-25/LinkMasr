<?php

namespace App\Http\Controllers\common;

use App\Http\Controllers\Controller;
use App\Models\common\Discussion;
use App\Models\common\DiscussionMessage;
use App\Http\Requests\common\DiscussionMessageRequest;
use Illuminate\Http\Request;


class DiscussionMessageController extends Controller
{
    public function index(Request $request)
    {
        $discussion = Discussion::findOrFail($request->discussion_id);
        return response()->json($discussion->messages()->with('user')->get());
    }

    public function store(DiscussionMessageRequest $request)
    {
        $message = DiscussionMessage::create([
            'discussion_id' => $request->discussion_id,
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return response()->json($message->load('user'));
    }

    public function destroy(DiscussionMessage $message)
    {
        if ($message->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->delete();
        return response()->json(['status' => 'deleted']);
    }
}

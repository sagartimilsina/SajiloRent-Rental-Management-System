<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\MessageSent;
use App\Models\MessageChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MessageChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $users = User::where('id', '!=', Auth::user()->id)->paginate(10);

        return view('frontend.message.index', compact('users'));
    }
    public function getUserChat($userId)
    {
        $user = User::findOrFail($userId);

        // Get both sent and received messages, and order by created_at to maintain time order.
        $messages = MessageChat::where(function ($query) use ($userId) {
            $query->where('user_id_from', $userId)
                ->orWhere('user_id_to', $userId);
        })
            ->orderBy('created_at', 'asc') // Ensures oldest messages are at the top
            ->get();

        $html = '';

        // Loop through all messages, check if it's sent by you or received by you.
        foreach ($messages as $message) {
            $isSender = $message->user_id_from == auth()->id(); // Assuming logged-in user is the sender
            $html .= $this->generateMessageHTML($isSender ? 'You' : $user->name, $message->message, $message->created_at, $isSender);
        }

        return response()->json($html);  // Return the HTML directly as a JSON response
    }

    private function generateMessageHTML($userName, $messageText, $createdAt, $isSender)
    {
        // Right-side alignment for sender, left-side alignment for receiver
        $messageClass = $isSender ? 'bg-primary text-white' : 'bg-secondary text-white';  // Different styles for your messages and friend's messages
        $alignmentClass = $isSender ? 'text-end' : 'text-start';  // Align right if sender, left if receiver
        $justifyContent = $isSender ? 'end' : 'start';  // To justify content properly for sender or receiver

        // Begin the message HTML structure
        $html = '<div class="mb-1 ' . $alignmentClass . ' message-wrapper position-relative">
                <h5><small class="text-muted" style="font-size: 14px;">' . $userName . '</small></h5>
                <div class="hover-icons row d-flex align-items-center justify-content-' . $justifyContent . '">';

        // Conditionally add actions for the sender
        if ($isSender) {
            $html .= '<div class="hover-icons-actions d-flex col-1 justify-content-' . $justifyContent . ' align-items-center">
                    <button class="btn btn-light" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                    <ul class="dropdown-menu">
                        <li><button class="dropdown-item" onclick="deleteMessage(event)">Delete</button></li>
                    </ul>
                    <button class="btn btn-light" onclick="replyMessage(event)"><i class="fas fa-reply"></i></button>
                    <button class="btn btn-light" onclick="showEmojiPicker(event)"><i class="fas fa-heart"></i></button>
                  </div>';
        }

        // Add the message body (same for both sender and receiver)
        $html .= '<div class="message ' . $messageClass . ' p-2 rounded col-4">
                <p class="text-wrap mb-0">' . $messageText . '</p>
                <p class="small mb-0 p-1" style="font-size: 10px; text-align: ' . ($isSender ? 'end' : 'start') . ';">' . $createdAt->format('H:i A') . '</p>
              </div>';

        // Conditionally add actions for the receiver (if not sender)
        if (!$isSender) {
            $html .= '<div class="hover-icons-actions d-flex col-1 justify-content-' . $justifyContent . ' align-items-center">
                    <button class="btn btn-light" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                    <ul class="dropdown-menu">
                        <li><button class="dropdown-item" onclick="deleteMessage(event)">Delete</button></li>
                    </ul>
                    <button class="btn btn-light" onclick="replyMessage(event)"><i class="fas fa-reply"></i></button>
                    <button class="btn btn-light" onclick="showEmojiPicker(event)"><i class="fas fa-heart"></i></button>
                  </div>';
        }

        // Close the HTML structure
        $html .= '</div>
            </div>';

        return $html;
    }




    public function showChat($userId, $username, Request $request)
    {

        $selectedUserId = $request->input('selected_user_id');
        // log::info($selectedUserId);

        if ($selectedUserId) {
            session(['selectedUserId' => $selectedUserId]);
        }
        $users = User::where('id', '!=', Auth::user()->id)->get();
        $messages = MessageChat::where('user_id_from', $userId)->get();

        return view('frontend.message.index', ['users' => $users, 'selectedUserId' => session('selectedUserId'), 'messages' => $messages, 'username' => $username, 'userId' => $userId]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info($request->all());
        $message = new MessageChat();
        $message->user_id_from = $request->user_id_from;
        $message->user_id_to = $request->user_id_to;
        $message->message = $request->message;
        $message->save();

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['status' => 'success', 'message' => $message]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(MessageChat $messageChat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MessageChat $messageChat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MessageChat $messageChat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MessageChat $messageChat)
    {
        //
    }
}

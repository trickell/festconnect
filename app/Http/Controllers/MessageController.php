<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $sessionUser = session('user');
        if (!$sessionUser) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }
        $senderId = is_object($sessionUser) ? $sessionUser->getKey() : $sessionUser['id'];

        $data = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required_without:optConnectImg|string|nullable',
            'optConnectImg.*' => 'image|max:5120',
        ]);

        $images = [];
        if ($request->hasFile('optConnectImg')) {
            $files = $request->file('optConnectImg');
            if (!is_array($files))
                $files = [$files];

            foreach (array_slice($files, 0, 5) as $file) {
                $filename = time() . '_' . uniqid() . '.webp';
                $path = public_path('uploads/messages/' . $filename);
                if (!file_exists(public_path('uploads/messages'))) {
                    mkdir(public_path('uploads/messages'), 0755, true);
                }

                if ($this->convertToWebp($file, $path)) {
                    $images[] = 'uploads/messages/' . $filename;
                }
            }
        }

        try {
            $message = Message::create([
                'sender_id' => $senderId,
                'receiver_id' => $data['receiver_id'],
                'message' => $data['message'],
                'images' => $images,
            ]);

            // Notify Receiver
            $senderName = is_object($sessionUser) ? ($sessionUser->getAttribute('name') ?? 'User') : ($sessionUser['name'] ?? 'User');
            Notification::create([
                'user_id' => $data['receiver_id'],
                'type' => 'message',
                'data' => [
                    'message_id' => $message->id,
                    'sender_name' => $senderName,
                    'message_snippet' => substr($message->message, 0, 50) . (strlen($message->message) > 50 ? '...' : '')
                ]
            ]);

            return response()->json(['status' => 'success', 'message' => $message->load('sender')]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function getThreads()
    {
        $sessionUser = session('user');
        if (!$sessionUser)
            return response()->json([], 401);
        $userId = is_object($sessionUser) ? $sessionUser->getKey() : $sessionUser['id'];

        // Get all messages where user is sender or receiver, not soft-deleted
        $messages = Message::with(['sender', 'receiver'])
            ->where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)->orWhere('receiver_id', $userId);
            })
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'asc')
            ->get();

        $threads = [];
        foreach ($messages as $msg) {
            $partnerId = ($msg->sender_id == $userId) ? $msg->receiver_id : $msg->sender_id;
            $partner = ($msg->sender_id == $userId) ? $msg->receiver : $msg->sender;

            if (!isset($threads[$partnerId])) {
                $threads[$partnerId] = [
                    'partner' => $partner,
                    'messages' => [],
                    'unread_count' => 0
                ];
            }
            $threads[$partnerId]['messages'][] = $msg;
            if ($msg->receiver_id == $userId && !$msg->read_at) {
                $threads[$partnerId]['unread_count']++;
            }
        }

        $result = array_values($threads);

        return response()->json($result);
    }

    public function updateMessage(Request $request, $id)
    {
        $sessionUser = session('user');
        $userId = is_object($sessionUser) ? $sessionUser->getKey() : $sessionUser['id'];

        $message = Message::findOrFail($id);
        if ($message->sender_id != $userId)
            return response()->json(['status' => 'error'], 403);

        $message->update([
            'message' => $request->message,
            'is_edited' => true,
            'updated_at' => now()
        ]);

        return response()->json(['status' => 'success', 'message' => $message]);
    }

    public function deleteMessage($id)
    {
        $sessionUser = session('user');
        $userId = is_object($sessionUser) ? $sessionUser->getKey() : $sessionUser['id'];

        $message = Message::findOrFail($id);
        if ($message->sender_id != $userId)
            return response()->json(['status' => 'error'], 403);

        $message->update(['deleted_at' => now()]);
        return response()->json(['status' => 'success']);
    }

    public function markAsRead(Request $request)
    {
        $sessionUser = session('user');
        $userId = is_object($sessionUser) ? $sessionUser->getKey() : $sessionUser['id'];
        $partnerId = $request->partner_id;

        Message::where('receiver_id', $userId)
            ->where('sender_id', $partnerId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['status' => 'success']);
    }

    private function convertToWebp($file, $path)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $image = null;

        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($file->getRealPath());
                break;
            case 'png':
                $image = imagecreatefrompng($file->getRealPath());
                if ($image) {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }
                break;
            case 'gif':
                $image = imagecreatefromgif($file->getRealPath());
                break;
            case 'webp':
                $image = imagecreatefromwebp($file->getRealPath());
                break;
        }

        if ($image) {
            $result = imagewebp($image, $path, 80);
            imagedestroy($image);
            return $result;
        }
        return false;
    }
}

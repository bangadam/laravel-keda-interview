<?php

namespace App\Repositories\Message;

use App\Models\User;

class MessageRepository implements IMessageRepository
{
    public function getMyMessages($request): array {
        $data = auth()->user()->messages();

        $data = $data->with('sender')->orderBy('created_at', 'desc')->get();

        return $data->toArray();
    }

    public function doSendMessage($request): bool {

        // can't send message to yourself
        if ($request->receiver_id == auth()->user()->id) {
            throw new \Exception('You cannot send message to yourself');
        }

        // can't send message to non-existing user
        $receiver = User::find($request->receiver_id);
        if (!$receiver) {
            throw new \Exception('User not found');
        }

        // if user customer, can't send message to staff
        if (auth()->user()->userType->name == 'customer') {
            if ($receiver->userType->name == 'staff') {
                throw new \Exception('You cannot send message to staff');
            }
        }

        $message = $request->user()->messages()->create([
            'message' => $request->message,
            'receiver_id' => $request->receiver_id,
        ]);

        if ($message) {
            return true;
        }

        return false;
    }
}

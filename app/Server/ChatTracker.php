<?php

namespace App\Server;

use App\Chat;

class ChatTracker {

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function track()
    {
        if(!array_key_exists(28, $this->data) || $this->data[28] == NULL)
            return;

        $chatMsg = $this->data[28];

        if($chatMsg == NULL || $chatMsg == "" || strlen($chatMsg) == 0)
            return;

        $chat = new Chat();
        $chat->message = $chatMsg;
        $chat->save();
    }
}
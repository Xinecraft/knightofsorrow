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
        exit();
    }

    /*public static function FixForHTML2($html)
    {
        $html = str_ireplace("<", "&lt;",$html);
        $html = str_ireplace(">", "&gt;",$html);
        $html = str_ireplace("[B]", "[b]",$html);
        $html = str_ireplace("[b]", "</b><b>",$html);
        $html = str_ireplace("[\\B]", "[\\b]",$html);
        $html = str_ireplace("[\\b]", "</b>", $html );
        $html = str_ireplace("[I]", "[i]", $html );
        $html = str_ireplace("[i]", "</i><i>", $html );
        $html = str_ireplace("[\\I]", "[\\i]", $html );
        $html = str_ireplace("[\\i]", "</i>", $html );
        $html = str_ireplace("[U]", "[u]", $html );
        $html = str_ireplace("[u]", "</u><u>", $html );
        $html = str_ireplace("[\\U]", "[\\u]", $html );
        $html = str_ireplace("[\\u]", "</u>", $html );
        $html = str_ireplace("[C=", "[c=", $html );
        $html = str_ireplace("[\\C]", "[\\c]", $html );
    }*/
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viber extends Model
{
    private $url_api = "https://chatapi.viber.com/pa/";

    private $token = "495e2d834927d037-505cd4e2557e86ef-a718e5f93f594661";

    public function message_post
    (
        $from,          // ID администратора Public Account.
        array $sender,  // Данные отправителя.
        $text           // Текст.
    )
    {
        $data['from']   = $from;
        $data['sender'] = $sender;
        $data['type']   = 'text';
        $data['text']   = $text;
        return $this->call_api('post', $data);
    }

    private function call_api($method, $data)
    {
        $url = $this->url_api.$method;

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\nX-Viber-Auth-Token: ".$this->token."\r\n",
                'method'  => 'POST',
                'content' => json_encode($data)
            )
        );
        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        return json_decode($response);
    }
}

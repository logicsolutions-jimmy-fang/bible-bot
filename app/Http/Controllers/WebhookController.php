<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot\Constant\HTTPHeader;

class WebhookController extends Controller
{

    private $token = 'oquKUUZO1oX2p8LMV4V0fI1i8KmkYnhxf+jW6UxkNSk11qBcXW2kMS7X9e5fBl3GRjYZBpl3Q4qVGGP04cIuXnQzzKNO3+W+xo3EqGmqbbl/eE31uftzg6c2paeTekA4KXtELUEanhpIOze3RF7q3wdB04t89/1O/w1cDnyilFU=';
    private $secret = '8acbb1b97ad224edbb606c7af87fa7c0';


    public function __construct()
    {
        $this->httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($this->token);

        $this->bot = new \LINE\LINEBot($this->httpClient, ['channelSecret' => $this->secret]);
    }

    public function index(Request $request)
    {
        // Log::info($request->all());

        $events = $request['events'];

        foreach ($events as $event) {
            // Log::info($event['replyToken']);
            $resp = $this->bot->replyText($event['replyToken'], 'Hello Restart Bot');
        }
        return '';
    }
}

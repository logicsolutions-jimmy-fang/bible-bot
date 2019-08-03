<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot\Constant\HTTPHeader;
use App\Services\LineBotService;
use App\Services\DailyVerseService;
use App\Services\WebhookResponseService;

class WebhookController extends Controller
{

    private $token = '';
    private $secret = '';



    public function __construct(DailyVerseService $dailyVerse,WebhookResponseService $responseService)
    {
        $this->token = env('LINEBOT_TOKEN');
        $this->secret = env('LINEBOT_SECRET');

        $this->httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($this->token);

        $this->bot = new \LINE\LINEBot($this->httpClient, ['channelSecret' => $this->secret]);
        $this->dailyVerse = $dailyVerse;
        $this->responseService = $responseService;
    }

    public function index(Request $request)
    {
        Log::info("Request from Line",$request->all());

        $events = $request['events'];

        foreach ($events as $event) {

            $this->bot->replyText(
                $event['replyToken'],
                $response = $this->responseService->returnResponse($event)
            );
        }

        return $response;
    }
}

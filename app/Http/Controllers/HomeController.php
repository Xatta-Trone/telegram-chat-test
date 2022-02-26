<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use BotMan\BotMan\BotManFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Telegram\Bot\Laravel\Facades\Telegram;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\Drivers\Telegram\TelegramDriver;

class HomeController extends Controller
{
    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::loginUsingId($user->id);

        return redirect()->route('profile');
    }

    public function login(Request $request)
    {
        $user =  User::where('phone', $request->phone)->get()->first();
        Auth::loginUsingId($user->id);
        return redirect()->route('profile');
    }


    public function tbot()
    {
        $fname = request()->first_name;
        $lanme = request()->last_name;
        $tid = request()->id;

        $config = [
            "telegram" => [
                "token" => env('TELEGRAM_TOKEN')
            ]
        ];

        // Create an instance
        $botman = BotManFactory::create($config);
        $botman->on(TelegramDriver::LOGIN_EVENT, function ($data, $bot) {
            $castID = request()->get('id', null);

            // dd($castID, $data, $bot);
            // update cast telegram id
            if ($castID) {
                Auth::user()->update(['t_user_id' => $castID]);
                $bot->reply('Hello ' . $data['first_name'] . '! Thank you for logging in!  please type /start to start interacting with us.');
            } else {
                return 'some error occurred';
            }
        });
        // Start listening
        $botman->listen();


        return redirect()->route('profile');
    }


    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->hears('{message}', function ($botman, $message) {

            if ($message == 'hi') {
                $this->askName($botman);
            } else {
                $botman->reply("write 'hi' for testing...");
            }
        });

        $botman->listen();
    }

    /**
     * Place your BotMan logic here.
     */
    public function askName($botman)
    {
        $botman->ask('Hello! What is your Name?', function (Answer $answer) {

            $name = $answer->getText();

            $this->say('Nice to meet you ' . $name);
        });
    }

    public function sendmsg()
    {
        Telegram::sendMessage([
            'chat_id' => auth()->user()->t_chat_id,
            'text' => 'Account successfully connected.',
        ]);
    }


    public function configtelegram(Request $request)
    {
        $updates = Telegram::commandsHandler(true);
        $chat_id = $updates->getChat()->getId();
        $user_id = array_key_exists('from', $updates['message']) ?  $updates['message']['from']['id'] : null;
        $update = User::where('t_user_id', $user_id)->get()->first()->update(['t_chat_id' => $chat_id]);
        if ($update) {
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => "$user_id: Account successfully connected.",
            ]);
        }
    }
}
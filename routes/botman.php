<?php

$botman = resolve('botman');

$botman->hears('foo', function ($bot) {
    $bot->reply('bar');
});


$botman->listen();
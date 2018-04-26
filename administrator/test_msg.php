<?php
// Required if your environment does not handle autoloading
include 'vendor/autoload.php';

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

// Your Account SID and Auth Token from twilio.com/console
$sid = 'AC192d5c3baa6e3d81e3dc00d759413867';
$token = 'ff24340d02dec1e794fde914b315a4de';
$client = new Client($sid, $token);

// Use the client to do fun stuff like send text messages!
$client->messages->create(
    // the number you'd like to send the message to
    '+918017643873',
    array(
        // A Twilio phone number you purchased at twilio.com/console
        'from' => '+18589237455',
        // the body of the text message you'd like to send
        'body' => 'Hey Jenny! Good luck on the bar exam!'
    )
);

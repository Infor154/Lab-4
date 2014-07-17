<?php



       require_once('TwitterAPIExchange.php');
             
       $settings = array(
    'oauth_access_token' => "259392968-J19sEoQuhIJDa5EdmPzJQdxtM4wQgmWAUhORLsxf",
    'oauth_access_token_secret' => "sKkPBFnJdVuewNbenzX92VJyIyd7SPY14c7vh9HX25P1x",
    'consumer_key' => "5Mxg8hTW6bXmi7AXlbmBIXHg1",
    'consumer_secret' => "HevfmignG9EksUAg5IqSvVKdzBBoB4LTA1FBn7lnTsmXcn5ECx"
);


$url = 'https://api.twitter.com/1.1/account/verify_credentials.json';
$getfield = '?q=#nerd';
$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();

var_dump(json_decode($response));